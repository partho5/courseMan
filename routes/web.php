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

Route::resource('/','Basic\HomeController');
Route::get('/configure','Basic\HomeController@configureSoftware');
Route::post('/configure_step1','Basic\HomeController@configureStep1');
Route::post('/configure_step2','Basic\HomeController@configureStep2');
Route::post('/configure_step3','Basic\HomeController@configureStep3');


Route::post('/join_dept','Basic\HomeController@joinDepartment');


Route::resource('/file','Basic\FileManager');



Route::resource('/teachers','Basic\Teachers');



Route::resource('/roles','Basic\RoleManager');
Route::post('/roles/teacher/update_role','Basic\RoleManager@UpdateRoleByTeachers');



Route::get('/settings','Basic\Settings@index');
Route::post('/settings/update_my_batch','Basic\Settings@updateStudentCurrentBatch');
Route::post('/settings/save_roll_no','Basic\Settings@saveRollNo');
Route::post('/settings/upload_photo','Basic\Settings@uploadPhoto');


Route::resource('/notice','Basic\Notice');



Route::resource('/course/ct','Basic\ClassTestController');



Route::resource('/course','Basic\CourseController');


Route::post('/course/join_or_leave','Basic\CourseController@joinOrLeaveCourse');



Auth::routes();



Route::get('/api/attendance/get_basic_data', 'API\Attendance\AttendanceApiController@getBasicData');
Route::get('/api/attendance/send_attendance_data', 'API\Attendance\AttendanceApiController@sendAttendanceData');



Route::get('/home', 'HomeController@index')->name('home');



//Route::get('/home', function (){
//    return redirect('/');
//});
