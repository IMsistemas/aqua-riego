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

/*Route::get('/inicio', function () {
    return view('index');
});*/

Route::get('/logout', 'Index\IndexController@logout');

Route::resource('/', 'Index\IndexController');

Route::resource('/inicio', 'Index\IndexController');

/*--------------------------------------Raidel-------------------------------------------------*/
/*===================================Solicitud=================================================*/
 
//Peticion para obtener el listado de solicitudes
Route::get('solicitud/getSolicitudes', 'Solicitud\SolicitudController@getSolicitudes');

Route::get('solicitud/getSolicitudOtro/{idsolicitud}', 'Solicitud\SolicitudController@getSolicitudOtro');

Route::get('solicitud/getSolicitudRiego/{idsolicitud}', 'Solicitud\SolicitudController@getSolicitudRiego');

Route::get('solicitud/getSolicitudSetN/{idsolicitud}', 'Solicitud\SolicitudController@getSolicitudSetN');

Route::get('solicitud/getSolicitudFraccion/{idsolicitud}', 'Solicitud\SolicitudController@getSolicitudFraccion');

Route::get('solicitud/getIdentifyCliente/{idcliente}', 'Solicitud\SolicitudController@getIdentifyCliente');

Route::get('solicitud/getByFilter/{filter}', 'Solicitud\SolicitudController@getByFilter');

Route::put('solicitud/processSolicitudSetName/{idsolicitud}', 'Solicitud\SolicitudController@processSolicitudSetName');

Route::put('solicitud/processSolicitudFraccion/{idsolicitud}', 'Solicitud\SolicitudController@processSolicitudFraccion');

Route::put('solicitud/updateSolicitudOtro/{idsolicitud}', 'Solicitud\SolicitudController@updateSolicitudOtro');

Route::put('solicitud/updateSolicitudRiego/{idsolicitud}', 'Solicitud\SolicitudController@updateSolicitudRiego');

Route::put('solicitud/updateSolicitudSetName/{idsolicitud}', 'Solicitud\SolicitudController@updateSolicitudSetName');

Route::put('solicitud/updateSolicitudFraccion/{idsolicitud}', 'Solicitud\SolicitudController@updateSolicitudFraccion');

//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Solicitud
Route::resource('/solicitud', 'Solicitud\SolicitudController');


/*
 * -------------------------Modulo Tarifa (Raidel) ---------------------------------------------------------------------
 */

Route::get('tarifa/getTarifas', 'Tarifas\TarifaController@getTarifas');

Route::get('tarifa/getAreaCaudal/{data}', 'Tarifas\TarifaController@getAreaCaudal');
//Peticion para obtener la constante para calculo
Route::get('tarifa/getConstante', 'Tarifas\TarifaController@getConstante');

Route::get('tarifa/getLastID', 'Tarifas\TarifaController@getLastID');

Route::get('tarifa/generate', 'Tarifas\TarifaController@generate');

Route::post('tarifa/saveSubTarifas', 'Tarifas\TarifaController@saveSubTarifas');

Route::post('tarifa/deleteSubTarifas', 'Tarifas\TarifaController@deleteSubTarifas');
//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Tarifa
Route::resource('/tarifa', 'Tarifas\TarifaController');

/*
 * -------------------------Modulo Cultivo (Raidel) --------------------------------------------------------------------
 */
Route::get('cultivo/getTarifas', 'Tarifas\CultivoController@getTarifas');
Route::get('cultivo/getCultivos', 'Tarifas\CultivoController@getCultivos');
Route::get('cultivo/getCultivosByID/{id}', 'Tarifas\CultivoController@getCultivosByID');
Route::resource('/cultivo', 'Tarifas\CultivoController');

/*
 * -------------------------Modulo Cliente (Yamilka)--------------------------------------------------------------------
 */

Route::get('cliente/getClienteByIdentify/{idcliente}', 'Clientes\ClienteController@getClienteByIdentify');

Route::get('cliente/getIdentifyClientes/{idcliente}', 'Clientes\ClienteController@getIdentifyClientes');

Route::get('cliente/getTerrenosByCliente/{idcliente}', 'Clientes\ClienteController@getTerrenosByCliente');

Route::get('cliente/getLastID/{table}', 'Clientes\ClienteController@getLastID');
//Peticion para obtener la constante para calculo
Route::get('cliente/getConstante', 'Clientes\ClienteController@getConstante');
//Peticion para calcular el valor por area
Route::get('cliente/calculateValor/{area}', 'Clientes\ClienteController@calculateValor');

Route::get('cliente/getDerivaciones/{idcanal}', 'Clientes\ClienteController@getDerivaciones');

Route::get('cliente/getCanales/{idcalle}', 'Clientes\ClienteController@getCanales');

Route::get('cliente/getTomas/{idbarrio}', 'Clientes\ClienteController@getTomas');

Route::get('cliente/getCultivos/{idtarifa}', 'Clientes\ClienteController@getCultivos');

Route::get('cliente/getBarrios', 'Clientes\ClienteController@getBarrios');

Route::get('cliente/getTarifas', 'Clientes\ClienteController@getTarifas');

Route::get('cliente/getClientes', 'Clientes\ClienteController@getClientes');

Route::get('cliente/getIsFreeCliente/{codigocliente}', 'Clientes\ClienteController@getIsFreeCliente');

Route::post('cliente/storeSolicitudRiego', 'Clientes\ClienteController@storeSolicitudRiego');

Route::post('cliente/storeSolicitudOtro', 'Clientes\ClienteController@storeSolicitudOtro');

Route::post('cliente/storeSolicitudSetName', 'Clientes\ClienteController@storeSolicitudSetName');

Route::post('cliente/storeSolicitudFraccion', 'Clientes\ClienteController@storeSolicitudFraccion');

Route::put('cliente/processSolicitud/{idsolicitud}', 'Clientes\ClienteController@processSolicitud');

Route::put('cliente/processSolicitudSetName/{idsolicitud}', 'Clientes\ClienteController@processSolicitudSetName');

Route::put('cliente/processSolicitudFraccion/{idsolicitud}', 'Clientes\ClienteController@processSolicitudFraccion');

Route::get('cliente/getTipoIdentificacion', 'Clientes\ClienteController@getTipoIdentificacion');
Route::get('cliente/getImpuestoIVA', 'Clientes\ClienteController@getImpuestoIVA');
Route::get('cliente/getPersonaByIdentify/{identify}', 'Clientes\ClienteController@getPersonaByIdentify');
Route::get('cliente/getIdentify/{identify}', 'Clientes\ClienteController@getIdentify');

Route::resource('/cliente', 'Clientes\ClienteController');


/*--------------------------------------Yamilka-------------------------------------------------*/
/*===================================Sectores===========================================*/

Route::get('barrio/llenar_tabla/{data}', 'Sectores\BarrioController@llenar_tabla');

Route::get('barrio/calles/{id}', 'Tomas\CalleController@getCallesById');

Route::get('barrio/canales/{id}', 'Tomas\CanallController@getCanalesById');

Route::get('barrio/derivaciones/{id}', 'Tomas\DerivacionesController@getDerivacionesById');

Route::get('barrio/getBarrios', 'Sectores\BarrioController@getBarrios');

Route::get('barrio/getBarrio', 'Sectores\BarrioController@getBarrio');

Route::get('barrio/getCalle', 'Tomas\CalleController@getCalle');

Route::get('barrio/getLastIDCanal', 'Tomas\CanallController@getLastID');

Route::get('barrio/getCanal', 'Tomas\CanallController@getCanal');

Route::get('barrio/getLastIDDerivaciones', 'Tomas\DerivacionesController@getLastID');

Route::get('barrio/getBarrio_ID/{data}', 'Sectores\BarrioController@getBarrio_ID');

Route::get('barrio/getCanals/{data}', 'Sectores\BarrioController@getCanals');

Route::get('barrio/getderivaciones/{data}', 'Sectores\BarrioController@getderivaciones');

Route::get('barrio/getParroquias', 'Sectores\BarrioController@getParroquias');

Route::get('barrio/getLastID', 'Sectores\BarrioController@getLastID');

Route::get('barrio/saveBarrio', 'Sectores\BarrioController@getLastID');

Route::post('barrio/editar_canales', 'Tomas\CanallController@editar_canal');

Route::post('barrio/editar_calle', 'Tomas\CalleController@editar_calle');

Route::post('barrio/editar_derivaciones', 'Tomas\DerivacionesController@editar_derivaciones');

Route::post('barrio/editar_Barrio', 'Sectores\BarrioController@editar_barrio');

Route::resource('/barrio', 'Sectores\BarrioController');

/*===================================Calle===========================================*/

Route::get('calle/getCallesByBarrio/{id}','Tomas\CalleController@getCallesById');

Route::get('calle/getCalles', 'Tomas\CalleController@getCalles');

Route::get('calle/getderivaciones/{data}', 'Sectores\BarrioController@getderivaciones');

Route::get('calle/getBarrio', 'Sectores\BarrioController@getBarrios');

Route::get('calle/getLastID', 'Tomas\CalleController@getLastID');

Route::post('calle/editar_calle', 'Tomas\CalleController@editar_calle');


Route::resource('/calle', 'Tomas\CalleController');

/*===================================Canal===========================================*/

Route::get('canal/getCanalesByCalle/{id}', 'Tomas\CanallController@getCanalesByCalle');

Route::get('canal/getCalleByBarrio/{id}', 'Tomas\CalleController@getCalleByBarrio');

Route::get('canal/getCanalesByBarrio/{id}', 'Tomas\CanallController@getCanalesByBarrio');

Route::get('canal/getLastID', 'Tomas\CanallController@getLastID');

Route::get('canal/getCalle', 'Tomas\CanallController@getCalle');

Route::get('canal/getCanall', 'Tomas\CanallController@getCanall');

Route::get('canal/getCalles', 'Tomas\CanallController@getCalles');

Route::get('canal/getBarrios', 'Tomas\CanallController@getBarrios');

Route::post('canal/editar_canal', 'Tomas\CanallController@editar_canal');


Route::resource('/canal', 'Tomas\CanallController');

/*===================================Derivaciones===========================================*/


Route::get('derivaciones/getDerivacionesByCanal/{id}', 'Tomas\DerivacionesController@getDerivacionesById');

Route::get('derivaciones/getDerivacionesByCalle/{id}', 'Tomas\CanallController@getDerivacionesByCalle');

Route::get('derivaciones/getCanalesByCalle/{id}', 'Tomas\CanallController@getCanalesByCalle1');

Route::get('derivaciones/getDerivacionesByBarrio1/{id}', 'Tomas\DerivacionesController@getDerivacionesByBarrio1');

Route::get('derivaciones/getCalleByBarrio/{id}', 'Tomas\CalleController@getCalleByBarrio');

Route::get('derivaciones/getDerivaciones', 'Tomas\DerivacionesController@getDerivaciones');

Route::get('derivaciones/getLastID', 'Tomas\DerivacionesController@getLastID');

Route::get('derivaciones/getCanales', 'Tomas\DerivacionesController@getCanales');

Route::get('derivaciones/getCanaless', 'Tomas\DerivacionesController@getCanaless');

Route::get('derivaciones/getCalles', 'Tomas\DerivacionesController@getCalles');

Route::get('derivaciones/getBarrios', 'Tomas\DerivacionesController@getBarrios');

Route::get('derivaciones/getDerivacionesByBarrio/{id}', 'Tomas\DerivacionesController@getDerivacionesByBarrio');

Route::post('derivaciones/editar_derivaciones', 'Tomas\DerivacionesController@editar_derivaciones');


Route::resource('/derivaciones', 'Tomas\DerivacionesController');

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

/*===================================Edicion Terreno==============================================*/
//Peticion para obtener el listado de tarifas
Route::get('editTerreno/getTarifas', 'Terreno\TerrenoController@getTarifas');
//Peticion para obtener el listado de barrios
Route::get('editTerreno/getBarrios', 'Terreno\TerrenoController@getBarrios');
//Peticion para obtener el listado de cultivos
Route::get('editTerreno/getCultivos/{tarifa}', 'Terreno\TerrenoController@getCultivos');
//Peticion para obtener el listado de canales
Route::get('editTerreno/getCanales/{idcalle}', 'Terreno\TerrenoController@getCanales');
//Peticion para obtener el listado de tomas en base a un canal
Route::get('editTerreno/getTomas/{idbarrio}', 'Terreno\TerrenoController@getTomas');
//Peticion para obtener el listado de derivaciones en base a una toma
Route::get('editTerreno/getDerivaciones/{idcanal}', 'Terreno\TerrenoController@getDerivaciones');
//Peticion para obtener el listado de terrenos
Route::get('editTerreno/getTerrenos', 'Terreno\TerrenoController@getTerrenos');
//Peticion para obtener la constante para calculo
Route::get('editTerreno/getConstante', 'Terreno\TerrenoController@getConstante');
//Peticion para calcular el valor por area
Route::get('editTerreno/calculateValor/{area}', 'Terreno\TerrenoController@calculateValor');
//Peticion para buscar terrenos por filtros
Route::get('editTerreno/getByFilter/{filter}', 'Terreno\TerrenoController@getByFilter');
//Resource, atiende peticiones REST generales: [GET|POST|PUT|DELETE] hacia Terreno

Route::post('editTerreno/update/{id}', 'Terreno\TerrenoController@update');

Route::resource('/editTerreno', 'Terreno\TerrenoController');

/*
 * -------------------------Modulo Nomina (Yamilka)---------------------------------------------------------------------
 */

Route::get('departamento/getDepartamentoByID/{id}', 'Nomina\DepartamentoController@getDepartamentoByID');
Route::get('departamento/getDepartamentos', 'Nomina\DepartamentoController@getDepartamentos');
Route::resource('/departamento', 'Nomina\DepartamentoController');

Route::get('cargo/getCargos', 'Nomina\CargoController@getCargos');
Route::get('cargo/getCargoByID/{id}', 'Nomina\CargoController@getCargoByID');
Route::resource('/cargo', 'Nomina\CargoController');

Route::get('empleado/getEmployees', 'Nomina\EmpleadoController@getEmployees');
Route::get('empleado/getCargos/{id}', 'Nomina\EmpleadoController@getCargos');
Route::get('empleado/getAllPositions', 'Nomina\EmpleadoController@getAllPositions');
Route::get('empleado/getDepartamentos', 'Nomina\EmpleadoController@getDepartamentos');
Route::get('empleado/getPlanCuenta', 'Nomina\EmpleadoController@getPlanCuenta');
Route::get('empleado/getTipoIdentificacion', 'Nomina\EmpleadoController@getTipoIdentificacion');
Route::get('empleado/getIdentify/{identify}', 'Nomina\EmpleadoController@getIdentify');
Route::get('empleado/getPersonaByIdentify/{identify}', 'Nomina\EmpleadoController@getPersonaByIdentify');
Route::post('empleado/updateEmpleado/{id}', 'Nomina\EmpleadoController@updateEmpleado');
Route::resource('/empleado', 'Nomina\EmpleadoController');

/*
 * ---------------------------------------------------------------------------------------------------------------------
 */


/*--------------------------------------Christian-------------------------------------------------*/
/*===================================Cliente======================================================*/

/*Route::get('/clientes', function (){
	return view('Clientes/index');
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
Route::resource('/recaudacion', 'Cuentas\CobroAguaController');*/

/*===================================Módulo Barrio===========================================*/

/*Route::get('/barrios', function (){
	return view('Sectores/barrio');
});

//----Kevin Tambien :-(---------
Route::get('/barrios/gestion/concalles','Sectores\BarrioController@getBarriosCalles');


//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/barrios/gestion/{idparroquia?}','Sectores\BarrioController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/barrios/gestion/{idbarrio?}','Sectores\BarrioController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/barrios/maxid','Sectores\BarrioController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/barrios/gestion/guardarbarrio/{idparroquia}','Sectores\BarrioController@postCrearBarrio');
//Ruta página de inicio de gestión de barrios
Route::post('/barrios/gestion/actualizarbarrio/{idbarrio}','Sectores\BarrioController@postActualizarBarrio');
//Ruta página de inicio de gestión de barrios
Route::Delete('/barrios/gestion/eliminarbarrio/{idbarrio}','Sectores\BarrioController@destroy');*/

/*===================================Módulo Canal===========================================*/
/*
Route::get('/canales', function (){
	return view('Tomas/canal');
});
//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/canales/gestion','Tomas\CanalController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/canales/gestion/{idcanal?}','Tomas\CanalController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/canales/maxid','Tomas\CanalController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/canales/gestion/guardarcanal','Tomas\CanalController@postCrearCanal');
//Ruta página de inicio de gestión de barrios
Route::post('/canales/gestion/actualizarcanal/{idcanal}','Tomas\CanalController@postActualizarCanal');
//Ruta página de inicio de gestión de barrios
Route::Delete('/canales/gestion/eliminarcanal/{idcanal}','Tomas\CanalController@destroy');*/

/*===================================Módulo Toma===========================================*/
/*
Route::get('/tomas', function (){
	return view('Tomas/toma');
});

//----Kevin Tambien :-(---------
Route::get('/tomas/gestion/concalles','Tomas\TomaController@getBarriosCalles');


//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/tomas/{idcanal?}','Tomas\TomaController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/tomas/gestion/{idtoma?}','Tomas\TomaController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/tomas/maxid','Tomas\TomaController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/tomas/gestion/guardartoma/{idcanal}','Tomas\TomaController@postCrearToma');
//Ruta página de inicio de gestión de barrios
Route::post('/tomas/gestion/actualizartoma/{idtoma}','Tomas\TomaController@postActualizarToma');
//Ruta página de inicio de gestión de tomas
Route::Delete('/tomas/gestion/eliminartoma/{idtoma}','Tomas\TomaController@destroy');*/


/*===================================Módulo Derivación===========================================*/

/*Route::get('/barrios', function (){
	return view('Sectores/barrio');
});*/

//----Kevin Tambien :-(---------
/*Route::get('/barrios/gestion/concalles','Sectores\BarrioController@getBarriosCalles');


//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/barrios/gestion/{idparroquia?}','Sectores\BarrioController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/barrios/gestion/{idbarrio?}','Sectores\BarrioController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/barrios/maxid','Sectores\BarrioController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/barrios/gestion/guardarbarrio/{idparroquia}','Sectores\BarrioController@postCrearBarrio');
//Ruta página de inicio de gestión de barrios
Route::post('/barrios/gestion/actualizarbarrio/{idbarrio}','Sectores\BarrioController@postActualizarBarrio');
//Ruta página de inicio de gestión de barrios
Route::Delete('/barrios/gestion/eliminarbarrio/{idbarrio}','Sectores\BarrioController@destroy');*/
/*===================================Módulo Canal===========================================*/
/*
Route::get('/canales', function (){
	return view('Tomas/canal');
});
//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/canales/gestion','Tomas\CanalController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/canales/gestion/{idcanal?}','Tomas\CanalController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/canales/maxid','Tomas\CanalController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/canales/gestion/guardarcanal','Tomas\CanalController@postCrearCanal');
//Ruta página de inicio de gestión de barrios
Route::post('/canales/gestion/actualizarcanal/{idcanal}','Tomas\CanalController@postActualizarCanal');
//Ruta página de inicio de gestión de barrios
Route::Delete('/canales/gestion/eliminarcanal/{idcanal}','Tomas\CanalController@destroy');*/

/*===================================Módulo Toma===========================================*/
/*
Route::get('/tomas', function (){
	return view('Tomas/toma');
});

//----Kevin Tambien :-(---------
Route::get('/tomas/gestion/concalles','Tomas\TomaController@getBarriosCalles');


//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/tomas/{idcanal?}','Tomas\TomaController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/tomas/gestion/{idtoma?}','Tomas\TomaController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/tomas/maxid','Tomas\TomaController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/tomas/gestion/guardartoma/{idcanal}','Tomas\TomaController@postCrearToma');
//Ruta página de inicio de gestión de barrios
Route::post('/tomas/gestion/actualizartoma/{idtoma}','Tomas\TomaController@postActualizarToma');
//Ruta página de inicio de gestión de tomas
Route::Delete('/tomas/gestion/eliminartoma/{idtoma}','Tomas\TomaController@destroy');

*/
/*===================================Módulo Derivación===========================================

Route::get('/derivaciones', function (){
	return view('Tomas/derivacion');
});

//----Kevin Tambien :-(---------
////Route::get('/derivaciones/gestion/concalles','Tomas\DerivacionController@getBarriosCalles');


//Ruta devuelve un arreglo de todos los provincias a AngularJS 
Route::get('/derivaciones/{idtoma?}','Tomas\DerivacionController@index');
//Ruta devuelve un arreglo de todos los Cantons a AngularJS 
Route::get('/derivaciones/gestion/{idderivacion?}','Tomas\DerivacionController@show');
//Ruta página de inicio de gestión de barrios
Route::get('/derivaciones/maxid','Tomas\DerivacionController@maxId');
//Ruta página de inicio de gestión de barrios
Route::post('/derivaciones/gestion/guardarderivacion/{idtoma}','Tomas\DerivacionController@postCrearDerivacion');

//Ruta página de inicio de gestión de derivacions
Route::post('/derivaciones/gestion/actualizarderivacion/{idderivacion}','Tomas\DerivacionController@postActualizarDerivacion');
//Ruta página de inicio de gestión de derivacions
Route::Delete('/derivaciones/gestion/eliminarderivacion/{idderivacion}','Tomas\DerivacionController@destroy');
Route::Delete('/barrios/gestion/eliminarbarrio/{idbarrio}','Sectores\BarrioController@destroy');
*/

/*===================================Descuentos======================================================*/

Route::get('/descuentos', function (){
	return view('Descuentos/descuento');
});
//Ruta devuelve un arreglo de todos los clientes a AngularJS 
Route::get('/descuentos/gestion/{anio?}','Descuentos\DescuentoController@index');
//Ruta devuelve el ultimo año
Route::get('/descuentos/anio','Descuentos\DescuentoController@anio');
//Ruta devuelve un arreglo de todos los clientes a AngularJS 
Route::get('/descuentos/gestion/{iddescuento?}','Descuentos\DescuentoController@show');
//Ruta página de inicio de gestión de clientes
Route::post('/descuentos/gestion/guardardescuento','Descuentos\DescuentoController@store');
//Ruta página de inicio de gestión de clientes
Route::post('/descuentos/gestion/actualizardescuento/{anio}','Descuentos\DescuentoController@update');
//Ruta página de inicio de gestión de clientes
Route::post('/descuentos/gestion/eliminardescuento/{iddescuento}','Descuentos\DescuentoController@destroy');


/*===================================Módulo Categorías===========================================*/


Route::get('categoria/getCategoriasToFilter', 'Categorias\CategoriaController@getCategoriasToFilter');
Route::get('categoria/lastCategoria/{id}', 'Categorias\CategoriaController@lastCategoria');
Route::get('categoria/lastSubCategoria/{id}', 'Categorias\CategoriaController@lastSubCategoria');
Route::get('categoria/getCategoriaTodelete/{id}', 'Categorias\CategoriaController@getCategoriaToDelete');
Route::get('categoria/{id}', 'Categorias\CategoriaController@show');
Route::get('categoria/getByFilter/{filters}', 'Categorias\CategoriaController@getByFilter');
Route::put('categoria/update/{request}', 'Categorias\CategoriaController@update');
Route::resource('categoria', 'Categorias\CategoriaController');



/*===================================Módulo Bodega===========================================*/

Route::get('bodega/getProvincias', 'Bodegas\BodegaController@getProvincias');
Route::get('bodega/getLastBodega', 'Bodegas\BodegaController@getLastBodega');
Route::get('bodega/getBodegas/{filters}', 'Bodegas\BodegaController@getBodegas');
Route::get('bodega/getCiudad/{provincia}', 'Bodegas\BodegaController@getCiudades');
Route::get('bodega/getSector/{ciudad}', 'Bodegas\BodegaController@getSectores');
Route::get('bodega/getEmpleado/{nombre}', 'Bodegas\BodegaController@getEmpleado');
Route::get('bodega/getEmpleadoByBodega/{id}', 'Bodegas\BodegaController@getEmpleadoByBodega');
Route::get('bodega/anularBodega/{param}', 'Bodegas\BodegaController@anularBodega');
Route::get('bodega/{id}', 'Bodegas\BodegaController@show');
Route::resource('bodega', 'Bodegas\BodegaController');

/*===================================Módulo Catalogo Producto===========================================*/

Route::get('catalogoproducto/getCategoriasToFilter', 'CatalogoProductos\CatalogoProductoController@getCategoriasToFilter');
Route::get('catalogoproducto/getLastCatalogoProducto', 'CatalogoProductos\CatalogoProductoController@getLastCatalogoProducto');
Route::get('catalogoproducto/getCatalogoProductos/{filters}', 'CatalogoProductos\CatalogoProductoController@getCatalogoProductos');
Route::get('catalogoproducto/getCategoriasHijas/{filters}', 'CatalogoProductos\CatalogoProductoController@getCategoriasHijas');
Route::get('catalogoproducto/{id}', 'CatalogoProductos\CatalogoProductoController@show');
Route::resource('catalogoproducto', 'CatalogoProductos\CatalogoProductoController');


/*===================================Módulo Compras===========================================*/


Route::get('compras/getLastCompra', 'Compras\CompraProductoController@getLastCompra');
Route::get('compras/getProveedores', 'Compras\CompraProductoController@getProveedores');
Route::get('compras/getComprasMes/{proveedor}', 'Compras\CompraProductoController@getComprasMes');
Route::get('compras/getFormaPagoDocumento', 'Compras\CompraProductoController@getFormaPagoDocumento');
Route::get('compras/getCompras/{filters}', 'Compras\CompraProductoController@getCompras');
Route::get('compras/getProveedorByCI/{ci}', 'Compras\CompraProductoController@getProveedorByCI');
Route::get('compras/pagarCompra/{id}', 'Compras\CompraProductoController@pagarCompra');
Route::get('compras/anularCompra/{id}', 'Compras\CompraProductoController@anularCompra');
Route::get('compras/getBodega/{texto}', 'Compras\CompraProductoController@getBodega');
Route::get('compras/getCodigoProducto/{texto}', 'Compras\CompraProductoController@getCodigoProducto');
Route::get('compras/getFormaPago', 'Compras\CompraProductoController@getFormaPago');
Route::get('compras/getConfiguracion', 'Compras\CompraProductoController@getConfiguracion');
Route::get('compras/getTipoComprobante', 'Compras\CompraProductoController@getTipoComprobante');
Route::get('compras/getSustentoTributario', 'Compras\CompraProductoController@getSustentoTributario');
Route::get('compras/getPais', 'Compras\CompraProductoController@getPais');
Route::get('compras/getBodegas', 'Compras\CompraProductoController@getBodegas');
Route::get('compras/imprimir/{id}', 'Compras\CompraProductoController@imprimir');
Route::get('compras/pdf/{id}', 'Compras\CompraProductoController@pdf');
Route::get('compras/excel/{id}', 'Compras\CompraProductoController@excel');
Route::get('compras/imprimirCompra/{id}', 'Compras\CompraProductoController@imprimirCompra');
Route::get('compras/{id}', 'Compras\CompraProductoController@show');
Route::get('compras/getDetalle/{id}', 'Compras\CompraProductoController@getDetalle');


Route::get('compras/formulario/{compra}', 'Compras\CompraProductoController@formulario');
Route::resource('compras', 'Compras\CompraProductoController');






/*===================================Módulo Compras===========================================*/


Route::get('compras/getLastCompra', 'Compras\CompraProductoController@getLastCompra');
Route::get('compras/getProveedores', 'Compras\CompraProductoController@getProveedores');
Route::get('compras/getComprasMes/{proveedor}', 'Compras\CompraProductoController@getComprasMes');
Route::get('compras/getFormaPagoDocumento', 'Compras\CompraProductoController@getFormaPagoDocumento');
Route::get('compras/getCompras/{filters}', 'Compras\CompraProductoController@getCompras');
Route::get('compras/getProveedorByCI/{ci}', 'Compras\CompraProductoController@getProveedorByCI');
Route::get('compras/pagarCompra/{id}', 'Compras\CompraProductoController@pagarCompra');
Route::get('compras/anularCompra/{id}', 'Compras\CompraProductoController@anularCompra');
Route::get('compras/getBodega/{texto}', 'Compras\CompraProductoController@getBodega');
Route::get('compras/getCodigoProducto/{texto}', 'Compras\CompraProductoController@getCodigoProducto');
Route::get('compras/getFormaPago', 'Compras\CompraProductoController@getFormaPago');
Route::get('compras/getConfiguracion', 'Compras\CompraProductoController@getConfiguracion');
Route::get('compras/getTipoComprobante', 'Compras\CompraProductoController@getTipoComprobante');
Route::get('compras/getSustentoTributario', 'Compras\CompraProductoController@getSustentoTributario');
Route::get('compras/getPais', 'Compras\CompraProductoController@getPais');
Route::get('compras/imprimir/{id}', 'Compras\CompraProductoController@imprimir');
Route::get('compras/pdf/{id}', 'Compras\CompraProductoController@pdf');
Route::get('compras/excel/{id}', 'Compras\CompraProductoController@excel');
Route::get('compras/imprimirCompra/{id}', 'Compras\CompraProductoController@imprimirCompra');
Route::get('compras/{id}', 'Compras\CompraProductoController@show');
Route::get('compras/getDetalle/{id}', 'Compras\CompraProductoController@getDetalle');


Route::get('compras/formulario/{compra}', 'Compras\CompraProductoController@formulario');
Route::resource('compras', 'Compras\CompraProductoController');

/*
 * -------------------------Modulo Proveedores y Transportista (Raidel)-------------------------------------------------
 */

Route::get('proveedor/getTipoIdentificacion', 'Proveedores\ProveedorController@getTipoIdentificacion');
Route::get('proveedor/getProvincias', 'Proveedores\ProveedorController@getProvincias');
Route::get('proveedor/getCantones/{idprovincia}', 'Proveedores\ProveedorController@getCantones');
Route::get('proveedor/getParroquias/{idcanton}', 'Proveedores\ProveedorController@getParroquias');
Route::get('proveedor/getImpuestoIVA', 'Proveedores\ProveedorController@getImpuestoIVA');
Route::get('proveedor/getIdentify/{identify}', 'Proveedores\ProveedorController@getIdentify');
Route::get('proveedor/getProveedores', 'Proveedores\ProveedorController@getProveedores');
Route::get('proveedor/getContactos/{idproveedor}', 'Proveedores\ProveedorController@getContactos');
Route::post('proveedor/storeContactos', 'Proveedores\ProveedorController@storeContactos');
Route::delete('proveedor/destroyContacto/{idcontacto}', 'Proveedores\ProveedorController@destroyContacto');
Route::resource('proveedor', 'Proveedores\ProveedorController');

Route::get('transportista/getProveedores', 'Transportista\TransportistaController@getProveedores');
Route::get('transportista/getTransportista', 'Transportista\TransportistaController@getTransportista');
Route::get('transportista/getTipoIdentificacion', 'Transportista\TransportistaController@getTipoIdentificacion');
Route::get('transportista/getIdentify/{identify}', 'Transportista\TransportistaController@getIdentify');
Route::resource('/transportista', 'Transportista\TransportistaController');

/*
 * ---------------------------------------------------------------------------------------------------------------------
 */

//------------Modulo documento venta---------------////

/*Route::get('/DocumentoVenta', function (){
	return view('Facturacionventa/index');
});*/

Route::get('DocumentoVenta/getSuministroByFactura', 'Facturacionventa\DocumentoVenta@getSuministroByFactura');
Route::get('DocumentoVenta/getProductoPorSuministro/{id}', 'Facturacionventa\DocumentoVenta@getProductoPorSuministro');
Route::get('DocumentoVenta/getInfoClienteXCIRuc/{getInfoCliente}', 'Facturacionventa\DocumentoVenta@getInfoClienteXCIRuc');
Route::get('DocumentoVenta/getBodega/{texto}', 'Facturacionventa\DocumentoVenta@getinfoBodegas');
Route::get('DocumentoVenta/getProducto/{texto}', 'Facturacionventa\DocumentoVenta@getinfoProducto');
Route::get('DocumentoVenta/getheaddocumentoventa', 'Facturacionventa\DocumentoVenta@getPuntoVentaEmpleado');
Route::get('DocumentoVenta/formapago', 'Facturacionventa\DocumentoVenta@getFormaPago');
Route::get('DocumentoVenta/porcentajeivaiceotro', 'Facturacionventa\DocumentoVenta@getCofiguracioncontable');
Route::get('DocumentoVenta/AllBodegas', 'Facturacionventa\DocumentoVenta@getAllbodegas');
Route::get('DocumentoVenta/LoadProductos/{id}', 'Facturacionventa\DocumentoVenta@getProductoPorBodega');
Route::get('DocumentoVenta/AllServicios', 'Facturacionventa\DocumentoVenta@getAllservicios');
Route::get('DocumentoVenta/getVentas/{filtro}', 'Facturacionventa\DocumentoVenta@getVentas');
Route::get('DocumentoVenta/getAllFitros', 'Facturacionventa\DocumentoVenta@getallFitros');
Route::get('DocumentoVenta/anularVenta/{id}', 'Facturacionventa\DocumentoVenta@anularVenta');
Route::get('DocumentoVenta/loadEditVenta/{id}', 'Facturacionventa\DocumentoVenta@getVentaXId');
Route::get('DocumentoVenta/excel/{id}', 'Facturacionventa\DocumentoVenta@excel');
Route::get('DocumentoVenta/NumRegistroVenta', 'Facturacionventa\DocumentoVenta@getDocVenta');
Route::get('DocumentoVenta/cobrar/{id}', 'Facturacionventa\DocumentoVenta@confirmarcobro');
Route::get('DocumentoVenta/print/{id}', 'Facturacionventa\DocumentoVenta@imprimir');

Route::resource('DocumentoVenta', 'Facturacionventa\DocumentoVenta');
//------------Modulo documento venta---------------////

//-------------------------------- Plan Cuentas ---------------/////////

Route::get('estadosfinacieros/plancuentastipo/{filtro}', 'Contabilidad\Plandecuetas@getplancuentasportipo');
Route::get('estadosfinacieros/borrarcuenta/{filtro}', 'Contabilidad\Plandecuetas@deletecuenta');
Route::get('estadosfinacieros/plancontabletotal', 'Contabilidad\Plandecuetas@plancontabletotal');

//-------------------------------- Asiento Contable ---------------/////////
Route::get('estadosfinacieros/numcomp/{filtro}', 'Contabilidad\Plandecuetas@NumComprobante');
Route::get('estadosfinacieros/asc/{transaccion}', 'Contabilidad\Plandecuetas@GuardarAsientoContable');
Route::get('estadosfinacieros/borrarasc/{id}', 'Contabilidad\Plandecuetas@BorrarAsientoContable');
Route::get('estadosfinacieros/datosasc/{id}', 'Contabilidad\Plandecuetas@DatosAsientoContable');
Route::get('estadosfinacieros/Editarasc/{transaccion}', 'Contabilidad\Plandecuetas@EditarAsientoContable');
//-------------------------------- Registro Contable ---------------/////////
Route::get('estadosfinacieros/registrocuenta/{filtro}', 'Contabilidad\Plandecuetas@LoadRegistroContable');

Route::resource('Contabilidad', 'Contabilidad\Plandecuetas');

//-------------------------------- Tipo Transaccion Contable---------------/////////
Route::get('transacciones/alltipotransacciones', 'Contabilidad\TipoTransaccion@getalltipotransacciones');


//-------------------------------- Guía Remisión---------------/////////
Route::resource('guiaremision', 'Guiaremision\GuiaremisionController');
Route::get('guiaremision/getransportista/{texto}', 'Guiaremision\GuiaremisionController@GetTrasportista');
Route::get('guiaremision/nuevaguia', 'Guiaremision\GuiaremisionController@geNuevaGuia');
Route::get('guiaremision/getformguia', 'Guiaremision\GuiaremisionController@formguia');
Route::get('guiaremision/getdestinatario/{texto}', 'Guiaremision\GuiaremisionController@BuscarDestinatario');
Route::get('guiaremision/getventa/{idventa}', 'Guiaremision\GuiaremisionController@BuscarVenta');
Route::get('guiaremision/venta/{texto}', 'Guiaremision\GuiaremisionController@GetVentanro');
Route::get('guiaremision/getGuia/{idguiaremision}', 'Guiaremision\GuiaremisionController@getGuia');

/*
 * ---------------------------------------Raidel Berrillo Gonzalez------------------------------------------------------
 */
Route::post('retencionCompra/anularRetencion', 'Retencion\RetencionCompraController@anularRetencion');
Route::get('retencionCompra/getLastIDRetencion', 'Retencion\RetencionCompraController@getLastIDRetencion');
Route::get('retencionCompra/getConfigContabilidad', 'Retencion\RetencionCompraController@getConfigContabilidad');
Route::get('retencionCompra/getRetenciones', 'Retencion\RetencionCompraController@getRetenciones');
Route::get('retencionCompra/getRetencionesByCompra/{id}', 'Retencion\RetencionCompraController@getRetencionesByCompra');
Route::get('retencionCompra/getCompras/{codigo}', 'Retencion\RetencionCompraController@getCompras');
Route::get('retencionCompra/getCodigos/{codigo}', 'Retencion\RetencionCompraController@getCodigos');
Route::get('retencionCompra/form/{id}', 'Retencion\RetencionCompraController@form');
Route::get('retencionCompra/getCodigosRetencion/{tipo}', 'Retencion\RetencionCompraController@getCodigosRetencion');
Route::resource('retencionCompras', 'Retencion\RetencionCompraController');

/*
 * ---------------------------------------------------------------------------------------------------------------------
 */


/*
 * -------------------------------------Modulo Configuracion del Sistema (Dayana)---------------------------------------
 */

Route::get('configuracion/getDataEmpresa', 'ConfiguracionSystem\ConfiguracionSystemController@getDataEmpresa');

Route::get('configuracion/getIVADefault', 'ConfiguracionSystem\ConfiguracionSystemController@getIVADefault');

Route::get('configuracion/getImpuestoIVA', 'ConfiguracionSystem\ConfiguracionSystemController@getImpuestoIVA');

Route::get('configuracion/getConfigSRI', 'ConfiguracionSystem\ConfiguracionSystemController@getConfigSRI');

Route::get('configuracion/getTipoEmision', 'ConfiguracionSystem\ConfiguracionSystemController@getTipoEmision');

Route::get('configuracion/getTipoAmbiente', 'ConfiguracionSystem\ConfiguracionSystemController@getTipoAmbiente');

Route::get('configuracion/getConfigEspecifica', 'ConfiguracionSystem\ConfiguracionSystemController@getConfigEspecifica');

Route::get('configuracion/getConfigNC', 'ConfiguracionSystem\ConfiguracionSystemController@getConfigNC');

Route::get('configuracion/getConfigVenta', 'ConfiguracionSystem\ConfiguracionSystemController@getConfigVenta');

Route::get('configuracion/getConfigCompra', 'ConfiguracionSystem\ConfiguracionSystemController@getConfigCompra');

Route::get('configuracion/getPlanCuenta', 'ConfiguracionSystem\ConfiguracionSystemController@getPlanCuenta');

Route::post('configuracion/updateEstablecimiento/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateEstablecimiento');

Route::put('configuracion/updateIvaDefault/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateIvaDefault');

Route::put('configuracion/updateConfigSRI/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateConfigSRI');

Route::put('configuracion/updateConfigEspecifica/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateConfigEspecifica');

Route::put('configuracion/updateConfigNC/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateConfigNC');

Route::put('configuracion/updateConfigVenta/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateConfigVenta');

Route::put('configuracion/updateConfigCompra/{id}', 'ConfiguracionSystem\ConfiguracionSystemController@updateConfigCompra');

Route::resource('configuracion', 'ConfiguracionSystem\ConfiguracionSystemController');


/*===================================Módulo Nomencladores===========================================*/

Route::get('Nomenclador/getTipoDocumento', 'Nomenclador\NomencladorController@getTipoDocumento' );
Route::get('Nomenclador/gettipoidentificacion', 'Nomenclador\NomencladorController@gettipoidentificacion' );
Route::get('Nomenclador/getTipoImpuesto', 'Nomenclador\NomencladorController@getTipoImpuesto' );
Route::get('Nomenclador/getTipoImpuestoEx', 'Nomenclador\NomencladorController@getTipoImpuestoEx' );
Route::get('Nomenclador/getImpuestoIVA', 'Nomenclador\NomencladorController@getImpuestoIVA' );
Route::get('Nomenclador/getImpuestoICE', 'Nomenclador\NomencladorController@getImpuestoICE' );
Route::get('Nomenclador/getTipoImpuestoRetenc', 'Nomenclador\NomencladorController@getTipoImpuestoRetenc' );
Route::get('Nomenclador/getImpuestoIVARENTA', 'Nomenclador\NomencladorController@getImpuestoIVARENTA' );
Route::get('Nomenclador/getSustentoTributario', 'Nomenclador\NomencladorController@getSustentoTributario' );
Route::get('Nomenclador/getSustentoTributarioEX', 'Nomenclador\NomencladorController@getSustentoTributarioEX' );
Route::get('Nomenclador/getTipoComprobante', 'Nomenclador\NomencladorController@getTipoComprobante' );
Route::get('Nomenclador/getPagoResidente', 'Nomenclador\NomencladorController@getPagoResidente' );
Route::get('Nomenclador/getPagoPais', 'Nomenclador\NomencladorController@getPagoPais' );
Route::get('Nomenclador/getContFormaPago', 'Nomenclador\NomencladorController@getContFormaPago' );
Route::get('Nomenclador/getprovincia', 'Nomenclador\NomencladorController@getprovincia' );
Route::get('Nomenclador/getprovinciaEX', 'Nomenclador\NomencladorController@getprovinciaEX' );
Route::get('Nomenclador/getCantonEX', 'Nomenclador\NomencladorController@getCantonEX' );
Route::get('Nomenclador/getCantonEXA', 'Nomenclador\NomencladorController@getCantonEXA' );
Route::get('Nomenclador/getParroquiaEX', 'Nomenclador\NomencladorController@getParroquiaEX' );




Route::get('Nomenclador/getTipoDocByID/{id}', 'Nomenclador\NomencladorController@getTipoDocByID');
Route::get('Nomenclador/getTipoIdentByID/{id}', 'Nomenclador\NomencladorController@getTipoIdentByID');
Route::get('Nomenclador/getTipoImpuestoByID/{id}', 'Nomenclador\NomencladorController@getTipoImpuestoByID');
Route::get('Nomenclador/getTipoImpuestoIvaByID/{id}', 'Nomenclador\NomencladorController@getTipoImpuestoIvaByID' );
Route::get('Nomenclador/getTipoImpuestoIceByID/{id}', 'Nomenclador\NomencladorController@getTipoImpuestoIceByID' );
Route::get('Nomenclador/getTipoImpuestoRetencionRetByID/{id}', 'Nomenclador\NomencladorController@getTipoImpuestoRetencionRetByID' );
Route::get('Nomenclador/getTipoImpuestoRetencionIvaRetByID/{id}', 'Nomenclador\NomencladorController@getTipoImpuestoRetencionIvaRetByID' );
Route::get('Nomenclador/getSustentoTributarioByID/{id}', 'Nomenclador\NomencladorController@getSustentoTributarioByID' );
Route::get('Nomenclador/getComprobanteTributarioByID/{id}', 'Nomenclador\NomencladorController@getComprobanteTributarioByID' );
Route::get('Nomenclador/getSustentoComprobanteByID/{id}', 'Nomenclador\NomencladorController@getSustentoComprobanteByID' );
Route::get('Nomenclador/getPagoResidenteByID/{id}', 'Nomenclador\NomencladorController@getPagoResidenteByID' );
Route::get('Nomenclador/getPaisPagoByID/{id}', 'Nomenclador\NomencladorController@getPaisPagoByID' );
Route::get('Nomenclador/getFormaPagoByID/{id}', 'Nomenclador\NomencladorController@getFormaPagoByID' );
Route::get('Nomenclador/getprovinciaByID/{id}', 'Nomenclador\NomencladorController@getprovinciaByID' );
Route::get('Nomenclador/getcantonEXByID/{id}', 'Nomenclador\NomencladorController@getcantonEXByID' );
Route::get('Nomenclador/getparroquiaEXByID/{id}', 'Nomenclador\NomencladorController@getparroquiaEXByID' );



Route::post('Nomenclador/updatetpidentsri/{id}', 'Nomenclador\NomencladorController@updatetpidentsri' );
Route::post('Nomenclador/updatetpimpsri/{id}', 'Nomenclador\NomencladorController@updatetpimpsri' );
Route::post('Nomenclador/updatetpimpIvasri/{id}', 'Nomenclador\NomencladorController@updatetpimpIvasri' );
Route::post('Nomenclador/updatetpimpIcesri/{id}', 'Nomenclador\NomencladorController@updatetpimpIcesri' );
Route::post('Nomenclador/updatetpimpRetensri/{id}', 'Nomenclador\NomencladorController@updatetpimpRetensri' );
Route::post('Nomenclador/updatetpimpIvaRetensri/{id}', 'Nomenclador\NomencladorController@updatetpimpIvaRetensri' );
Route::post('Nomenclador/updateSustentoTributario/{id}', 'Nomenclador\NomencladorController@updateSustentoTributario' );
Route::post('Nomenclador/updateSustento_Comprobante/{id}', 'Nomenclador\NomencladorController@updateSustento_Comprobante' );
Route::post('Nomenclador/updatePagoResidente/{id}', 'Nomenclador\NomencladorController@updatePagoResidente' );
Route::post('Nomenclador/updatePagoPais/{id}', 'Nomenclador\NomencladorController@updatePagoPais' );
Route::post('Nomenclador/updateFormaPago/{id}', 'Nomenclador\NomencladorController@updateFormaPago' );
Route::post('Nomenclador/updateprovincia/{id}', 'Nomenclador\NomencladorController@updateprovincia' );
Route::post('Nomenclador/updatecantonEX/{id}', 'Nomenclador\NomencladorController@updatecantonEX' );
Route::post('Nomenclador/updateparroquiaEX/{id}', 'Nomenclador\NomencladorController@updateparroquiaEX' );

Route::post('Nomenclador/getTipoDocumento','Nomenclador\NomencladorController@store');
Route::post('Nomenclador/storeTipoIdent','Nomenclador\NomencladorController@storeTipoIdent');
Route::post('Nomenclador/storeTipoImpuesto','Nomenclador\NomencladorController@storeTipoImpuesto');
Route::post('Nomenclador/storeTipoImpuestoiva','Nomenclador\NomencladorController@storeTipoImpuestoiva');
Route::post('Nomenclador/storeTipoImpuestoice','Nomenclador\NomencladorController@storeTipoImpuestoice');
Route::post('Nomenclador/storeTipoImpuestoReten','Nomenclador\NomencladorController@storeTipoImpuestoReten');
Route::post('Nomenclador/storeTipoImpuestoIvaReten','Nomenclador\NomencladorController@storeTipoImpuestoIvaReten');
Route::post('Nomenclador/storeSustentoTrib','Nomenclador\NomencladorController@storeSustentoTrib');
Route::post('Nomenclador/storeComprobanteSustento','Nomenclador\NomencladorController@storeComprobanteSustento');
Route::post('Nomenclador/storeTipoPagoResidente','Nomenclador\NomencladorController@storeTipoPagoResidente');
Route::post('Nomenclador/storepagopais','Nomenclador\NomencladorController@storepagopais');
Route::post('Nomenclador/storeformapago','Nomenclador\NomencladorController@storeformapago');
Route::post('Nomenclador/storeprovincia','Nomenclador\NomencladorController@storeprovincia');
Route::post('Nomenclador/storecantonEX','Nomenclador\NomencladorController@storecantonEX');
Route::post('Nomenclador/storeparroquiaEX','Nomenclador\NomencladorController@storeparroquiaEX');


Route::post('Nomenclador/deleteTipoIdentSRI', 'Nomenclador\NomencladorController@deleteTipoIdentSRI');
Route::post('Nomenclador/deleteTipoImpuesto', 'Nomenclador\NomencladorController@deleteTipoImpuesto');
Route::post('Nomenclador/deleteTipoImpuestoIva', 'Nomenclador\NomencladorController@deleteTipoImpuestoIva');
Route::post('Nomenclador/deleteTipoImpuestoIce', 'Nomenclador\NomencladorController@deleteTipoImpuestoIce');
Route::post('Nomenclador/deleteTipoImpuestoRetencion', 'Nomenclador\NomencladorController@deleteTipoImpuestoRetencion');
Route::post('Nomenclador/deleteTipoImpuestoIvaRetencion', 'Nomenclador\NomencladorController@deleteTipoImpuestoIvaRetencion');
Route::post('Nomenclador/deleteSustentoTrib', 'Nomenclador\NomencladorController@deleteSustentoTrib');
Route::post('Nomenclador/deleteSustentoComprobante', 'Nomenclador\NomencladorController@deleteSustentoComprobante');
Route::post('Nomenclador/deleteTipoPagoResidente', 'Nomenclador\NomencladorController@deleteTipoPagoResidente');
Route::post('Nomenclador/deletepagopais', 'Nomenclador\NomencladorController@deletepagopais');
Route::post('Nomenclador/deleteformapago', 'Nomenclador\NomencladorController@deleteformapago');
Route::post('Nomenclador/deleteprovincia', 'Nomenclador\NomencladorController@deleteprovincia');
Route::post('Nomenclador/deletecantonEX', 'Nomenclador\NomencladorController@deletecantonEX');
Route::post('Nomenclador/deleteParroquiaEX', 'Nomenclador\NomencladorController@deleteParroquiaEX');


Route::resource('/Nomenclador', 'Nomenclador\NomencladorController');

/*
 * ---------------------------------------------------------------------------------------------------------------------
 */


//-------------------------------- Inveario Intem Kardex ---------------/////////

Route::resource('Inventario', 'CatalogoProductos\InventarioKardex');
Route::get('procesoskardex/loadbodegas', 'CatalogoProductos\InventarioKardex@cargarbodegas');
Route::get('procesoskardex/loadcategoria', 'CatalogoProductos\InventarioKardex@cargarcategoria');
Route::get('procesoskardex/loadsubcategoria/{id}', 'CatalogoProductos\InventarioKardex@cargarsubcategoria');
Route::get('procesoskardex/loadinventario', 'CatalogoProductos\InventarioKardex@cargarinvetarioporbodega');
Route::get('procesoskardex/loadkardex/{filtro}', 'CatalogoProductos\InventarioKardex@kardexitem');

//-------------------------------- Inveario Intem Kardex ---------------/////////

/*
 * ------------------------------------- Modulo Rol---------------------------------------------------------------------
 */

Route::get('rol/getPermisos', 'Rol\RolController@getPermisos');
Route::get('rol/getRolByID/{id}', 'Rol\RolController@getRolByID');
Route::get('rol/getRoles', 'Rol\RolController@getRoles');

Route::resource('/rol', 'Rol\RolController');

/*
 * ------------------------------------- Modulo Alterno Compras (NO OFICIAL)--------------------------------------------
 */

Route::post('DocumentoCompras/anularCompra', 'Compras\ComprasController@anularCompra');
Route::get('DocumentoCompras/getPaisPagoComprobante', 'Compras\ComprasController@getPaisPagoComprobante');
Route::get('DocumentoCompras/getTipoPagoComprobante', 'Compras\ComprasController@getTipoPagoComprobante');
Route::get('DocumentoCompras/getLastIDCompra', 'Compras\ComprasController@getLastIDCompra');
Route::get('DocumentoCompras/porcentajeivaiceotro', 'Compras\ComprasController@getCofiguracioncontable');
Route::get('DocumentoCompras/getProveedorByIdentify/{identify}', 'Compras\ComprasController@getProveedorByIdentify');
Route::get('DocumentoCompras/getProveedorByFilter', 'Compras\ComprasController@getProveedorByFilter' );
Route::get('DocumentoCompras/getBodegas', 'Compras\ComprasController@getBodegas' );
Route::get('DocumentoCompras/getSustentoTributario', 'Compras\ComprasController@getSustentoTributario' );
Route::get('DocumentoCompras/getTipoComprobante/{idsustento}', 'Compras\ComprasController@getTipoComprobante' );
Route::get('DocumentoCompras/getFormaPago', 'Compras\ComprasController@getFormaPago' );
Route::get('DocumentoCompras/getCompras', 'Compras\ComprasController@getCompras');
Route::resource('DocumentoCompras', 'Compras\ComprasController');

//-------------------------------- Guía Remisión---------------/////////
Route::resource('guiaremision', 'Guiaremision\GuiaremisionController');
Route::get('guiaremision/getransportista/{texto}', 'Guiaremision\GuiaremisionController@GetTrasportista');
Route::get('guiaremision/nuevaguia', 'Guiaremision\GuiaremisionController@geNuevaGuia');
Route::get('guiaremision/getformguia', 'Guiaremision\GuiaremisionController@formguia');
Route::get('guiaremision/getdestinatario/{texto}', 'Guiaremision\GuiaremisionController@BuscarDestinatario');
Route::get('guiaremision/getventa/{idventa}', 'Guiaremision\GuiaremisionController@BuscarVenta');
Route::get('guiaremision/venta/{texto}', 'Guiaremision\GuiaremisionController@GetVentanro');
Route::get('guiaremision/getGuia/{idguiaremision}', 'Guiaremision\GuiaremisionController@getGuia');
//-------------------------------- Punto de Venta---------------/////////
Route::resource('puntoventa', 'Contabilidad\PuntoVentaController');
Route::get('puntoventa/getpuntoventas', 'PuntoVenta\PuntoVentaController@getPuntoventa');
Route::get('puntoventa/getempleado/{texto}', 'Contabilidad\PuntoVentaController@getEmpleado');
Route::get('puntoventa/verificaremision/{emision}', 'Contabilidad\PuntoVentaController@verificarCodigo');
Route::get('puntoventa/cargaestablecimiento', 'Contabilidad\PuntoVentaController@cargaEstablecimiento');
Route::get('puntoventa/cargarpuntoventa/{id}', 'Contabilidad\PuntoVentaController@cargarPuntoVenta');
Route::get('puntoventa/verificarvacio', 'Contabilidad\PuntoVentaController@empleadoVacio');