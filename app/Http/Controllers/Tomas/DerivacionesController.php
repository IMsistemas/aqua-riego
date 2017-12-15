<?php

namespace App\Http\Controllers\Tomas;

use App\Modelos\Sectores\Barrio;
use App\Modelos\Terreno\Terreno;
use App\Modelos\Tomas\Calle;
use App\Modelos\Tomas\Canal;
use App\Modelos\Tomas\Derivacion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DerivacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tomas/derivaciones');
    }

    public function getDerivaciones()
    {
        return Derivacion::orderBy('nombrederivacion', 'asc')->get();
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

        $deri = new Derivacion();

        $deri->nombrederivacion = $request->input('nombrederivacion');
        $deri->observacion = $request->input('observacion');
        $deri->fechaingreso = date('Y-m-d');

        if ($deri->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

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
        $deri = Derivacion::find($id);

        $deri->nombrederivacion = $request->input('nombrederivacion');
        $deri->observacion = $request->input('observacion');

        if ($deri->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aux =  Terreno::where ('idderivacion',$id)->count();

        if ($aux > 0){

            return response()->json(['success' => false, 'msg' => 'exist_derivacion']);

        } else {

            $derivacion = Derivacion::find($id);

            if ($derivacion->delete()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }

        }
    }
}
