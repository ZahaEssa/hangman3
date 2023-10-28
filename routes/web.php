<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Mail\app\Mail\VerificationEmail;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\EmailVerificationController;

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
    return view('index');
});

Route::get('/email_Verification', function () {
    return view('email_Verification');
})->name('email_Verification');;

Route::get('/signup', 'App\Http\Controllers\SignupController@index')->name('signup');

Route::post('/update-user/{gamer_id}', [UserController::class, 'updateUser'])->name('update-user');

Route::post('/send-verification-email', [EmailVerificationController::class, 'sendVerificationEmail']);
Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verifyEmail']);


Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

Route::get('/signin', function () {
    return view('signin');
})->name('signin');

