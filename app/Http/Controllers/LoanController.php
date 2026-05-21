<?php

namespace App\Http\Controllers;

use App\Models\BookItem;
use App\Models\FinePayment;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Member;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Menampilkan daftar transaksi peminjaman.
     */
    public function index()
    {
        $loans = Loan::with(['member.studentClass', 'handler', 'loanItems.bookItem.book'])
            ->latest()
            ->get();

        return view('pustakawan.loans.index', compact('loans'));
    }

    /**
     * Menampilkan form peminjaman baru.
     */
    public function create()
    {
        $members = Member::with('studentClass')
            ->where('status', 'aktif')
            ->orderBy('name')
            ->get();

        $bookItems = BookItem::with('book')
            ->where('status', 'tersedia')
            ->where('condition', 'baik')
            ->whereHas('book', function ($query) {
                $query->where('is_borrowable', true);
            })
            ->orderBy('item_code')
            ->get();

        $classes = StudentClass::orderBy('level', 'asc')->get();

        return view('pustakawan.loans.create', compact('members', 'bookItems', 'classes'));
    }

    /**
     * Menyimpan transaksi peminjaman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_item_ids' => 'required|array',
            'book_item_ids.*' => 'nullable|exists:book_items,id',
        ]);

        $bookItemIds = collect($request->book_item_ids)
            ->filter()
            ->values();

        if ($bookItemIds->count() < 1) {
            return back()
                ->withInput()
                ->withErrors(['book_item_ids' => 'Minimal pilih 1 buku untuk dipinjam.']);
        }

        if ($bookItemIds->count() > 3) {
            return back()
                ->withInput()
                ->withErrors(['book_item_ids' => 'Maksimal peminjaman adalah 3 buku.']);
        }

        if ($bookItemIds->count() !== $bookItemIds->unique()->count()) {
            return back()
                ->withInput()
                ->withErrors(['book_item_ids' => 'Buku yang sama tidak boleh dipilih lebih dari satu kali.']);
        }

        $member = Member::findOrFail($request->member_id);

        if ($member->status !== 'aktif') {
            return back()
                ->withInput()
                ->withErrors(['member_id' => 'Anggota nonaktif tidak boleh meminjam buku.']);
        }

        $hasActiveLoan = Loan::where('member_id', $member->id)
            ->whereIn('status', ['aktif', 'terlambat'])
            ->exists();

        if ($hasActiveLoan) {
            return back()
                ->withInput()
                ->withErrors(['member_id' => 'Anggota masih memiliki pinjaman aktif. Harap kembalikan buku terlebih dahulu sebelum meminjam lagi.']);
        }

        $bookItems = BookItem::with('book')
            ->whereIn('id', $bookItemIds)
            ->get();

        foreach ($bookItems as $bookItem) {
            if ($bookItem->status !== 'tersedia') {
                return back()
                    ->withInput()
                    ->withErrors(['book_item_ids' => "Buku {$bookItem->item_code} tidak tersedia untuk dipinjam."]);
            }

            if ($bookItem->condition !== 'baik') {
                return back()
                    ->withInput()
                    ->withErrors(['book_item_ids' => "Buku {$bookItem->item_code} tidak dalam kondisi baik."]);
            }

            if (!$bookItem->book || !$bookItem->book->is_borrowable) {
                return back()
                    ->withInput()
                    ->withErrors(['book_item_ids' => "Buku {$bookItem->item_code} hanya boleh dibaca di tempat dan tidak bisa dipinjam."]);
            }
        }

        try {
            DB::transaction(function () use ($member, $bookItems) {
                $loan = Loan::create([
                    'loan_code' => 'TRX-' . now()->format('Ymd-His') . '-' . random_int(1000, 9999),
                    'member_id' => $member->id,
                    'loan_date' => today()->toDateString(),
                    'due_date' => today()->addDays(3)->toDateString(),
                    'status' => 'aktif',
                    'handled_by' => Auth::id(),
                ]);

                foreach ($bookItems as $bookItem) {
                    LoanItem::create([
                        'loan_id' => $loan->id,
                        'book_item_id' => $bookItem->id,
                        'renewal_count' => 0,
                        'late_days' => 0,
                        'fine_amount' => 0,
                        'status' => 'dipinjam',
                    ]);

                    $bookItem->update([
                        'status' => 'dipinjam',
                    ]);
                }
            });

            return redirect()
                ->route('loans.index')
                ->with('success', 'Transaksi peminjaman berhasil disimpan.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan transaksi peminjaman: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan detail transaksi peminjaman.
     */
    public function show(Loan $loan)
    {
        $loan->load(['member.studentClass', 'handler', 'loanItems.bookItem.book', 'loanItems.finePayment']);

        return view('pustakawan.loans.show', compact('loan'));
    }

    /**
     * Menampilkan form pengembalian buku.
     */
    public function edit(Loan $loan)
    {
        $loan->load(['member.studentClass', 'loanItems.bookItem.book']);

        return view('pustakawan.loans.edit', compact('loan'));
    }

    /**
     * Memproses pengembalian buku.
     */
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.return_condition' => 'required|in:baik,rusak ringan,rusak berat,hilang',
        ]);

        $today = Carbon::today();
        $dueDate = Carbon::parse($loan->due_date)->startOfDay();
        $finePerDay = 500;

        try {
            DB::transaction(function () use ($request, $loan, $today, $dueDate, $finePerDay) {
                foreach ($request->items as $loanItemId => $data) {
                    $loanItem = LoanItem::with('bookItem')
                        ->where('loan_id', $loan->id)
                        ->where('id', $loanItemId)
                        ->first();

                    if (!$loanItem) {
                        continue;
                    }

                    if (!in_array($loanItem->status, ['dipinjam', 'terlambat'])) {
                        continue;
                    }

                    $returnCondition = $data['return_condition'];

                    $lateDays = $today->gt($dueDate)
                        ? $dueDate->diffInDays($today)
                        : 0;

                    $fineAmount = $lateDays * $finePerDay;

                    $bookItemStatus = match ($returnCondition) {
                        'baik' => 'tersedia',
                        'hilang' => 'hilang',
                        default => 'rusak',
                    };

                    $loanItemStatus = match ($returnCondition) {
                        'hilang' => 'hilang',
                        'rusak ringan', 'rusak berat' => 'rusak',
                        default => $lateDays > 0 ? 'terlambat' : 'dikembalikan',
                    };

                    $loanItem->update([
                        'return_date' => $today->toDateString(),
                        'late_days' => $lateDays,
                        'fine_amount' => $fineAmount,
                        'return_condition' => $returnCondition,
                        'status' => $loanItemStatus,
                    ]);

                    $loanItem->bookItem->update([
                        'status' => $bookItemStatus,
                        'condition' => $returnCondition,
                    ]);

                    if ($fineAmount > 0) {
                        FinePayment::updateOrCreate(
                            ['loan_item_id' => $loanItem->id],
                            [
                                'amount' => $fineAmount,
                                'payment_status' => 'belum dibayar',
                                'received_by' => null,
                                'notes' => 'Denda keterlambatan pengembalian buku.',
                            ]
                        );
                    }
                }

                $hasUnreturnedItems = $loan->loanItems()
                    ->whereIn('status', ['dipinjam', 'terlambat'])
                    ->exists();

                $loan->update([
                    'status' => $hasUnreturnedItems ? 'aktif' : 'selesai',
                ]);
            });

            return redirect()
                ->route('loans.index')
                ->with('success', 'Pengembalian buku berhasil diproses.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memproses pengembalian: ' . $e->getMessage()]);
        }
    }

    /**
     * Membatalkan transaksi tanpa menghapus riwayat.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->status === 'selesai') {
            return back()->withErrors(['error' => 'Transaksi yang sudah selesai tidak dapat dibatalkan.']);
        }

        try {
            DB::transaction(function () use ($loan) {
                $loan->load('loanItems.bookItem');

                foreach ($loan->loanItems as $item) {
                    if ($item->bookItem && in_array($item->status, ['dipinjam', 'terlambat'])) {
                        $item->bookItem->update([
                            'status' => 'tersedia',
                        ]);

                        $item->update([
                            'status' => 'dikembalikan',
                            'notes' => 'Transaksi dibatalkan oleh pustakawan.',
                        ]);
                    }
                }

                $loan->update([
                    'status' => 'batal',
                ]);
            });

            return redirect()
                ->route('loans.index')
                ->with('success', 'Transaksi berhasil dibatalkan tanpa menghapus riwayat.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal membatalkan transaksi: ' . $e->getMessage()]);
        }
    }
}