<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesReportController;

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

// Route::get('/', function () {
//     return view('pages.auth.auth-login', ['type_menu' => '']);
// })->name('login')->middleware('guest');

Route::get('/', function () {
    return view('pages.auth.auth-login', ['type_menu' => '']);
})->middleware('guest');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('home', function () {
    //     return view('pages.app.dashboard-pos', ['type_menu' => '']);
    // })->name('home');

    Route::get('home', [DashboardController::class, 'showDashboard'])->name('home');

    Route::get('dashboard-pos', [DashboardController::class, 'showDashboard'])->name('app.dashboard-pos');

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);

    Route::get('/report', [SalesReportController::class, 'index'])->name('report.index');
    Route::get('/report/filter', [SalesReportController::class, 'filter'])->name('report.filter');
    Route::get('/report/download', [SalesReportController::class, 'download'])->name('report.download');
    Route::get('/report/sales-report', [SalesReportController::class, 'salesReport'])->name('report.sales.report.data');
});

// Route::get('/register', function () {
//     //return view('welcome');
//     return view('pages.auth.auth-register', ['type_menu' => '']);
// })->name('register');
