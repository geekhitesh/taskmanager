<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/',['middleware' => 'auth',
                          'uses' =>'TaskManagerController@index']);
Route::get('/home',['middleware' => 'auth',
                          'uses' =>'TaskManagerController@index']);

Route::auth();

//Route::get('/home', 'HomeController@index');


Route::get('taskmanager/',['middleware' => 'auth',
                          'uses' =>'TaskManagerController@index']);

//Route::get('taskmanager/', 'TaskManagerController@index');
Route::get('taskmanager/create-task', 'TaskManagerController@createTask');
Route::get('taskmanager/edit-task/{task_id}', 'TaskManagerController@OpenRequestEditableMode');
Route::post('taskmanager/update-task', 'TaskManagerController@updateTask');

Route::get('taskmanager/requesters', 'TaskManagerController@getBuniyadCareRequesters');

Route::get('taskmanager/all-requests/by/{email_id}', 'TaskManagerController@getAllAssignedByTasks');

Route::get('taskmanager/all-requests/to/{email_id}', 'TaskManagerController@getAllAssignedToTasks');
Route::get('taskmanager/all-requests/to/open/{email_id}', 'TaskManagerController@getAllAssignedToTasksOpen');
Route::get('taskmanager/all-requests', 'TaskManagerController@getAllTasks');
Route::get('taskmanager/all-employees', 'TaskManagerController@getAllEmployees');

Route::get('hr/reminder-email/','HREmailReminderController@regularisationLockReminder');


Route::get('survey/create', 'SurveyController@createSurvey');
Route::get('survey/fill/{user_survey_link}', 'SurveyController@fillSurvey');
Route::post('survey/submit', 'SurveyController@submitSurvey');

Route::get('survey/admin/list', 'SurveyController@getSurveyList');
Route::get('survey/admin/results/{survey_id}', 'SurveyController@getSurveyResults');
Route::get('survey/admin/dashboard', 'SurveyController@surveyDashboard');

Route::get('survey/admin/dashboard',['middleware' => 'auth',
                          'uses' =>'SurveyController@surveyDashboard']);
						  
Route::get('survey/admin/emp-list', 'SurveyController@getEmpList');
Route::get('survey/admin/respond-to-user/{user_survey_id}/{email_reply_text}', 'SurveyController@respondToUser');

Route::get('update/contact-details', 'UpdateSalesforceDetails@updatePhoneEmailForm');
Route::post('update/success', 'UpdateSalesforceDetails@sendDetailsByEmail');