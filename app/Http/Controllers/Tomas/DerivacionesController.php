<?php

namespace App\Http\Controllers\Tomas;

use App\Modelos\Sectores\Barrio;
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

    public function getDerivacionesByBarrio1($id)
    {
        return Calle::with('canal.derivacion')->where('idbarrio', $id)->orderBy('nombrecalle')->get();
    }

    public function getDerivacionesById($id){
        return Derivacion::where('idcanal', $id)->orderBy('nombrederivacion')->get();
    }



    public function getDerivacionesByBarrio($id){

       return $calle = Calle::with('canal') ->where('idbarrio', $id)->orderBy('nombrecalle')->get();
    }


    public function getCanales()
    {
        return Canal::orderBy('nombrecanal', 'asc')->get();
    }

    public function getCanaless()
    {
        return Canal::orderBy('nombrecanal', 'asc')->get();
    }

    public function getCalles()
    {
        return Calle::orderBy('nombrecalle', 'asc')->get();
    }

    public function getBarrios()
    {
        return Barrio::orderBy('nombrebarrio', 'asc')->get();
    }


    public function getLastID()
    {
        $max_derivacion = Derivacion::max('idderivacion');

        if ($max_derivacion != null){
            $max_derivacion += 1;
        } else {
            $max_derivacion = 1;
        }
        return response()->json(['id' => $max_derivacion]);
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
        $deri->idcanal = $request->input('idcanal');
        $deri->fechaingreso = date('Y-m-d');

        $deri->save();

        return response()->json(['success' => true]);
    }

    public function editar_derivaciones(Request $request)
    {
        $deriv = $request->input('arr_deriva');

        foreach ($deriv as $item) {
            $deriv1 = Derivacion::find($item['idderivacion']);

            $deriv1->nombrederivacion = $item['nombrederivacion'];

            $deriv1->save();
        }
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
        $deriva = Derivacion::find($id);
        $deriva->delete();
        return response()->json(['success' => true]);
    }
}
