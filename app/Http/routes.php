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

Route::get('/', function () {
    return view('welcome');
});


/*--------------------------------------Raidel-------------------------------------------------*/
/*===================================Solicitud=================================================*/


Route::get('solicitud/getSolicitudes', 'Solicitud\SolicitudController@getSolicitudes');

Route::get('solicitud/getByFilter/{filters}', 'Solicitud\SolicitudController@getByFilters');

Route::get('solicitud/getConstante', 'Solicitud\SolicitudController@getConstante');

Route::get('solicitud/getTarifas', 'Solicitud\SolicitudController@getTarifas');

Route::get('solicitud/getBarrios', 'Solicitud\SolicitudController@getBarrios');

Route::get('solicitud/getCultivos', 'Solicitud\SolicitudController@getCultivos');

Route::get('solicitud/getCanales', 'Solicitud\SolicitudController@getCanales');

Route::get('solicitud/getTomas/{idcanal}', 'Solicitud\SolicitudController@getTomas');

Route::get('solicitud/getDerivaciones/{idtoma}', 'Solicitud\SolicitudController@getDerivaciones');

Route::get('solicitud/getClienteByID/{idcliente}', 'Solicitud\SolicitudController@getClienteByID');

Route::get('solicitud/calculateValor/{area}', 'Solicitud\SolicitudController@calculateValor');

Route::post('solicitud/saveCultivo', 'Solicitud\SolicitudController@saveCultivo');

Route::post('solicitud/processSolicitud', 'Solicitud\SolicitudController@processSolicitud');

//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Solicitud
Route::resource('solicitud', 'Solicitud\SolicitudController');

/*--------------------------------------Yamilka-------------------------------------------------*/