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
Route::get('/week', function(){
    echo \Carbon\Carbon::now()->startOfWeek();
    echo \Carbon\Carbon::now()->endOfWeek();
});
Route::group([ 'middleware' => [ 'auth'] ], function(){

Route::get('/', function () {
    return redirect()->route();
});
Route::post('/upload-avatar', 'HomeController@upload_image')->name('upload.image');
Route::get('/date/{id}', 'StudentController@thestat');
Route::get('/api/get-class-stat', 'TheClassController@stat');
Route::get('/api/get-class-stat/{class_id}/{section_id}', 'TheClassController@stat_sex');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/setttings', 'SettingsController@index')->name('settings');
Route::post('/setttings/save', 'SettingsController@store')->name('settings.store');



Route::get('/home', 'HomeController@index')->name('home');
Route::get('/student/search', 'StudentController@index')->name('student.search.form');
Route::post('/student/search', 'StudentController@search')->name('student.search');
Route::post('/student/search/info', 'StudentController@search_info')->name('student.search.fulltext');
Route::get('/student/search/info', function(){
    return redirect('student/search');
});

Route::get('/student/register', 'StudentController@register_form')->name('student.register.form');
Route::post('/student/register', 'StudentController@register')->name('student.register');
Route::get('/student/edit/{id}', 'StudentController@edit_form')->name('student.edit.form');
Route::post('/student/edit/{id}', 'StudentController@update');
Route::get('/student/delete/{id}', 'StudentController@delete');
Route::get('/student/profile/{id}', 'StudentController@show')->name('student.profile');
Route::post('/student/comment/{id}', 'StudentController@comment')->name('student.comment');
Route::get('/student/comment/{id}/delete', 'StudentController@delete_comment')->name('student.comment.delete');

Route::get('/classes', 'TheClassController@index')->name('classes');
Route::get('/class/view/{id}/{section_id}', 'TheClassController@view')->name('class.view');
Route::get('/class/search', 'TheClassController@search')->name('class.search');
Route::get('/class/delete/{id}', 'TheClassController@delete');
Route::post('/classes', 'TheClassController@create');
Route::get('/classes/edit/{id}', 'TheClassController@edit');
Route::post('/classes/edit/{id}', 'TheClassController@update');

Route::get('attendance', 'AttendanceController@index')->name('attendance.index');;
Route::post('attendance', 'AttendanceController@form');
Route::post('attendance/save', 'AttendanceController@save')->name('attendance.save');
Route::post('attendance/update', 'AttendanceController@update');
Route::get('attendance/date', 'AttendanceController@date')->name('attendance.date');
Route::post('attendance/date', 'AttendanceController@date_list')->name('attendance.date.post');
Route::get('attendance/report', 'AttendanceController@index_report')->name('attendance.report');
Route::post('attendance/report', 'AttendanceController@report')->name('attendance.report.post');

Route::post('subject/{id}/view', 'SubtopicController@create')->name('subtopic.create');

Route::get('subjects', 'SubjectController@index')->name('subjects');
Route::get('subject/{id}/view', 'SubjectController@view')->name('subject.view');
Route::post('subjects', 'SubjectController@create')->name('subject.create');
Route::get('subject/edit/{id}', 'SubjectController@edit')->name('subject.edit');
Route::post('subject/edit/{id}', 'SubjectController@update')->name('subject.update');
Route::get('subject/delete/{id}', 'SubjectController@delete')->name('subject.delete');
Route::get('subject/get-subtopics/{id}', 'SubjectController@subtopics');


Route::post('assignment/create', 'AssignmentController@store')->name('assignment.create');
Route::get('assignment/create', 'AssignmentController@create')->name('assignment.form.create');
Route::get('assignment/{id}/edit', 'AssignmentController@edit')->name('assignment.edit');
Route::post('assignment/{id}/edit', 'AssignmentController@update')->name('assignment.update');
Route::get('assignment/{id}/delete', 'AssignmentController@destroy')->name('assignment.delete');
Route::get('assignment/{id}/mark', 'AssignmentMarkController@create')->name('assignment.form.mark');
Route::post('assignment/{id}/mark', 'AssignmentMarkController@store')->name('assignment.mark.store');
Route::get('assignment/{id}/edit-mark', 'AssignmentMarkController@edit')->name('assignment.mark.edit');
Route::post('assignment/{id}/edit-mark', 'AssignmentMarkController@update')->name('assignment.mark.update');
Route::get('assignment/{id}/view-mark', 'AssignmentMarkController@show')->name('assignment.marks.view');

Route::get('assignment/{id}/{section_id}/performance', 'AssignmentMarkController@performance')->name('assignment.performance');

Route::get('resource', 'ResourceController@index')->name('resources.index');
Route::post('resources/upload', 'ResourceController@store')->name('resources.upload');
Route::get('resources/{id}/delete', 'ResourceController@destroy')->name('resources.delete');
Route::get('resources/{id}/download', 'ResourceController@show')->name('resources.download');

Route::get('/timetable', 'TimetableController@index')->name('timetables');
Route::post('/timetable', 'TimetableController@show')->name('timetable');
Route::post('/timetable/create/', 'TimetableController@create')->name('timetable.create');
Route::get('/timetable/create/', 'TimetableController@form');
Route::post('/timetable/create/index', 'TimetableController@timetable_form')->name('timetable.save');
Route::post('/timetable/edit/', 'TimetableController@update')->name('timetable.update');;

Route::get('/mark', 'MarkController@index')->name('admin.mark');
Route::post('/mark', 'MarkController@viewMarks')->name('mark.view');
Route::get('/mark/create', 'MarkController@selectClassForm')->name('marks.create');
Route::post('/mark/create', 'MarkController@marksForm')->name('marks.submit');
Route::post('/mark/create/save', 'MarkController@saveMark')->name('marks.save');
Route::post('/mark/create/update', 'MarkController@updateMark')->name('marks.update');

Route::get('error-404',['as'=>'error-404','uses'=>'ErrorHandlerController@errorCode404']);

Route::get('error-405',['as'=>'error-405','uses'=>'ErrorHandlerController@errorCode405']);

Route::get('/cron', 'CronController@index')->name('cron');
Route::get('/cron/timetable', 'CronController@timetable');

Route::post('/push/save', 'PushController@save')->name('push.save');




});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
