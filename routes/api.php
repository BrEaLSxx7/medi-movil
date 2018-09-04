<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::post('auth', 'AuthenticationController@auth');
Route::post('img', 'MedicController@img');
Route::post('img', 'PatientController@img');
Route::put('amedico', 'MedicController@upd');
Route::put('apaciente', 'PatientController@upd');
Route::put('adate', 'DateController@upd');
Route::apiResource('paciente', 'PatientController');
Route::apiResource('medico', 'MedicController');
Route::apiResource('horario', 'HourController');
Route::apiResource('cita', 'DateController');
Route::apiResource('calificacion', 'QualificationController');
Route::apiResource('tpd', 'DocumentTypeController');
Route::apiResource('cancelar','CancelController');