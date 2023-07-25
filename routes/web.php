<?php

use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [homeController::class, 'Home'])
->name('App_Home');

Route::get('/About', [homeController::class, 'About'])
->name('App_About');

Route::match(['get', 'post'], '/dashboard', [homeController::class, 'dashboard'])
->middleware('auth')
->name('App_dashboard');

Route::get('/logout', [loginController::class, 'logout'])
->name('App_logout');

Route::post('/exist_email', [loginController::class, 'existemail'])
->name('App_exist_email');

Route::match(['get', 'post'], '/activation_code/{token}', [loginController::class, 'ActivationCode'])
->name('App_activation_code');

Route::get('/User_checked', [loginController::class, 'Userchecked'])
->name('App_User_checked');

Route::get('/reset_activation_code/{token}', [loginController::class, 'ResetActivationCode'])
->name('App_reset_activation_code');

Route::get('/activation_account_link/{token}', [loginController::class, 'ActivationAccountLink'])
->name('App_activation_account_link');


Route::match(['get', 'post'], '/activation_account_change_email/{token}', [loginController::class, 'ActivationAccountChargeEmail'])
->name('App_activation_account_change_email');
