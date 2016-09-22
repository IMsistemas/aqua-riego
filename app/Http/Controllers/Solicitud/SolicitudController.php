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

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Solicitud.solicitud');
    }

    public function getSolicitudes()
    {
        return Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente')
                            ->orderBy('estaprocesada', 'asc')
                                ->get();
    }

    public function getByFilters($filters)
    {
        $filter = json_decode($filters);

        $solicitud = Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente');

        if($filter->text != null){
            $solicitud->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
            $solicitud->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');
        }

        if($filter->estado != null){
            $solicitud->where('estaprocesada', $filter->estado);
        }

        return $solicitud->get();
    }

    public function getClienteByID($idcliente)
    {
        return Cliente::find($idcliente);
    }

    public function getConstante()
    {
        return Configuracion::all();
    }

    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    public function getBarrios()
    {
        return Barrio::orderBy('nombrebarrio', 'asc')->get();
    }

    public function getCultivos()
    {
        return Cultivo::orderBy('nombrecultivo', 'asc')->get();
    }

    public function getCanales()
    {
        return Canal::orderBy('descripcioncanal', 'asc')->get();
    }

    public function getTomas($idcanal)
    {
        return Toma::where('idcanal', $idcanal)->orderBy('descripciontoma', 'asc')->get();
    }

    public function getDerivaciones($idtoma)
    {
        return Derivacion::where('idtoma', $idtoma)->orderBy('descripcionderivacion', 'asc')->get();
    }

    public function saveCultivo(Request $request)
    {
        $cultivo = new Cultivo();
        $cultivo->nombrecultivo = $request->input('name');
        $cultivo->save();

        return response()->json(['success' => true, 'idcultivo' => $cultivo->idcultivo]);
    }

    public function calculateValor($area)
    {
        $area_h = $area / 10000;
        $configuracion = Configuracion::all();

        $costo_area = Area::where('desde', '<', $area_h)
                            ->where('hasta', '>=', $area_h)
                            ->get();

        $costo = 0;

        if ($costo_area[0]->esfija == true){
            $costo = $costo_area[0]->costo;
        } else {
            $costo = $area_h * $configuracion[0]->constante * $costo_area[0]->costo;
        }

        return response()->json(['costo' => $costo]);
    }

    /**
     * Store a newly created resource in storage.
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


}
