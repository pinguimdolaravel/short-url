<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('api.short-url.store');
