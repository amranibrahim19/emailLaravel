<?php

use App\Http\Controllers\EmailController;
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

Route::get('/email', [EmailController::class, 'index'])->name('email.index');
Route::post('/email', [EmailController::class, 'send'])->name('email.send');

// Send Email
Route::post('/email/send', [EmailController::class, 'email'])->name('email.post');
