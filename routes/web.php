<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/upload', [ImageController::class, 'index'])->name('image.upload');
Route::post('/upload', [ImageController::class, 'upload'])->name('image.upload.post');
Route::get('/show', [ImageController::class, 'showImages'])->name('images.show');
Route::get('/images/download-zip/{id}', [ImageController::class, 'downloadZip'])->name('images.downloadZip');



