<?php

Route::get('forms', 'FormController@getForms');
Route::get('forms/paginate', 'FormController@getFormsPaginate');
Route::get('form/{form_id}', 'FormController@getForm');

Route::get('form/{form_id}/applied-forms', 'FormController@getFormAppliedForms');
Route::get('form/{form_id}/applied-forms/paginate', 'FormController@getFormAppliedFormsPaginate');

Route::post('form', 'FormController@postForm');
Route::put('form/{form_id}', 'FormController@putForm');
Route::delete('form/{form_id}', 'FormController@deleteForm');

Route::get('applied-forms', 'FormController@getAppliedForms');
Route::get('applied-forms/paginate', 'FormController@getAppliedFormsPaginate');
Route::get('applied-form/{applied_form_id}', 'FormController@getAppliedForm');
Route::delete('applied-form/{applied_form_id}', 'FormController@deleteAppliedForm');

Route::get('applied-form-read/{applied_form_id}', 'FormController@setFormRead');
Route::get('applied-form-file/{applied_form_id}/{field_name}', 'FormController@getAppliedFormFile');

Route::put('formable/section/{section}', 'FormableController@putSection');
Route::put('formable/field/{field}', 'FormableController@putFormSectionField');
Route::put('formable/weights', 'FormableController@putSectionAndFieldWeights');
Route::delete('formable/section/{section}', 'FormableController@deleteSection');
Route::delete('formable/field/{field}', 'FormableController@deleteFormSectionField');
