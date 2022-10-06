<?php

use App\Http\Controllers\System\DashBoardController;
use App\Http\Controllers\System\LoginController;
use App\Http\Controllers\System\PermissionController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\UserController;
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

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::group(['middleware' => 'auth'], function ($route) {
        $route->get('/dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');
        $route->get('/logout', [DashBoardController::class, 'logout'])->name('admin.logout');
        $route->resource('/roles', RoleController::class);
        $route->resource('/permissions', PermissionController::class);
        $route->resource('/users', UserController::class);
    });
});
