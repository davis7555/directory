<?php

use App\Http\Controllers\Flutter\InputBuildings;
use App\Http\Controllers\Flutter\InputBusinesses;
use App\Http\Controllers\Flutter\InputCategories;
use App\Http\Controllers\Flutter\InputWebsites;
use Illuminate\Support\Facades\Route;

Route::post('/input-website', [InputWebsites::class, 'create']);
Route::put('/input-website', [InputWebsites::class, 'create']);
Route::get('/website', [InputWebsites::class, 'index']);

Route::post('/input-building', [InputBuildings::class, 'create']);
Route::put('/input-building', [InputBuildings::class, 'create']);
Route::get('/building', [InputBuildings::class, 'index']);

Route::post('/input-business', [InputBusinesses::class, 'create']);
Route::put('/input-business', [InputBusinesses::class, 'create']);
Route::get('/business', [InputBusinesses::class, 'index']);

Route::post('/input-category', [InputCategories::class, 'create']);
Route::put('/input-category', [InputCategories::class, 'create']);
Route::get('/category', [InputCategories::class, 'index']);
