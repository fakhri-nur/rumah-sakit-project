<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\BookingController;
use App\Models\Iklan;

// banner iklan
Route::get('/', function () {
    $iklans = Iklan::all();
    return view('home', compact('iklans'));
})->name('home');
// cari dokter
Route::get('/caridok', function () {
    $doctors = \App\Models\Dokter::with('user')->whereHas('user', function($q) {
        $q->where('role', 'dokter')->whereNull('deleted_at');
    })->get();
    return view('caridok', compact('doctors'));
})->name('caridok');
Route::get('/caridok/search', [DokterController::class, 'index'])->name('caridok.search');
// booking dokter
Route::get('/booking', [BookingController::class, 'form'])->name('booking.form');
Route::post('/booking-submit', [BookingController::class, 'submit'])->name('booking.submit');
Route::get('/receipt/{id}', [BookingController::class, 'receipt'])->name('receipt');
Route::get('/receipt/{id}/pdf', [BookingController::class, 'downloadPdf'])->name('receipt.pdf');


Route::middleware('isGuest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('/sign-up', function () {
        return view('signup');
    })->name('sign_up');

    Route::post('/sign-up', [UserController::class, 'signUp'])->name('sign_up.add');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Dokter
Route::middleware('isDokter')->prefix('/dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'dashboard'])->name('dashboard');
    Route::get('/edit-profile', [DokterController::class, 'editProfile'])->name('edit_profile');
    Route::put('/update-profile', [DokterController::class, 'updateProfile'])->name('update_profile');
});

// Admin
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // USERS
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [UserController::class, 'datatables'])->name('datatables');
    });

    // IKLAN
    Route::prefix('/iklan')->name('iklan.')->group(function () {
        Route::get('/', [IklanController::class, 'index'])->name('index');
        Route::get('/create', [IklanController::class, 'create'])->name('create');
        Route::post('/store', [IklanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [IklanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [IklanController::class, 'update'])->name('update');
        Route::patch('/deactivate/{id}', [IklanController::class, 'deactivate'])->name('deactivate');
        Route::delete('/delete/{id}', [IklanController::class, 'destroy'])->name('delete');
        Route::post('/toggle-active/{id}', [IklanController::class, 'toggleActive'])->name('toggle_active');
        Route::get('/export', [IklanController::class, 'export'])->name('export');
        Route::get('/trash', [IklanController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [IklanController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [IklanController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/datatables', [IklanController::class, 'datatables'])->name('datatables');
    });

    // DOKTER
    Route::prefix('/dokter')->name('dokter.')->group(function () {
        Route::get('/', [DokterController::class, 'indexDokter'])->name('index');
        Route::get('/create', [DokterController::class, 'create'])->name('create');
        Route::post('/store', [DokterController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [DokterController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [DokterController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DokterController::class, 'destroy'])->name('delete');

        Route::get('/trash', [DokterController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [DokterController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [DokterController::class, 'deletePermanent'])->name('delete_permanent');

        Route::get('/export', [DokterController::class, 'export'])->name('export');
    });

});

