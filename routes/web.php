<?php

use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use Illuminate\Database\Events\TransactionCommitting;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendMail']);
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

//ブログ
Route::get('/admin/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index')->middleware('auth');
Route::get('/admin/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
Route::post('/admin/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
Route::get('/admin/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit')->middleware('auth');
Route::put('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');


//ユーザー登録
Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');

//ログイン
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AuthController::class, 'login']);

//ログアウト
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

//transactionテスト
Route::get('/admin/transaction', [TransactionController::class, 'index'])->name('admin.transaction.index');
Route::post('/admin/transaction/success', [TransactionController::class, 'success'])->name('admin.transaction.success');
Route::post('/admin/transaction/exception', [TransactionController::class, 'exception'])->name('admin.transaction.exception');
Route::post('/admin/transaction/exception2', [TransactionController::class, 'exception2'])->name('admin.transaction.exception2');
