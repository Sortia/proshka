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

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'locale', 'verified'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/profile/register', 'ProfileController@register')->name('profile.register');

    Route::middleware('methodist')->prefix('manage')->group(function () {
        Route::resource('direction', 'Manage\DirectionController', ['names' => 'manage.direction']);
        Route::resource('course', 'Manage\CourseController', ['names' => 'manage.course']);
        Route::resource('lesson', 'Manage\LessonController', ['names' => 'manage.lesson']);

        Route::get('lesson/{direction}/{course}', 'Manage\LessonController@create')->name('manage.lesson.create');
        Route::post('lesson/{lesson}/upload_file', 'Manage\LessonController@uploadFile')->name('manage.lesson.file');

        Route::post('policy', 'Manage\PolicyController@store')->name('manage.policy.store');
        Route::post('policy/show/{lesson}', 'Manage\PolicyController@show')->name('manage.policy.show');

        Route::post('test', 'Manage\TestController@store')->name('manage.test.store');
        Route::get('test/{lesson}', 'Manage\TestController@show')->name('manage.test.show');
    });

    Route::middleware('student')->group(function () {
        Route::get('direction', 'DirectionController@index')->name('direction.index');
        Route::get('direction/{direction}/show', 'DirectionController@show')->name('direction.show');

        Route::get('course/{course}/show', 'CourseController@show')->name('course.show');
        Route::get('course/{course}/buy', 'CourseController@buy')->name('course.buy');
        Route::get('course/my', 'CourseController@my')->name('course.my');

        Route::post('lesson/{lesson}/buy', 'LessonController@buy')->name('lesson.buy');
        Route::get('lesson/{lesson}/show', 'LessonController@show')->name('lesson.show');
        Route::post('lesson/{lesson}/complete', 'LessonController@complete')->name('lesson.complete');
        Route::post('lesson/{lesson}/refuse', 'LessonController@refuse')->name('lesson.refuse');

        Route::get('test/{test}/show', 'TestController@show')->name('test.show');

        Route::post('question_user/store', 'QuestionController@store')->name('test.store');

        Route::get('tasks', 'TaskController@index')->name('tasks');
        Route::get('tasks/show', 'TaskController@show')->name('tasks.show');
    });

    Route::middleware('teacher')->group(function () {
        Route::get('teacher/lesson/completed', 'TeacherController@index')->name('teacher.lesson.completed');
        Route::get('teacher/question', 'QuestionController@teacherShow')->name('teacher.question.show');
        Route::get('teacher/lesson/{lessonUser}/show', 'TeacherController@show')->name('teacher.lesson.show');

        Route::post('teacher/lesson/{lessonUser}/wrong', 'TeacherController@wrong')->name('teacher.lesson.wrong');
        Route::post('teacher/lesson/{lessonUser}/right', 'TeacherController@right')->name('teacher.lesson.right');

        Route::get('answer/list/filter', 'QuestionController@filterList');
        Route::get('lesson_user/{lessonUser}', 'QuestionController@getLessonUserData');

        Route::post('question_user/{questionUser}/right', 'QuestionController@rightQuestion');
        Route::post('question_user/{questionUser}/rework', 'QuestionController@reworkQuestion');

        Route::post('lesson_user/{lessonUser}/wrong', 'QuestionController@wrongLesson');
        Route::post('lesson_user/{lessonUser}/right', 'QuestionController@rightLesson');
    });

    Route::get('course/list', 'CourseController@list')->name('course.list');
    Route::get('lesson/list', 'LessonController@list')->name('lesson.list');

    Route::get('file/{file}', 'FileController@show')->name('file.show');
    Route::delete('file/{file}', 'FileController@destroy')->name('lesson.destroy')->middleware('methodist');
});
