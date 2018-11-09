<?php

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

Auth::routes();

//Disable register
Route::get('register', function () {
    abort(404);
});
Route::post('register', function () {
    abort(404);
});

//Courses routes
Route::get('/', 'Pages\HomeController@index')->name('home');
Route::get('/category/{id}', 'Pages\CategoryController@show')->name('category');
Route::get('/course/{id}', 'Pages\CourseController@show')->name('course');
Route::get('/mycourses', 'Pages\ClientController@courses')->name('mycourses')->middleware('auth');
Route::get('/download', 'Pages\ClientController@download')->name('downloadPdf')->middleware('auth');

//Register form

Route::post('/registerForm', 'FormController@register')->name('registerForm');
Route::post('/registerFormClient', 'FormController@registerClient')->name('registerFormClient')->middleware('auth');


