<?php

use App\Http\Controllers\Web\InputCategories;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\InputBuildings;
use App\Http\Controllers\Web\InputBusinesses;
use App\Http\Controllers\Web\InputWebsites;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/input-category', [InputCategories::class, 'create']);
    Route::put('/input-category', [InputCategories::class, 'create']);
    Route::get('/', [InputCategories::class, 'index'])->name('category');

    Route::post('/input-business', [InputBusinesses::class, 'create']);
    Route::put('/input-business', [InputBusinesses::class, 'create']);
    Route::get('/business', [InputBusinesses::class, 'index'])->name('business');

    Route::post('/input-building', [InputBuildings::class, 'create']);
    Route::put('/input-building', [InputBuildings::class, 'create']);
    Route::get('/building', [InputBuildings::class, 'index'])->name('building');

    Route::post('/input-website', [InputWebsites::class, 'create']);
    Route::put('/input-website', [InputWebsites::class, 'create']);
    Route::get('/website', [InputWebsites::class, 'index'])->name('website');
});
require __DIR__ . '/auth.php';
