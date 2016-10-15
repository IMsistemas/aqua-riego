<?php

namespace App\Http\Controllers\Solicitud;

use App\Modelos\Clientes\Cliente;
use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Solicitud\Solicitud;
use App\Modelos\Tarifas\Area;
use App\Modelos\Tarifas\Tarifa;
use App\Modelos\Terreno\Cultivo;
use App\Modelos\Terreno\Terreno;
use App\Modelos\Ubicacion\Canal;
use App\Modelos\Ubicacion\Derivacion;
use App\Modelos\Ubicacion\Toma;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class SolicitudController
 * @package App\Http\Controllers\Solicitud
 */
class SolicitudController2 extends Controller
{

    /**
     * Mostrar la vista de Solicitud.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Solicitud.solicitud');
    }

    /**
     * Obtener el ultimo id insertado y sumar 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastID()
    {
        $solicitud = Solicitud::max('idsolicitud');

        $lastId = ($solicitud == null || $solicitud == '' || $solicitud == 0) ? 1 : $solicitud + 1;

        return response()->json(['lastId' => $lastId]);
    }

    /**
     * Obtener el ultimo id insertado y sumar 1 en Nro de Terreno
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastIDTerreno()
    {
        $terreno = Terreno::max('idterreno');

        $lastId = ($terreno == null || $terreno == '' || $terreno == 0) ? 1 : $terreno + 1;

        return response()->json(['lastId' => $lastId]);
    }

    /**
     * Obtener el listado de Solicitudes ordenadas por estado
     *
     * @return mixed
     */
    public function getSolicitudes()
    {
        return Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente')
                            ->orderBy('estaprocesada', 'asc')
                                ->get();
    }

    /**
     * Obtener el listado de Solicitudes ordenadas por estado en base a busqueda por filtros
     *
     * @param $filters
     * @return mixed
     */
    public function getByFilters($filters)
    {
        $filter = json_decode($filters);

        $solicitud = Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente');

        if($filter->text != null){
            $solicitud->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
            $solicitud->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');
        }

        if($filter->estado != null && $filter->estado != '3'){
            $estado = ($filter->estado == '1') ? true : false;
            $solicitud->where('estaprocesada', $estado);
        }

        return $solicitud->orderBy('estaprocesada', 'asc')->get();
    }

    /**
     * Obtener un cliente en base a su id
     *
     * @param $idcliente
     * @return mixed
     */
    public function getClienteByID($idcliente)
    {
        return Cliente::find($idcliente);
    }

    /**
     * Obtener la constante en los datos de configuracion
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getConstante()
    {
        return Configuracion::all();
    }

    /**
     * Obtener las tarifas ordenadas ascendentemente
     *
     * @return mixed
     */
    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    /**
     * Obtener los barrios ordenados ascendentemente
     *
     * @return mixed
     */
    public function getBarrios()
    {
        return Barrio::orderBy('nombrebarrio', 'asc')->get();
    }

    /**
     * Obtener los cultivos ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCultivos()
    {
        return Cultivo::orderBy('nombrecultivo', 'asc')->get();
    }

    /**
     * Obtener los canales ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCanales()
    {
        return Canal::orderBy('descripcioncanal', 'asc')->get();
    }

    /**
     * Obtener las tomas de un canal ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getTomas($idcanal)
    {
        return Toma::where('idcanal', $idcanal)->orderBy('descripciontoma', 'asc')->get();
    }

    /**
     * Obtener las derivaciones de una toma ordenadas ascendentemente
     *
     * @param $idtoma
     * @return mixed
     */
    public function getDerivaciones($idtoma)
    {
        return Derivacion::where('idtoma', $idtoma)->orderBy('descripcionderivacion', 'asc')->get();
    }

    /**
     * Almacenar un cultivo nuevo y obtener su id de insercion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCultivo(Request $request)
    {
        $cultivo = new Cultivo();
        $cultivo->nombrecultivo = $request->input('name');
        $cultivo->save();

        return response()->json(['success' => true, 'idcultivo' => $cultivo->idcultivo]);
    }

    /**
     * Obtener el resultado de calculo del costo en base al area
     *
     * @param $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateValor($area)
    {
        $area_h = $area / 10000;
        $configuracion = Configuracion::all();

        $costo_area = Area::where('desde', '<', $area_h)
                            ->where('hasta', '>=', $area_h)
                            ->get();

        if ($costo_area[0]->esfija == true){
            $costo = $costo_area[0]->costo;
        } else {
            $costo = $area_h * $configuracion[0]->constante * $costo_area[0]->costo;
        }

        return response()->json(['costo' => $costo]);
    }

    /**
     * Almacenar los datos correspondientes a cliente, asi como su solicitud.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();

        $cliente->documentoidentidad = $request->input('codigocliente');
        $cliente->fechaingreso = $request->input('fechaingreso');
        $cliente->apellido = $request->input('apellido');
        $cliente->nombre = $request->input('nombre');
        $cliente->celular = $request->input('celular');
        $cliente->correo = $request->input('email');
        $cliente->direcciondomicilio = $request->input('direccion');
        $cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipal');
        $cliente->telefonosecundariodomicilio = $request->input('telefonosecundario');
        $cliente->direcciontrabajo = $request->input('direccionemp');
        $cliente->telefonoprincipaltrabajo = $request->input('telfprincipalemp');
        $cliente->telefonosecundariotrabajo = $request->input('telfsecundarioemp');
        $cliente->estaactivo = true;

        $cliente->save();

        $solicitud = new Solicitud();
        $solicitud->codigocliente = $cliente->codigocliente;
        $solicitud->fechasolicitud = $request->input('fechaingreso');
        $solicitud->estaprocesada = false;
        $solicitud->save();

        return response()->json(['success' => true]);

    }

    /**
     * Procesar la solicitud, almacenando los datos del cliente y su solicitud
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function processSolicitud(Request $request)
    {
        $terreno = new Terreno();
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->codigocliente = $request->input('codigocliente');
        $terreno->idderivacion = $request->input('idderivacion');
        $terreno->fechacreacion = $request->input('fechacreacion');
        $terreno->caudal = $request->input('caudal');
        $terreno->area = $request->input('area');
        $terreno->valoranual = $request->input('valoranual');
        $terreno->idbarrio = $request->input('idbarrio');

        $result = $terreno->save();

        $solicitud = Solicitud::find($request->input('idsolicitud'));
        $solicitud->fechaprocesada = $request->input('fechacreacion');
        $solicitud->estaprocesada = true;

        $solicitud->save();

        return ($result) ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

}
