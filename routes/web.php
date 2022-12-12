<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MclassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AdministrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| store         ->  create data in database
| destroy       ->  delete data in database
| authenticate  ->  check login request
| update        ->  update data in database
|
*/

// index, teacher and student sign in page
Route::get('/', function () {
    return view('index');
})->name('index_login');

// teacher login redirection
Route::get('/teacher/login', function () {
    return redirect('/?t=teacher');
})->name('teacher_login');

// student login redirection
Route::get('/student/login', function () {
    return redirect('/?t=student');
})->name('student_login');

// student sign up page
Route::get('/student/signup', function () {
    return view('student.student_signup');
});

// student confirm email
Route::get('/student/email-signup', function () {
    return view('student.email-signup');
});

// terms and privacy statements
Route::get('/terms-and-privacy', function () {
    return view('terms-and-privacy');
});


// student pages
Route::controller(StudentController::class)->group(function () {
    // classes
    Route::get('/student/classes', 'classes')->middleware('auth:student');

    // classes
    Route::get('/student/classes/{mclass}', 'class')->middleware('auth:student');

    // activity
    Route::get('/student/classes/{mclass}/activity/{classActivity}', 'classActivity')->middleware('auth:student');
});

// Student request routes
Route::controller(StudentController::class)->group(function () {
    // sign up page
    Route::post('/student/signup', 'store')->middleware('guest:student');

    // student email signup
    Route::post('/student/email-signup', 'store_email_signup');

    // student store signup
    Route::post('/student/signup', 'store_signup');

    // authenticate
    Route::post('/student/login/authenticate', 'authenticate');

    // logout
    Route::get('/student/logout', 'logout');

    // join class
    Route::post('/student/classes/join', 'join')->middleware('auth:student');
});


// Administration pages
Route::controller(AdministrationController::class)->group(function () {
    Route::get('/administration', function () {
        return redirect('/administration/login');
    });
    Route::get('/administration/login', 'login')->name('admin_login'); // login page
    Route::get('/administration/dashboard', 'dashboard')->middleware('auth:administrator'); // dashboard
    Route::get('/administration/students', 'students')->middleware('auth:administrator'); // students
    Route::get('/administration/teachers', 'teachers')->middleware('auth:administrator'); // teachers
    Route::get('/administration/classes', 'classes')->middleware('auth:administrator'); // classes

    // requests
    Route::post('/administration/students/accept', 'accept')->middleware('auth:administrator');
});

// Administrator request routes
Route::controller(AdministratorController::class)->group(function () {
    Route::post('/administration/login/authenticate', 'authenticate'); // authenticate login
    Route::post('/administration/logout', 'logout')->middleware('auth:administrator'); // logout
    Route::post('/administration/teachers/add', 'store_teacher')->middleware('auth:administrator'); // store teacher
});


// teacher pages
Route::controller(TeacherController::class)->group(function () {
    Route::get('/teacher/classes', 'classes')->middleware('auth:teacher');
    Route::get('/teacher/classes/{mclass}', 'show_class')->middleware('auth:teacher');
    Route::get('/teacher/classes/{mclass}/activity/create', 'create_activity')->middleware('auth:teacher');
    Route::get('/teacher/classes/{mclass}/activity/{classActivity}', 'view_activity')->middleware('auth:teacher');
});

// teacher request routes
Route::controller(TeacherController::class)->group(function () {
    Route::post('/teacher/login/authenticate', 'authenticate');
    Route::get('/teacher/logout', 'logout')->middleware('auth:teacher');
    Route::post('/teacher/classes/{mclass}/activity/create/submit', 'submit_activity')->middleware('auth:teacher');
});

// class requests routes
Route::controller(MclassController::class)->group(function () {
    Route::post('/teacher/classes/add', 'store')->middleware('auth:teacher');
});
