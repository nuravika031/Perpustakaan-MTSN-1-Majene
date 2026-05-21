<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DdcClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\BookItem;
use App\Models\FinePayment;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal Sistem
|--------------------------------------------------------------------------
| Jika belum login, langsung masuk ke halaman login.
| Jika sudah login, langsung masuk ke dashboard.
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Redirect URL Lama
    |--------------------------------------------------------------------------
    */
    Route::get('/pustakawan/dashboard', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/kepala-sekolah/dashboard', function () {
        return redirect()->route('dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard Utama
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Pustakawan / Admin IT
        |--------------------------------------------------------------------------
        */
        if ($user->role_id == 1 || $user->role_id == 3) {
            $totalBooks = BookItem::count();

            $activeMembers = Member::where('status', 'aktif')->count();

            $loansToday = Loan::whereDate('loan_date', today())->count();

            $activeLoans = Loan::where('status', 'aktif')->count();

            $overdueLoansCount = Loan::where('status', 'aktif')
                ->whereDate('due_date', '<', today())
                ->count();

            $overdueLoanItems = LoanItem::with('loan')
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->whereHas('loan', function ($query) {
                    $query->where('status', 'aktif')
                        ->whereDate('due_date', '<', today());
                })
                ->get();

            $estimatedActiveFines = $overdueLoanItems->sum(function ($item) {
                if (!$item->loan || !$item->loan->due_date) {
                    return 0;
                }

                $lateDays = Carbon::parse($item->loan->due_date)
                    ->startOfDay()
                    ->diffInDays(today());

                return $lateDays * 500;
            });

            $unpaidFines = FinePayment::where('payment_status', 'belum dibayar')
                ->sum('amount');

            $estimatedFines = $estimatedActiveFines + $unpaidFines;

            $popularBooks = Book::withCount([
                    'bookItems as borrow_count' => function ($query) {
                        $query->join('loan_items', 'book_items.id', '=', 'loan_items.book_item_id');
                    }
                ])
                ->orderByDesc('borrow_count')
                ->limit(4)
                ->get();

            if ($popularBooks->isEmpty()) {
                $popularBooks = Book::latest()
                    ->limit(4)
                    ->get();
            }

            $recentLoans = Loan::with(['member', 'loanItems.bookItem.book'])
                ->latest()
                ->limit(5)
                ->get();

            return view('pustakawan.dashboard', compact(
                'totalBooks',
                'activeMembers',
                'loansToday',
                'activeLoans',
                'estimatedFines',
                'overdueLoansCount',
                'popularBooks',
                'recentLoans'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Kepala Sekolah
        |--------------------------------------------------------------------------
        */
        if ($user->role_id == 2) {
            $totalMembers = Member::where('status', 'aktif')->count();

            $totalBookItems = BookItem::count();

            $borrowedBooks = BookItem::where('status', 'dipinjam')->count();

            $problematicBooks = BookItem::whereIn('status', ['rusak', 'hilang'])->count();

            $activeLoans = Loan::where('status', 'aktif')->count();

            $overdueItems = LoanItem::whereIn('status', ['dipinjam', 'terlambat'])
                ->whereHas('loan', function ($query) {
                    $query->where('status', 'aktif')
                        ->whereDate('due_date', '<', today());
                })
                ->count();

            return view('kepala_sekolah.dashboard', compact(
                'totalMembers',
                'totalBookItems',
                'borrowedBooks',
                'problematicBooks',
                'activeLoans',
                'overdueItems'
            ));
        }

        abort(403, 'Role pengguna tidak memiliki akses dashboard.');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Fitur Perpustakaan
    |--------------------------------------------------------------------------
    */
    Route::resource('loans', App\Http\Controllers\LoanController::class);
    Route::resource('books', App\Http\Controllers\BookController::class);
    Route::resource('book_items', App\Http\Controllers\BookItemController::class);
    Route::resource('members', App\Http\Controllers\MemberController::class);
    Route::resource('classes', App\Http\Controllers\StudentClassController::class);

    /*
    |--------------------------------------------------------------------------
    | Master Data
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class);
    Route::resource('ddc', DdcClassController::class);

    /*
    |--------------------------------------------------------------------------
    | Manajemen User
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Profile Breeze
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';