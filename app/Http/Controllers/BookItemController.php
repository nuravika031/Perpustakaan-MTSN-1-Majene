<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookItemController extends Controller
{
    public function index()
    {
        $bookItems = BookItem::with(['book.category', 'book.ddcClass'])
            ->latest()
            ->get();

        return view('pustakawan.book_items.index', compact('bookItems'));
    }

    public function create()
    {
        $books = Book::with(['category', 'ddcClass'])
            ->orderBy('title')
            ->get();

        $itemMaxCopies = BookItem::select('book_id', DB::raw('MAX(copy_number) as max_copy'))
            ->groupBy('book_id')
            ->pluck('max_copy', 'book_id');

        $booksData = $books->map(function ($book) use ($itemMaxCopies) {
            $lastCopyNumber = (int) ($itemMaxCopies[$book->id] ?? 0);

            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publisher' => $book->publisher,
                'publication_year' => $book->publication_year,
                'category' => $book->category->name ?? '-',
                'ddc_code' => $book->ddcClass->code ?? '',
                'author_initial' => $this->makeAuthorInitial($book->author),
                'title_initial' => $this->makeTitleInitial($book->title),
                'next_index' => $lastCopyNumber + 1,
            ];
        })->values();

        return view('pustakawan.book_items.create', compact('books', 'booksData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'classification_code' => ['required', 'string', 'max:50'],
            'author_code' => ['required', 'string', 'max:50'],
            'title_code' => ['required', 'string', 'max:50'],
            'items' => ['required', 'array', 'min:1', 'max:200'],
            'items.*.copy_number' => ['required', 'integer', 'min:1'],
            'items.*.item_code' => ['required', 'string', 'max:100', 'distinct', 'unique:book_items,item_code'],
            'items.*.status' => ['required', Rule::in(['tersedia', 'dipinjam', 'rusak', 'hilang', 'nonaktif'])],
            'items.*.condition' => ['required', Rule::in(['baik', 'rusak ringan', 'rusak berat', 'hilang'])],
        ], $this->validationMessages(), $this->validationAttributes());

        $book = Book::findOrFail($validated['book_id']);

        DB::transaction(function () use ($validated) {
            foreach ($validated['items'] as $item) {
                BookItem::create([
                    'book_id' => $validated['book_id'],
                    'classification_code' => trim($validated['classification_code']),
                    'author_code' => trim($validated['author_code']),
                    'title_code' => trim($validated['title_code']),
                    'title_initial' => trim($validated['title_code']),
                    'copy_number' => (int) $item['copy_number'],
                    'item_code' => trim($item['item_code']),
                    'status' => $item['status'],
                    'condition' => $item['condition'],
                ]);
            }
        });

        return redirect()
            ->route('book_items.index')
            ->with('success_title', 'Eksemplar berhasil ditambahkan')
            ->with('success_message', count($validated['items']) . ' eksemplar buku "' . $book->title . '" berhasil ditambahkan.')
            ->with('success_detail', 'Kode eksemplar, nomor copy, status, dan kondisi buku sudah tersimpan.');
    }

    public function show(BookItem $bookItem)
    {
        $bookItem->load(['book.category', 'book.ddcClass']);

        return view('pustakawan.book_items.show', compact('bookItem'));
    }

    public function edit(BookItem $bookItem)
    {
        $books = Book::with(['category', 'ddcClass'])
            ->orderBy('title')
            ->get();

        $bookItem->load(['book.category', 'book.ddcClass']);

        return view('pustakawan.book_items.edit', compact('bookItem', 'books'));
    }

    public function update(Request $request, BookItem $bookItem)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'classification_code' => ['required', 'string', 'max:50'],
            'author_code' => ['required', 'string', 'max:50'],
            'title_code' => ['required', 'string', 'max:50'],
            'copy_number' => ['required', 'integer', 'min:1'],
            'item_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('book_items', 'item_code')->ignore($bookItem->id),
            ],
            'status' => ['required', Rule::in(['tersedia', 'dipinjam', 'rusak', 'hilang', 'nonaktif'])],
            'condition' => ['required', Rule::in(['baik', 'rusak ringan', 'rusak berat', 'hilang'])],
        ], $this->validationMessages(), $this->validationAttributes());

        $bookItem->update([
            'book_id' => $validated['book_id'],
            'classification_code' => trim($validated['classification_code']),
            'author_code' => trim($validated['author_code']),
            'title_code' => trim($validated['title_code']),
            'title_initial' => trim($validated['title_code']),
            'copy_number' => (int) $validated['copy_number'],
            'item_code' => trim($validated['item_code']),
            'status' => $validated['status'],
            'condition' => $validated['condition'],
        ]);

        return redirect()
            ->route('book_items.show', $bookItem)
            ->with('success_title', 'Eksemplar berhasil diperbarui')
            ->with('success_message', 'Data eksemplar "' . $bookItem->item_code . '" berhasil diperbarui.')
            ->with('success_detail', 'Perubahan data eksemplar sudah tersimpan.');
    }

    public function destroy(BookItem $bookItem)
    {
        $itemCode = $bookItem->item_code;

        $bookItem->delete();

        return redirect()
            ->route('book_items.index')
            ->with('success_title', 'Eksemplar berhasil dihapus')
            ->with('success_message', 'Eksemplar "' . $itemCode . '" berhasil dihapus dari sistem.')
            ->with('success_detail', 'Data tersebut tidak akan tampil lagi pada daftar eksemplar.');
    }

    private function makeAuthorInitial(?string $author): string
    {
        $letters = preg_replace('/[^a-zA-Z]/', '', $author ?? '');

        if (!$letters) {
            return 'Pen';
        }

        return ucfirst(strtolower(substr($letters, 0, 3)));
    }

    private function makeTitleInitial(?string $title): string
    {
        $letters = preg_replace('/[^a-zA-Z0-9]/', '', $title ?? '');

        if (!$letters) {
            return 'b';
        }

        return strtolower(substr($letters, 0, 1));
    }

    private function validationMessages(): array
    {
        return [
            'book_id.required' => 'Judul buku induk wajib dipilih.',
            'book_id.exists' => 'Buku induk yang dipilih tidak tersedia.',

            'classification_code.required' => 'Kode klasifikasi wajib diisi.',
            'author_code.required' => 'Kode penulis wajib diisi.',
            'title_code.required' => 'Kode judul wajib diisi.',

            'items.required' => 'Minimal satu data eksemplar wajib dibuat.',
            'items.array' => 'Format data eksemplar tidak valid.',
            'items.min' => 'Minimal satu data eksemplar wajib dibuat.',
            'items.max' => 'Maksimal 200 eksemplar dalam satu kali simpan.',

            'items.*.copy_number.required' => 'Nomor copy wajib diisi.',
            'items.*.copy_number.integer' => 'Nomor copy harus berupa angka.',
            'items.*.copy_number.min' => 'Nomor copy minimal 1.',

            'items.*.item_code.required' => 'Kode eksemplar wajib diisi.',
            'items.*.item_code.unique' => 'Kode eksemplar sudah digunakan. Silakan gunakan kode lain.',
            'items.*.item_code.distinct' => 'Kode eksemplar tidak boleh sama antar baris.',
            'items.*.item_code.max' => 'Kode eksemplar maksimal 100 karakter.',

            'items.*.status.required' => 'Status eksemplar wajib dipilih.',
            'items.*.status.in' => 'Status eksemplar yang dipilih tidak valid.',

            'items.*.condition.required' => 'Kondisi fisik wajib dipilih.',
            'items.*.condition.in' => 'Kondisi fisik yang dipilih tidak valid.',

            'copy_number.required' => 'Nomor copy wajib diisi.',
            'copy_number.integer' => 'Nomor copy harus berupa angka.',
            'copy_number.min' => 'Nomor copy minimal 1.',

            'item_code.required' => 'Kode eksemplar wajib diisi.',
            'item_code.unique' => 'Kode eksemplar sudah digunakan. Silakan gunakan kode lain.',
            'status.required' => 'Status eksemplar wajib dipilih.',
            'condition.required' => 'Kondisi fisik wajib dipilih.',
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'book_id' => 'Buku induk',
            'classification_code' => 'Kode klasifikasi',
            'author_code' => 'Kode penulis',
            'title_code' => 'Kode judul',
            'copy_number' => 'Nomor copy',
            'item_code' => 'Kode eksemplar',
            'status' => 'Status eksemplar',
            'condition' => 'Kondisi fisik',
            'items.*.copy_number' => 'Nomor copy',
            'items.*.item_code' => 'Kode eksemplar',
            'items.*.status' => 'Status eksemplar',
            'items.*.condition' => 'Kondisi fisik',
        ];
    }
}