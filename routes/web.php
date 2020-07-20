<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('manage/direction', 'Manage\DirectionController', ['names' => 'manage.direction']);
Route::resource('manage/course', 'Manage\CourseController', ['names' => 'manage.course']);
Route::resource('manage/lesson', 'Manage\LessonController', ['names' => 'manage.lesson']);

Route::get('direction', 'DirectionController@index')->name('direction.index');
Route::get('direction/{direction}/show', 'DirectionController@show')->name('direction.show');

Route::get('course/{course}/show', 'CourseController@show')->name('course.show');
Route::get('course/{course}/buy', 'CourseController@buy')->name('course.buy');
Route::get('course/my', 'CourseController@my')->name('course.my');

Route::get('lesson/{lesson}/show', 'LessonController@show')->name('lesson.show');
Route::post('lesson/{lesson}/complete', 'LessonController@complete')->name('lesson.complete');
Route::get('file/{file}', 'LessonController@file')->name('lesson.file');

Route::get('teacher/lesson/completed', 'TeacherController@index')->name('teacher.lesson.completed');
Route::get('teacher/lesson/{lessonUser}/show', 'TeacherController@show')->name('teacher.lesson.show');

Route::post('teacher/lesson/{lessonUser}/wrong', 'TeacherController@wrong')->name('teacher.lesson.wrong');
Route::post('teacher/lesson/{lessonUser}/right', 'TeacherController@right')->name('teacher.lesson.right');
