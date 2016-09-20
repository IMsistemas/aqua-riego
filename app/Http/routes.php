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

//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Solicitud
Route::resource('solicitud', 'Solicitud\SolicitudController');

/*--------------------------------------Yamilka-------------------------------------------------*/