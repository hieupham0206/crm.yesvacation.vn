<?php

Route::post('/users/change-state/{user}', 'UsersController@changeState')->name('users.change_state');
Route::get('/users/form/change-password/', 'UsersController@formChangePassword')->name('users.form_change_password');
Route::post('/users/change-password/{user}', 'UsersController@changePassword')->name('users.change_password');

Route::get('/users/break/form/', 'UsersController@formBreak')->name('users.form_break');
Route::post('/users/break/', 'UsersController@break')->name('users.break');
Route::post('/users/break/resume', 'UsersController@resume')->name('users.resume');

Route::post('/system_logs/view/detail', 'SystemLogsController@viewDetail')->name('system_logs.view_detail');
Route::post('/system_logs/table', 'SystemLogsController@table')->name('system_logs.table');
Route::get('/system_logs/index', 'SystemLogsController@index')->name('system_logs.index');
Route::post('/system_logs/index', 'SystemLogsController@viewDetail')->name('system_logs.index');

Route::post('/activity_logs/view/detail', 'ActivityLogsController@viewDetail')->name('activity_logs.view_detail');
Route::get('/activity_logs/get/logs', 'ActivityLogsController@getMoreLogs')->name('activity_logs.get_more_logs');

Route::get('/translation_managers/index', 'TranslationManagersController@index')->name('translation_managers.index');
Route::post('/translation_managers/lists/table', 'TranslationManagersController@table')->name('translation_managers.table');
Route::post('/translation_managers/edit/detail', 'TranslationManagersController@edit')->name('translation_managers.edit_detail');
Route::put('/translation_managers/update/detail', 'TranslationManagersController@update')->name('translation_managers.update_detail');

Route::post('/event-datas/change-state/{eventData}', 'EventDatasController@changeState')->name('event_datas.change_state');

Route::post('/appointments/cancel/{appointment}', 'AppointmentsController@cancel')->name('appointments.cancel');
Route::post('/appointments/lead/not-show-up/{appointment}', 'AppointmentsController@notShowUp')->name('appointments.not_show_up');
Route::post('/appointments/do-queue/{appointment}', 'AppointmentsController@doQueue')->name('appointments.do_queue');
Route::get('/appointments/form/change-appointment', 'AppointmentsController@formChangeAppointment')->name('appointments.form_change_appointment');
