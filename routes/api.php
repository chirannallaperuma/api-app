<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CoursesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    // student routes
    Route::resource('students', '\App\Http\Controllers\API\V1\StudentsController')->only('index');

    // courses routes
    Route::resource('courses', '\App\Http\Controllers\API\V1\CoursesController')->only('index');
    Route::post('courses/enroll', [CoursesController::class, 'enrollCourse']);

    // student courses
    Route::get('student-courses', [CoursesController::class, 'studentCourses']);

    // logout
    Route::post('logout', [AuthController::class, 'logout']);
});
