<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/downloads/{post}', [PostController::class, 'download'])->name('download');
Route::get('/downloads', [PostController::class, 'downloads'])->name('downloads');
Route::get('/download-all-media', [PostController::class, 'downloadAllMedia'])->name('download_all_media');

Route::resource('/posts', PostController::class);
