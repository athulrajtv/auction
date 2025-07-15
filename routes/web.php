<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Guest\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('admin')->group(function () {
    Route::get('/', [LoginController::class, 'Login'])->name('login');

    // Protect the dashboard route with auth middleware
    Route::middleware(['auth:web'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
    });
});



Route::prefix('login')->group(function () {
    Route::get('/Registration', [LoginController::class, 'Register'])->name('admin.register');
    Route::post('/register', [LoginController::class, 'post_register'])->name('login.register');
    Route::post('/loginpage', [LoginController::class, 'post_login'])->name('admin.login');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.login.logout');
});

Route::prefix('Category')->group(function () {
    Route::get('/AddCategory', [CategoryController::class, 'Category'])->name('Category');
    Route::post('/create', [CategoryController::class, 'Create'])->name('admin.category.create');
    Route::get('/editpage/{id}', [CategoryController::class, 'Edit'])->name('admin.category.Edit');
    Route::post('/update/{id}', [CategoryController::class, 'Update'])->name('admin.category.update');
    Route::get('/delete/{id}', [CategoryController::class, 'Delete'])->name('admin.category.delete');
});

Route::prefix('Products')->group(function () {
    Route::get('/AddProducts/{id}', [ProductController::class, 'Product'])->name('Product');
    Route::post('/create', [ProductController::class, 'Create'])->name('admin.product.create');
    Route::get('/editpage/{id}', [ProductController::class, 'Edit'])->name('admin.product.Edit');
    Route::post('/update/{id}', [ProductController::class, 'Update'])->name('admin.product.update');
    Route::get('/delete/{id}', [ProductController::class, 'Delete'])->name('admin.product.delete');
});

Route::prefix('userlogin')->group(function () {
    Route::get('/Registration', [UserController::class, 'Register'])->name('register');
    Route::post('/register', [UserController::class, 'post_register'])->name('guest.register');
    Route::get('/logout', [UserController::class, 'logout'])->name('guest.login.logout');
});

Route::post('/bid/{id}', [ProductController::class, 'bid']);

Route::get('/', [UserController::class, 'Login'])->name('guest.login');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/index', [GuestController::class, 'Index'])->name('Index');
});



