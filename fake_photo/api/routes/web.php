<?php

use App\Http\Controllers\FakePhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(FakePhotoController::class)->group(function () {
    Route::get('/upload', 'show')->name('upload');
    Route::post('/upload', 'store')->name('store');
});
