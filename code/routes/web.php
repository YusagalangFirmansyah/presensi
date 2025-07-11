<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportingDaylogExportController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/coming-soon', function () {
    return view('comingsoon');
})->name('comingsoon');

// if ( Auth::user() && Auth::user()->role_id == 1 ) {
Route::get('/users', function () {
    return view('users-management');
})->middleware(['auth', 'verified'])->name('users');

Route::get('/roles', function () {
    return view('roles-management');
})->middleware(['auth', 'verified'])->name('roles');

Route::get('/categories', function () {
    return view('categories-management');
})->middleware(['auth', 'verified'])->name('categories');

Route::get('/divisions', function () {
    return view('divisions-management');
})->middleware(['auth', 'verified'])->name('divisions');
// }
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/absences', function () {
    return view('absen-management');
})->middleware(['auth', 'verified'])->name('absences');

Route::get('/logbooks', function () {
    return view('logbooks-management');
})->middleware(['auth', 'verified'])->name('logbooks');

Route::get('/pengajuan', function () {
    return view('pengajuans-management');
})->middleware(['auth', 'verified'])->name('pengajuan');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/absences', function () {
        return view('absen-admin-management');
    })->middleware(['auth', 'verified'])->name('admin-absences');
    // Route::get('/monitor-absences', function () {
    //     return view('monitoring-absen');
    // })->middleware(['auth', 'verified'])->name('monitoring-absences');
    Route::get('/logbooks', function () {
        return view('logbooks-admin-management');
    })->middleware(['auth', 'verified'])->name('admin-logbooks');
    Route::get('/pengajuan', function () {
        return view('pengajuans-admin-management');
    })->middleware(['auth', 'verified'])->name('admin-pengajuan');
    Route::get('/report', function () {
        return view('reportings');
    })->middleware(['auth', 'verified'])->name('reportings');
});

// Tambahkan route export PDF di bawah ini
Route::get('/reporting-daylog/export/{id}', [ReportingDaylogExportController::class, 'exportUserDetail'])->middleware(['auth', 'verified'])->name('reporting-daylog.export');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
