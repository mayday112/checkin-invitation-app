<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CheckinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', EventController::class);
    
    Route::get('events/{event}/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::post('events/{event}/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::post('events/{event}/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::delete('guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('guests/{guest}/qr', [GuestController::class, 'downloadQr'])->name('guests.qr');

    Route::get('events/{event}/checkin', [CheckinController::class, 'scanner'])->name('checkin.scanner');
    Route::post('events/{event}/checkin', [CheckinController::class, 'process'])->name('checkin.process');
});

require __DIR__.'/auth.php';
