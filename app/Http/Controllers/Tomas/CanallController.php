<?php

namespace App\Http\Controllers\Tomas;

use App\Modelos\Terreno\Terreno;
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


    public function getCanall()
    {
        return Canal::orderBy('nombrecanal', 'asc')->get();
    }

    public function getCanal()
    {
        return Canal::orderBy('nombrecanal', 'asc')->get();
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

        $canal->nombrecanal = $request->input('nombrecanal');
        $canal->observacion = $request->input('observacion');
        $canal->fechaingreso = date('Y-m-d');

        if ($canal->save()) {
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
        $canal = Canal::find($id);

        $canal->nombrecanal = $request->input('nombrecanal');
        $canal->observacion = $request->input('observacion');
        $canal->fechaingreso = date('Y-m-d');

        if ($canal->save()) {
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
        $aux =  Terreno::where ('idcanal',$id)->count();

        if ($aux > 0){

            return response()->json(['success' => false, 'msg' => 'exist_derivacion']);

        } else {

            $canal = Canal::find($id);

            if ($canal->delete()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }

        }
    }
}
