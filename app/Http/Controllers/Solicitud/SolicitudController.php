<?php

namespace App\Http\Controllers\Solicitud;

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


    public function getSolicitudes()
    {
        $solicitudriego = SolicitudRiego::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                                            ->orderBy('fechasolicitud', 'desc')
                                            ->get();
        $solicitudotro = SolicitudOtro::with('cliente')->orderBy('fechasolicitud', 'desc')
                                            ->get();
        $solicitudsetname = SolicitudCambioNombre::with('cliente', 'terreno.derivacion.canal.calle.barrio')
                                            ->orderBy('fechasolicitud', 'desc')
                                            ->get();
        $solicitudreparticion = SolicitudReparticion::with('cliente')->orderBy('fechasolicitud', 'desc')
                                            ->get();
        return response()->json([
            'riego' => $solicitudriego, 'otro' => $solicitudotro,
            'setname' => $solicitudsetname, 'reparticion' => $solicitudreparticion
        ]);
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
                $solicitudriego = SolicitudRiego::with('cliente', 'terreno.derivacion.canal.calle.barrio')
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
