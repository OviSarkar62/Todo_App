<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return view('welcome');
});


// User Registration Routes
Route::get('/register/user', [AuthController::class, 'createUser'])->name('create.user');
Route::post('/register/user', [AuthController::class, 'storeUser'])->name('store.user');
// User Login Routes
Route::view('/login', 'user.user-login')->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//-----------------------------User Dashboard------------------------------------------------
// Dashboard
Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
//----------------------------------Todos-----------------------------------------------------
// Create Todos
Route::get('/todo/create', [UserController::class, 'createTodo'])->name('create.todo');
// List Todos
Route::get('/todo/list', [UserController::class, 'todoList'])->name('list.todo');
// Store Todos
Route::post('/todo', [UserController::class, 'storeTodo'])->name('store.todo');
// Edit Todos
Route::get('/todo/edit/{id}', [UserController::class, 'editTodo'])->name('edit.todo');
// Update Todos
Route::put('/todo/{id}', [UserController::class, 'updateTodo'])->name('update.todo');
// Delete Todos
Route::delete('/todo/{id}', [UserController::class, 'destroyTodo'])->name('destroy.todo');
// Mark-Done
Route::put('/todos/toggle/{id}', [UserController::class, 'toggleStatus'])->name('todos.toggleStatus');

