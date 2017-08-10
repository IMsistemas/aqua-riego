<?php

namespace App\Http\Controllers\Solicitud;

use App\Modelos\Clientes\Cliente;
use App\Modelos\Clientes\ClienteArriendo;
use App\Modelos\Solicitud\Solicitud;
use App\Modelos\Solicitud\SolicitudCambioNombre;
use App\Modelos\Solicitud\SolicitudOtro;
use App\Modelos\Solicitud\SolicitudReparticion;
use App\Modelos\Solicitud\SolicitudRiego;
use App\Modelos\Terreno\Terreno;
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
        return view('Solicitud/index');
    }

    public function getSolicitudes(Request $request)
    {
        $filter_view = json_decode($request->get('filter'));

        $list_solicitudes = Solicitud::join('cliente', 'solicitud.idcliente', '=', 'cliente.idcliente')
                                        ->join('persona', 'cliente.idpersona', '=', 'persona.idpersona');

        if ($filter_view->tipo == 4) {

            $list_solicitudes = $list_solicitudes->selectRaw(
                   '*, (SELECT idsolicitudriego FROM solicitudriego WHERE solicitudriego.idsolicitud = solicitud.idsolicitud) AS solicitudriego'
            )->join('solicitudriego', 'solicitud.idsolicitud', '=', 'solicitudriego.idsolicitud');

        } else if ($filter_view->tipo == 3) {

            $list_solicitudes = $list_solicitudes->selectRaw(
                '*, (SELECT idsolicitudcambionombre FROM solicitudcambionombre WHERE solicitudcambionombre.idsolicitud = solicitud.idsolicitud) AS solicitudcambionombre'
            )->join('solicitudcambionombre', 'solicitud.idsolicitud', '=', 'solicitudcambionombre.idsolicitud');

        } else if ($filter_view->tipo == 2) {

            $list_solicitudes = $list_solicitudes->selectRaw(
                '*, (SELECT idsolicitudreparticion FROM solicitudreparticion WHERE solicitudreparticion.idsolicitud = solicitud.idsolicitud) AS solicitudreparticion'
            )->join('solicitudreparticion', 'solicitud.idsolicitud', '=', 'solicitudreparticion.idsolicitud');

        } else if ($filter_view->tipo == 1) {

            $list_solicitudes = $list_solicitudes->selectRaw(
                '*, (SELECT idsolicitudotro FROM solicitudotro WHERE solicitudotro.idsolicitud = solicitud.idsolicitud) AS solicitudotro'
            )->join('solicitudotro', 'solicitud.idsolicitud', '=', 'solicitudotro.idsolicitud');

        } else {
            $list_solicitudes = $list_solicitudes->selectRaw(
                '*, (SELECT idsolicitudotro FROM solicitudotro WHERE solicitudotro.idsolicitud = solicitud.idsolicitud) AS solicitudotro,
                (SELECT idsolicitudcambionombre FROM solicitudcambionombre WHERE solicitudcambionombre.idsolicitud = solicitud.idsolicitud) AS solicitudcambionombre,
                (SELECT idsolicitudreparticion FROM solicitudreparticion WHERE solicitudreparticion.idsolicitud = solicitud.idsolicitud) AS solicitudreparticion,
                (SELECT idsolicitudriego FROM solicitudriego WHERE solicitudriego.idsolicitud = solicitud.idsolicitud) AS solicitudriego'
            );
        }


        /*$list_solicitudes = Solicitud::join('cliente', 'solicitud.idcliente', '=', 'cliente.idcliente')
                                        ->join('persona', 'cliente.idpersona', '=', 'persona.idpersona')
                                        ->selectRaw('*, (SELECT idsolicitudotro FROM solicitudotro WHERE solicitudotro.idsolicitud = solicitud.idsolicitud) AS solicitudotro,
                (SELECT idsolicitudcambionombre FROM solicitudcambionombre WHERE solicitudcambionombre.idsolicitud = solicitud.idsolicitud) AS solicitudcambionombre,
                (SELECT idsolicitudreparticion FROM solicitudreparticion WHERE solicitudreparticion.idsolicitud = solicitud.idsolicitud) AS solicitudreparticion,
                (SELECT idsolicitudriego FROM solicitudriego WHERE solicitudriego.idsolicitud = solicitud.idsolicitud) AS solicitudriego');*/

        if ($filter_view->estado != 3) {
            if ($filter_view->estado == 2) {
                $list_solicitudes = $list_solicitudes->where('estaprocesada', false);
            } else {
                $list_solicitudes = $list_solicitudes->where('estaprocesada', true);
            }
        }

        return $list_solicitudes->orderBy('solicitud.idsolicitud', 'desc')->orderBy('fechasolicitud', 'desc')->paginate(10);
    }

    public function getByFilter($filter)
    {
        $filter_view = json_decode($filter);

        $solicitudriego = [];
        $solicitudsetname = [];
        $solicitudreparticion = [];
        $solicitudotro = [];

        if ($filter_view->estado != 3) {

            $estado = true;
            if ($filter_view->estado == 2) $estado = false;

            if ($filter_view->tipo == 4){
                $solicitudriego = SolicitudRiego::with('solicitud.cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 3){
                $solicitudsetname = SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 2){
                $solicitudreparticion = SolicitudReparticion::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 1){
                $solicitudotro = SolicitudOtro::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
            } else {
                $solicitudriego = SolicitudRiego::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
                $solicitudotro = SolicitudOtro::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
                $solicitudsetname = SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
                $solicitudreparticion = SolicitudReparticion::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->where('estaprocesada', $estado)->orderBy('fechasolicitud', 'desc')->get();
            }

        } else {
            if ($filter_view->tipo == 4){
                $solicitudriego = SolicitudRiego::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 3){
                $solicitudsetname = SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 2){
                $solicitudreparticion = SolicitudReparticion::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->orderBy('fechasolicitud', 'desc')->get();
            } else if ($filter_view->tipo == 1){
                $solicitudotro = SolicitudOtro::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->orderBy('fechasolicitud', 'desc')->get();
            } else {
                $solicitudriego = SolicitudRiego::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->orderBy('fechasolicitud', 'desc')->get();
                $solicitudotro = SolicitudOtro::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->orderBy('fechasolicitud', 'desc')->get();
                $solicitudsetname = SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                    ->orderBy('fechasolicitud', 'desc')->get();
                $solicitudreparticion = SolicitudReparticion::with('cliente')->orderBy('fechasolicitud', 'desc')
                    ->orderBy('fechasolicitud', 'desc')->get();
            }
        }

        return response()->json([
            'riego' => $solicitudriego, 'otro' => $solicitudotro,
            'setname' => $solicitudsetname, 'reparticion' => $solicitudreparticion
        ]);
    }

    public function getIdentifyCliente($idcliente)
    {
        return Cliente::where('codigocliente', $idcliente)->get();
    }

    public function getSolicitudOtro($idsolicitud)
    {
        return SolicitudOtro::with('cliente')->where('idsolicitud', $idsolicitud)->get();
    }

    public function getSolicitudRiego($idsolicitud)
    {
        return SolicitudRiego::with('terreno.derivacion.canal.calle')->where('idsolicitudriego', $idsolicitud)->get();
    }

    public function getSolicitudSetN($idsolicitud)
    {
        return SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio', 'terreno.cultivo')
                                    ->where('idsolicitudcambionombre', $idsolicitud)->get();
    }

    public function getSolicitudFraccion($idsolicitud)
    {
        return SolicitudReparticion::with('cliente', 'terreno.derivacion.canal.calle.barrio', 'terreno.cultivo')
                                    ->where('idsolicitudreparticion', $idsolicitud)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function getURLPDF($id)
    {
        return SolicitudRiego::join('terreno', 'terreno.idterreno', '=', 'solicitudriego.idterreno')
                                ->where('idsolicitudriego', $id)->get();
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
        $solicitud = Solicitud::find($id);

        $solicitud->estaprocesada = true;
        $solicitud->fechaprocesada = date('Y-m-d');

        $solicitud->save();

        return response()->json(['success' => true]);
    }

    public function updateSolicitudOtro(Request $request, $id)
    {

        $solicitud = SolicitudOtro::find($id);

        $solicitud->fechasolicitud = $request->input('fecha_solicitud');
        $solicitud->descripcion = $request->input('observacion');
        $result = $solicitud->save();

        return ($result) ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function updateSolicitudRiego(Request $request, $id)
    {
        $solicitudriego = SolicitudRiego::find($id);
        //$solicitudriego->fechasolicitud = $request->input('fecha_solicitud');
        $solicitudriego->observacion = $request->input('observacion');
        $result = $solicitudriego->save();

        $terreno = Terreno::find($solicitudriego->idterreno);
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->idderivacion = $request->input('idderivacion');
        $terreno->fechacreacion = $request->input('fecha_solicitud');
        $terreno->caudal = $request->input('caudal');
        $terreno->area = $request->input('area');
        $terreno->valoranual = $request->input('valoranual');
        $terreno->observacion = $request->input('observacion');

        $terreno->save();

        return ($result) ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function updateSolicitudSetName(Request $request, $id)
    {
        $solicitudsetname = SolicitudCambioNombre::find($id);
        $solicitudsetname->codigocliente = $request->input('codigocliente_old');
        $solicitudsetname->codigonuevocliente = $request->input('codigocliente_new');
        $solicitudsetname->idterreno = $request->input('idterreno');
        $solicitudsetname->fechasolicitud = $request->input('fecha_solicitud');
        $solicitudsetname->observacion = $request->input('observacion');

        $result = $solicitudsetname->save();

        return ($result) ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function updateSolicitudFraccion(Request $request, $id)
    {
        $solicitud = SolicitudReparticion::find($id);
        $solicitud->codigocliente = $request->input('codigocliente_old');
        $solicitud->codigonuevocliente = $request->input('codigocliente_new');
        $solicitud->idterreno = $request->input('idterreno');
        $solicitud->fechasolicitud = $request->input('fecha_solicitud');
        $solicitud->observacion = $request->input('observacion');
        $solicitud->nuevaarea = $request->input('area');

        $result = $solicitud->save();

        return ($result) ? response()->json(['success' => true]) : response()->json(['success' => false]);
    }

    public function processSolicitudSetName(Request $request, $id)
    {
        $solicitud = SolicitudCambioNombre::find($id);

        $terreno = Terreno::find($solicitud->idterreno);
        $terreno->codigocliente = $solicitud->codigonuevocliente;
        $terreno->save();

        $solicitud->estaprocesada = true;
        $solicitud->fechaprocesada = date('Y-m-d');
        $solicitud->save();

        return response()->json(['success' => true]);
    }

    public function processSolicitudFraccion(Request $request, $id)
    {
        $solicitud = SolicitudReparticion::find($id);

        $arriendo = new ClienteArriendo();
        $arriendo->codigoclientearrendador = $solicitud->codigonuevocliente;
        $arriendo->codigoclientearrendatario = $solicitud->codigocliente;
        $arriendo->idterreno = $solicitud->idterreno;
        $arriendo->areaarriendo = $solicitud->nuevaarea;
        $arriendo->save();

        $solicitud->estaprocesada = true;
        $solicitud->fechaprocesada = date('Y-m-d');
        $solicitud->save();
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
        //
    }
}
