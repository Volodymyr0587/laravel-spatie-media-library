<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/downloads/{post}', [PostController::class, 'download'])->name('download');
Route::get('/downloads', [PostController::class, 'downloads'])->name('downloads');
Route::get('/download-all-media', [PostController::class, 'downloadAllMedia'])->name('download_all_media');
Route::get('/res-image/{post}', [PostController::class, 'resImage'])->name('res_image');

Route::resource('/posts', PostController::class);
