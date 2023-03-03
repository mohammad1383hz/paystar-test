<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
// Route::middleware('guest')->group(function (){
//     Route::get('/', [HomeController::class,'index']);
//     Route::get('/register', [AuthController::class,'register']);
//     Route::post('/register', [AuthController::class,'create'])->name('register');
//     Route::get('/login', [AuthController::class,'loginview'])->name('view.login');
//     Route::post('/login', [AuthController::class,'authlogin'])->name('login');
// });
Route::get('/', [HomeController::class,'index'])->name('index');

Route::middleware('auth')->group(
    function () {
        Route::get('user/{user}', [UserController::class, 'edit'])->name('edit.user');
        Route::post('user/{user}', [UserController::class, 'update'])->name('update.user');
        Route::post('buy', [ProductController::class, 'buy'])->name('buy.product');
        Route::get('product', [ProductController::class, 'index'])->name('index.product');
        Route::post('callback', [ProductController::class, 'callback'])->name('callback.product');

    }
);
