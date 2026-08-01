<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', [ContactController::class, 'index']);
Route::post('/', [ContactController::class, 'store'])->name('contact.confirm');
Route::post('/contacts', [ContactController::class, 'thanks'])->name('contact.thanks');
