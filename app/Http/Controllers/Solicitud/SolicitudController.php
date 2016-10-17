<?php

namespace App\Http\Controllers\Solicitud;

use App\Modelos\Solicitud\Solicitud;
use App\Modelos\Solicitud\SolicitudCambioNombre;
use App\Modelos\Solicitud\SolicitudOtro;
use App\Modelos\Solicitud\SolicitudReparticion;
use App\Modelos\Solicitud\SolicitudRiego;
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
