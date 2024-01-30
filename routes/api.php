<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Registration route
Route::post('register', [AuthController::class, 'register']);

// Authentication routes
Route::post('login', [AuthController::class, 'login']);

// Protected routes that require authentication
Route::middleware(['auth:api', 'jwt'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Resource routes
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classrooms', ClassroomController::class);

    // Additional routes for admin-specific operations
    Route::middleware('role:admin')->group(function () {
        Route::get('admin/dashboard', 'AdminController@dashboard');
    });
});
