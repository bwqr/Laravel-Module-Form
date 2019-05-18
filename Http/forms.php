<?php

Route::get('forms', 'FormsController@getForms');

Route::get('applied-forms/{slug}', 'FormsController@getFormWithAppliedForms');

Route::get('form/{id}', 'FormsController@getForm');

Route::get('form-read/{id}', 'FormsController@setFormRead');
