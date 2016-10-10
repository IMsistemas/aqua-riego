<?php

namespace App\Http\Controllers\Clientes;

use App\Modelos\Clientes\Cliente;
use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Solicitud\Solicitud;
use App\Modelos\Solicitud\SolicitudRiego;
use App\Modelos\Tarifas\Area;
use App\Modelos\Tarifas\Tarifa;
use App\Modelos\Terreno\Cultivo;
use App\Modelos\Terreno\Terreno;
use App\Modelos\Tomas\Calle;
use App\Modelos\Tomas\Canal;
use App\Modelos\Tomas\Derivacion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Clientes/index');
    }


    public function getClientes()
    {
        return Cliente::orderBy('fechaingreso', 'asc')->get();
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

    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    public function getCultivos($idtarifa)
    {
        return Cultivo::where('idtarifa', $idtarifa)->orderBy('nombrecultivo', 'asc')->get();
    }

    /**
     * Obtener las tomas de un canal ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getTomas($idbarrio)
    {
        return Calle::where('idbarrio', $idbarrio)->orderBy('nombrecalle', 'asc')->get();
    }

    /**
     * Obtener los canales ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCanales($idcalle)
    {
        return Canal::where('idcalle', $idcalle)->orderBy('nombrecanal', 'asc')->get();
    }

    /**
     * Obtener las derivaciones de una toma ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getDerivaciones($idcanal)
    {
        return Derivacion::where('idcanal', $idcanal)->orderBy('nombrederivacion', 'asc')->get();
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
     * Obtener el resultado de calculo del costo en base al area
     *
     * @param $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateValor($area)
    {
        $area_h = $area / 1000;
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

        return response()->json(['success' => true]);
    }

    public function storeSolicitudRiego(Request $request)
    {
        $terreno = new Terreno();
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->codigocliente = $request->input('codigocliente');
        $terreno->idderivacion = $request->input('idderivacion');
        $terreno->fechacreacion = date('Y-m-d');
        $terreno->caudal = $request->input('caudal');
        $terreno->area = $request->input('area');
        $terreno->valoranual = $request->input('valoranual');
        $terreno->observacion = $request->input('observacion');

        $terreno->save();

        $solicitud = new Solicitud();
        $solicitud->codigocliente = $request->input('codigocliente');
        $solicitud->fechasolicitud = date('Y-m-d');
        $solicitud->estaprocesada = false;

        $result = $solicitud->save();


        $solicitudriego = new SolicitudRiego();
        $solicitudriego->codigocliente = $request->input('codigocliente');
        $solicitudriego->idsolicitud = $solicitud->idsolicitud;
        $solicitudriego->fechasolicitud = date('Y-m-d');
        $solicitudriego->estaprocesada = false;

        $solicitudriego->observacion = $request->input('observacion');

        $result = $solicitudriego->save();

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

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

        $cliente->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return response()->json(['success' => true]);
    }
}
