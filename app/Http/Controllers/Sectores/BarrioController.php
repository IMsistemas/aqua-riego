<?php

namespace App\Http\Controllers\Sectores;

use App\Modelos\Sectores\Barrio;
use App\Modelos\Sectores\Parroquia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BarrioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Sectores/index_barrio');
    }


    public function getBarrios()
    {
        //return Barrio::orderBy('nombrebarrio', 'asc')->get();
        return Barrio::with('calle')->orderBy('nombrebarrio', 'asc')->get();
    }

    public function getLastID()
    {
        $max_barrio = Barrio::max('idbarrio');

        if ($max_barrio != null){
            $max_barrio += 1;
        } else {
            $max_barrio = 1;
        }

        return response()->json(['id' => $max_barrio]);
    }


    public function getParroquias()
    {
        return Parroquia::orderBy('nombreparroquia', 'asc')->get();
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
        $barrio = new Barrio();

        $barrio->idparroquia = $request->input('idparroquia');
        $barrio->nombrebarrio = $request->input('nombrebarrio');
        $barrio->observacion = $request->input('observacion');
        $barrio->fechaingreso = date('Y-m-d');

        $barrio->save();

        return response()->json(['success' => true]);
    }

    public function editar_barrio(Request $request)
    {
        $barrioa = $request->input('arr_barrio');

        foreach (barrioa as $item) {
            $barri = Barrio::find($item['idbarrio']);

            $barri->nombrebarrio = $item['nombrebarrio'];

            $barri->save();
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
        $barrio = Barrio::find($id);
        $barrio->delete();
        return response()->json(['success' => true]);
    }
}
