<?php

use App\Http\Controllers\UserEmailController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');

    return view('email.index');
});

Route::get('user-email/data', [UserEmailController::class, 'getEmailUser'])->name('user-email.data');
Route::get('user-email/show/{id}', [UserEmailController::class, 'show'])->name('user-email.show');
Route::post('user-email/update/{id}', [UserEmailController::class, 'update'])->name('user-email.update');
Route::get('user-email/delete/{id}', [UserEmailController::class, 'destroy'])->name('user-email.delete');

Route::post('send/bulk', [UserEmailController::class, 'sendBulk'])->name('send.bulk');

Route::post('upload', [UserEmailController::class, 'upload'])->name('upload');
