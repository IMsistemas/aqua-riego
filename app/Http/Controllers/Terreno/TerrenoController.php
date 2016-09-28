<?php

namespace App\Http\Controllers\Terreno;

use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Tomas\Derivacion;
use App\Modelos\Tomas\Toma;
use App\Modelos\Tarifas\Area;
use App\Modelos\Tarifas\Tarifa;
use App\Modelos\Terreno\Cultivo;
use App\Modelos\Terreno\Terreno;
use App\Modelos\Tomas\Canal;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TerrenoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Terreno.terreno');
    }


    public function getTerrenos()
    {
        /*return Terreno::join('cultivo', 'terreno.idcultivo', '=', 'cultivo.idcultivo')
                        ->join('tarifa', 'terreno.idtarifa', '=', 'tarifa.idtarifa')
                        ->join('cliente', 'terreno.codigocliente', '=', 'cliente.codigocliente')
                        ->join('derivacion', 'terreno.idderivacion', '=', 'derivacion.idderivacion')
                        ->join('barrio', 'terreno.idbarrio', '=', 'barrio.idbarrio')
                        ->get();*/

        return Terreno::with('cultivo', 'tarifa', 'cliente', 'derivacion.toma.canal', 'barrio')
                            ->get();

    }

    /**
     * Obtener las tarifas ordenadas ascendentemente
     *
     * @return mixed
     */
    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    /**
     * Obtener los barrios ordenados ascendentemente
     *
     * @return mixed
     */
    public function getBarrios()
    {
        return Barrio::orderBy('nombrebarrio', 'asc')->get();
    }

    /**
     * Obtener los cultivos ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCultivos()
    {
        return Cultivo::orderBy('nombrecultivo', 'asc')->get();
    }

    /**
     * Obtener los canales ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCanales()
    {
        return Canal::orderBy('descripcioncanal', 'asc')->get();
    }

    /**
     * Obtener las tomas de un canal ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getTomas($idcanal)
    {
        return Toma::where('idcanal', $idcanal)->orderBy('descripciontoma', 'asc')->get();
    }

    /**
     * Obtener las derivaciones de una toma ordenadas ascendentemente
     *
     * @param $idtoma
     * @return mixed
     */
    public function getDerivaciones($idtoma)
    {
        return Derivacion::where('idtoma', $idtoma)->orderBy('descripcionderivacion', 'asc')->get();
    }


    /**
     * Obtener la constante en los datos de configuracion
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getConstante()
    {
        return Configuracion::all();
    }


    /**
     * Obtener el resultado de calculo del costo en base al area
     *
     * @param $area
     * @param $action_interno
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateValor($area, $action_interno = false)
    {
        $area_h = $area / 10000;
        $configuracion = Configuracion::all();

        $costo_area = Area::where('desde', '<', $area_h)
            ->where('hasta', '>=', $area_h)
            ->get();

        if ($costo_area[0]->esfija == true){
            $costo = $costo_area[0]->costo;
        } else {
            $costo = $area_h * $configuracion[0]->constante * $costo_area[0]->costo;
        }

        if ($action_interno == true) {
            return $costo;
        } else {
            return response()->json(['costo' => $costo]);
        }

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
        $terreno = Terreno::find($id);

        $terreno->idbarrio = $request->input('idbarrio');
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->idderivacion = $request->input('idderivacion');

        $terreno->area = $request->input('area');
        $terreno->caudal = $request->input('caudal');

        $costo = $this->calculateValor($request->input('area'), true);

        $terreno->valoranual = $costo;

        $terreno->save();

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