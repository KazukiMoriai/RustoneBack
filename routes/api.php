<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::post('/photos', [PhotoController::class, 'store']); 