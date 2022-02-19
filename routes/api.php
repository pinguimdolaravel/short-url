<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('api.short-url.store');
Route::delete('/short-urls/{shortUrl:code}', [ShortUrlController::class, 'destroy'])->name('api.short-url.destroy');
