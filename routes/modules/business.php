<?php

Route::get('/leads/import/form', 'LeadsController@formImport')->name('leads.form_import');
Route::post('/leads/import/', 'LeadsController@import')->name('leads.import');