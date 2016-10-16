<?php

namespace App\Http\Controllers\Tomas;

use App\Modelos\Tomas\Calle;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Tomas\Derivacion;
use App\Modelos\Tomas\Tomas;
use App\Modelos\Tomas\Canal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CanallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tomas/canall');
    }


    public function getDerivacionesByCalle($id)
    {
        return Canal::with('derivacion')->where('idcalle', $id)->orderBy('nombrecanal')->get();
    }

    public function getCanalesByCalle($id)
    {
        return Canal::with('derivacion')->where('idcalle', $id)->orderBy('nombrecanal', 'asc')->get();
    }
    public function getCanall()
    {
        return Canal::with('derivacion')->orderBy('nombrecanal', 'asc')->get();
    }

    public function getCanal()
    {
        return Canal::orderBy('nombrecanal', 'asc')->get();
    }

    public function getCanalesById($id){
        return Canal::with('derivacion')->where('idcalle', $id)->orderBy('nombrecanal','asc')->get();
    }

    public function getCanalesByCalle1($id){
        return Canal::where('idcalle', $id)->orderBy('nombrecanal', 'asc')->get();
    }

    public function getCanalesByBarrio($id)
    {
        return Calle::with('canal.derivacion')->where('idbarrio', $id)->orderBy('nombrecalle' , 'asc')->get();
    }

    public function getCalles()
    {
        return Calle::orderBy('nombrecalle', 'asc')->get();
    }

    public function getBarrios()
    {
        return Barrio::orderBy('nombrebarrio', 'asc')->get();
    }

    public function getCalle()
    {
        return Calle::orderBy('nombrecalle', 'asc')->get();
    }

    public function getLastID()
    {
        $max_canal = Canal::max('idcanal');

        if ($max_canal != null){
            $max_canal += 1;
        } else {
            $max_canal = 1;
        }
        return response()->json(['id' => $max_canal]);
    }


    public function editar_canal(Request $request)
    {
        $canala = $request->input('arr_canales');

        foreach ($canala as $item) {
            $canal1 = Canal::find($item['idcanal']);

            $canal1->nombrecanal = $item['nombrecanal'];

            $canal1->save();
        }
        return response()->json(['success' => true]);
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
        $canal = new Canal();

        $canal->idcalle = $request->input('idcalle');
        $canal->nombrecanal = $request->input('nombrecanal');
        $canal->observacion = $request->input('observacion');
        $canal->fechaingreso = date('Y-m-d');

        $canal->save();

        return response()->json(['success' => true]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $aux =  Derivacion::where ('idcanal',$id)->count('idderivacion');

        if ($aux > 0){
            return response()->json(['success' => false, 'msg' => 'exist_derivacion']);
        } else {
            $canal = Canal::find($id);
            $canal->delete();
            return response()->json(['success' => true]);
        }
    }
}
