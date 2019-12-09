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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('client')->group(function () {
	Route::post('/user_invitation', 'ApiUserController@setSecretInvitation');
	Route::post('/solicitud_industrial', 'ApiUserController@solicitudIndustrial');

	Route::post('/actualizar_empresa','CompanyController@update'); 
	Route::post('/actualizar_establecimiento','EstablishmentController@update');
	Route::post('/actualizar_usuario','UserController@update');
});

Route::middleware('auth:api')->group(function () {
	Route::get('/set_user', 'ApiUserController@setUserVue');
	Route::get('/requisitions', 'RequisitionController@index');
	Route::post('/requisition/approve', 'RequisitionController@approve');
    Route::post('/requisition/reject', 'RequisitionController@reject');

    Route::get('/establishment', 'EstablishmentController@data');
    Route::get('/user', 'UserController@data');
    Route::get('/company', 'CompanyController@data');

	Route::get('/lerchapter', 'LerChapterController@data');
	Route::get('/lersubchapter/{lerchapter_id}', 'LerSubChapterController@data');
	Route::get('/lerwaste/{lersubchapter_id}', 'LerWasteController@data');
	Route::get('/managetype', 'ManageTypeController@data');
	Route::get('/processtype', 'ProcessTypeController@data');
	Route::get('/recolectiontype', 'RecolectionTypeController@data');
	Route::get('/unit', 'UnitController@data');

	Route::get('/carrier', 'CarrierController@data');
	Route::get('/vehicletype', 'VehicleTypeController@data');
	Route::get('/vehicle/{carrier_id}', 'VehicleController@data');


    Route::get('/declarations', 'DeclarationController@index');
    Route::post('/declaration/create', 'DeclarationController@create');
	Route::post('/declaration/store', 'DeclarationController@store');
	Route::post('/declaration/sinmovimiento', 'DeclarationController@sinMovimento');
	Route::post('/declaration/delete/{declaration_id}', 'DeclarationController@delete');

	Route::post('/declaration/enviar/{declaration_id}', 'DeclarationController@changeStatusEnviada');

    Route::get('/waste_details/{declaration_id}', 'WasteDetailController@index');

});
