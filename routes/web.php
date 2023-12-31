<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserProgressGraphController;
use App\Http\Controllers\UserProgressChartController;





Route::group(['middleware' => 'disable_back_btn'], function () {
    
        
    Route::get('/', function () {
        return view('index');
    })->name('index');
    
    
    Route::get('/email_Verification', function () {
        return view('email_Verification');
    });
    Route::get('results', function () {
        return view('results');
    });
    
    
    // Route for sending the email verification form
    Route::get('/email_Verification/{token}', [EmailVerificationController::class, 'emailVerification'])->name('emailverification');
    
    // Route for processing the email form submission
    Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send-email');
    
    Route::get('/update/{gamer_id}', [UserController::class, 'showUpdateForm'])->name('update');
    
    // Route for processing the update form submission
    Route::post('/update/{gamer_id}', [UserController::class, 'updateUser'])->name('updateUser');
    
    // Redirect to the signin page after successful signup
    Route::get('/signin', [SignInController::class, 'showSignInForm'])->name('signin');
    Route::post('/signin', [SignInController::class, 'signIn']);
    
    Route::get('/homepage', [HomepageController::class, 'showHomepage'])->name('homepage');
    
    
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress');
    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });

    Route::get('/progress_graph', [UserProgressGraphController::class, 'showPieChart'])->name('progress_graph');

    Route::get('/progress_chart', [UserProgressChartController::class, 'showBarChart'])->name('progress_chart');

    Route::get('player_progress', function () {
        return view('player_progress');
    })->name('player_progress');