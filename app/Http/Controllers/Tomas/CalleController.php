<?php

namespace App\Http\Controllers\Tomas;

use App\Modelos\Sectores\Barrio;
use App\Modelos\Tomas\Calle;
use App\Modelos\Tomas\Canal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tomas/calle');
    }

    public function getCalles()
    {
        return Calle::orderBy('namecalle', 'asc')->get();
    }

    public function getCalle()
    {
        return Calle::orderBy('namecalle', 'asc')->get();
    }

    public function getCallesById($id){
        return Calle::with('canal')->where('idbarrio', $id)->orderBy('namecalle')->get();
    }

    public function getCalleByBarrio($id){
        return Calle::where('idbarrio', $id)->orderBy('namecalle')->get();
    }


    public function getBarrios()
    {
        return Barrio::orderBy('namebarrio', 'asc')->get();
    }


    public function getLastID()
    {
        $max_calle = Calle::max('idcalle');

        if ($max_calle != null){
            $max_calle += 1;
        } else {
            $max_calle = 1;
        }
        return response()->json(['id' => $max_calle]);
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
        $calle = new Calle();

        $calle->idbarrio = $request->input('idbarrio');
        $calle->namecalle = $request->input('nombrecalle');
        $calle->observacion = $request->input('observacion');
        $calle->fechaingreso = date('Y-m-d');

        $calle->save();

        return response()->json(['success' => true]);

    }


    public function editar_calle(Request $request)
    {
        $callea = $request->input('arr_calle');

        foreach ($callea as $item) {
            $calle1 = Calle::find($item['idcalle']);

            $calle1->namecalle = $item['namecalle'];

            $calle1->save();
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
       /* $calle = Calle::find($id);
        $calle->delete();
        return response()->json(['success' => true]);*/

        $calle = Calle::find($id);
        $calle->delete();
        return response()->json(['success' => true]);
    }

}
