<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quran; 


Route::get('/', [Quran::class, 'getsurahdata']);
Route::get('read/{surahnumber}', [Quran::class, 'getreaddata']);