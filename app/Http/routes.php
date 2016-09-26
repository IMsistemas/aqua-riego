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

//Peticion para obtener el listado de solicitudes
Route::get('solicitud/getSolicitudes', 'Solicitud\SolicitudController@getSolicitudes');
//Peticion para obtener el listado de solicitudes por filtros
Route::get('solicitud/getByFilter/{filters}', 'Solicitud\SolicitudController@getByFilters');
//Peticion para obtener el ultimo id insertado + 1 para el numero de solicitud
Route::get('solicitud/getLastID', 'Solicitud\SolicitudController@getLastID');
//Peticion para obtener el ultimo id insertado + 1 para el numero de solicitud
Route::get('solicitud/getLastIDTerreno', 'Solicitud\SolicitudController@getLastIDTerreno');
//Peticion para obtener la constante para calculo
Route::get('solicitud/getConstante', 'Solicitud\SolicitudController@getConstante');
//Peticion para obtener el listado de tarifas
Route::get('solicitud/getTarifas', 'Solicitud\SolicitudController@getTarifas');
//Peticion para obtener el listado de barrios
Route::get('solicitud/getBarrios', 'Solicitud\SolicitudController@getBarrios');
//Peticion para obtener el listado de cultivos
Route::get('solicitud/getCultivos', 'Solicitud\SolicitudController@getCultivos');
//Peticion para obtener el listado de canales
Route::get('solicitud/getCanales', 'Solicitud\SolicitudController@getCanales');
//Peticion para obtener el listado de tomas en base a un canal
Route::get('solicitud/getTomas/{idcanal}', 'Solicitud\SolicitudController@getTomas');
//Peticion para obtener el listado de derivaciones en base a una toma
Route::get('solicitud/getDerivaciones/{idtoma}', 'Solicitud\SolicitudController@getDerivaciones');
//Peticion para obtener un cliente mediante su id
Route::get('solicitud/getClienteByID/{idcliente}', 'Solicitud\SolicitudController@getClienteByID');
//Peticion para calcular el valor por area
Route::get('solicitud/calculateValor/{area}', 'Solicitud\SolicitudController@calculateValor');
//Peticion para almacenar un cultivo nuevo
Route::post('solicitud/saveCultivo', 'Solicitud\SolicitudController@saveCultivo');
//Peticion para procesar la solicitud
Route::post('solicitud/processSolicitud', 'Solicitud\SolicitudController@processSolicitud');
//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Solicitud
Route::resource('/solicitud', 'Solicitud\SolicitudController');

/*--------------------------------------Yamilka-------------------------------------------------*/
/*===================================Recaudacion=================================================*/

//Peticion para obtener el listado de cobros
Route::get('recaudacion/getCobros', 'Cuentas\CobroAguaController@getCobros');
//Peticion para obtener el listado de cobros por filtros
Route::get('recaudacion/getByFilter/{filters}', 'Cuentas\CobroAguaController@getByFilters');
//Peticion para obtener si se genera factura del periodo
Route::get('recaudacion/verifyPeriodo', 'Cuentas\CobroAguaController@verifyPeriodo');
//Peticion para generar los cobros del periodo
Route::get('recaudacion/generate', 'Cuentas\CobroAguaController@generate');
//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia CobroAgua
Route::resource('/recaudacion', 'Cuentas\CobroAguaController');

/*--------------------------------------Christian-------------------------------------------------*/
/*===================================Cliente=================================================*/

Route::get('/clientes', function (){
	return view('clientes/index');
});
//Ruta devuelve un arreglo de todos los clientes a AngularJS 
Route::get('/clientes/gestion/','Clientes\ClienteController@index');
//Ruta devuelve un arreglo de todos los clientes a AngularJS 
Route::get('/clientes/gestion/{codigocliente}','Clientes\ClienteController@show');
//Ruta página de inicio de gestión de clientes
Route::post('/clientes/gestion/guardarcliente','Clientes\ClienteController@store');
//Ruta página de inicio de gestión de clientes
Route::post('/clientes/gestion/actualizarcliente/{codigocliente}','Clientes\ClienteController@update');
//Ruta página de inicio de gestión de clientes
Route::post('/clientes/gestion/eliminarcliente/{codigocliente}','Clientes\ClienteController@destroy');
//Peticion para obtener el listado de cobros
Route::get('recaudacion/getCobros', 'Cuentas\CobroAguaController@getCobros');
//Peticion para obtener el listado de cobros por filtros
Route::get('recaudacion/getByFilter/{filters}', 'Cuentas\CobroAguaController@getByFilters');
//Peticion para obtener si se genera factura del periodo
Route::get('recaudacion/verifyPeriodo', 'Cuentas\CobroAguaController@verifyPeriodo');
//Peticion para generar los cobros del periodo
Route::get('recaudacion/generate', 'Cuentas\CobroAguaController@generate');
//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia CobroAgua
Route::resource('/recaudacion', 'Cuentas\CobroAguaController');