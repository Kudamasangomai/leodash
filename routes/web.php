<?php

use App\Http\Controllers\DistanceCalibrationController;
use App\Http\Controllers\FaultController;
use App\Http\Controllers\MovingReportController;
use App\Http\Controllers\MovingReportImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ViolationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {

    return Inertia::render('Dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/trucks/fetch', [TruckController::class, 'fetch'])->name('trucks.fetch');
    Route::resource('trucks', TruckController::class);

    Route::resource('faults', FaultController::class);

    Route::resource('dstcalibrations',DistanceCalibrationController::class);

    Route::get('/early-start', [MovingReportController::class , 'index'])->name('early-start');
    Route::post('/moving-report/upload', [MovingReportImportController::class, 'upload'])->name('moving-report.upload');
    Route::get('/early-start', [MovingReportController::class , 'index'])->name('early-start');

    Route::get('/repairs/fetchlocations', [RepairController::class, 'fetchLocations'])->name('fetchlocations');
    Route::put('/repairs/closerepair/{id}', [RepairController::class, 'closerepair'])->name('closerepair');
    Route::resource('repairs', RepairController::class);

    Route::post('/violations/upload', [ViolationController::class, 'upload'])->name('violations.upload');
    Route::get('/violations', [ViolationController::class , 'index'])->name('violations');

});

require __DIR__.'/auth.php';
