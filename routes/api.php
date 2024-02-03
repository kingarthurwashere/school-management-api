<?php

/**
 * @OA\Info(
 *     title="Your API Title",
 *     version="1.0",
 *     description="Description of your API",
 *     @OA\Contact(
 *         email="your.email@example.com",
 *         name="Your Name"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AdminController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

// Protected routes that require authentication
Route::middleware(['auth:api', 'jwt'])->namespace('App\Http\Controllers')->group(function () {
    // Logout route
    Route::post('logout', [AuthController::class, 'logout']);

    // CRUD routes using apiResource
    Route::apiResource('students', StudentController::class);
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('classrooms', ClassroomController::class);

    // Assign students to a classroom
    Route::post('/classrooms/{classroom}/assign-students', [ClassroomController::class, 'assignStudents']);

    // Assign teachers to a classroom
    Route::post('/classrooms/{classroom}/assign-teachers', [ClassroomController::class, 'assignTeachers']);

    // Additional routes for admin-specific operations
    Route::middleware('role:admin')->group(function () {
        Route::get('admin/dashboard', 'AdminController@dashboard');
    });
});
