<?php

namespace App\Http\Controllers\Tarifas;

use App\Modelos\Tarifas\Tarifa;
use App\Modelos\Terreno\Cultivo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CultivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tarifas.index_cultivo');
    }

    /**
     * Obtener todos los cargos de manera ascendente
     *
     * @return mixed
     */
    public function getCultivos(Request $request)
    {
        $filter = json_decode($request->get('filter'));
        $search = $filter->search;
        $cargo = null;

        if ($search != null) {
            $cargo = Cultivo::with('tarifa')->whereRaw("cultivo.nombrecultivo ILIKE '%" . $search . "%'")
                ->orderBy('nombrecultivo', 'asc');
        } else {
            $cargo = Cultivo::with('tarifa')->orderBy('nombrecultivo', 'asc');
        }

        return $cargo->paginate(10);
    }

    /**
     * Obtener todos los tarifas
     *
     * @return mixed
     */
    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCultivosByID($id)
    {
        return Cultivo::where('idcultivo', $id)->get();
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
        $cargo1 = Cultivo::where('nombrecultivo', $request->input('nombrecultivo'))->count();

        if ($cargo1 > 0) {
            return response()->json(['success' => false]);
        } else {
            $cargo = new Cultivo();
            $cargo->nombrecultivo = $request->input('nombrecultivo');
            $cargo->idtarifa = $request->input('idtarifa');

            if ($cargo->save()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
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
        $cargo = Cultivo::find($id);
        return response()->json($cargo);
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
        $cargo = Cultivo::find($id);

        $cargo->nombrecultivo = $request->input('nombrecultivo');
        $cargo->idtarifa = $request->input('idtarifa');

        if ($cargo->save()) {
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
        $cargo = Cultivo::find($id);
        $cargo->delete();
        return response()->json(['success' => true]);
    }
}
