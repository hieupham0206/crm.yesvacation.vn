<?php

Route::get('/leads/import/form', 'LeadsController@formImport')->name('leads.form_import');
Route::post('/leads/import/', 'LeadsController@import')->name('leads.import');

Route::get('/leads/change-state/form/{lead}', 'LeadsController@formChangeState')->name('leads.form_change_state');
Route::post('/leads/chage-state/{lead}', 'LeadsController@changeState')->name('leads.change_state');