<?php

namespace App\Http\Controllers\Tarifas;

use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Tarifas\Area;
use App\Modelos\Tarifas\Caudal;
use App\Modelos\Tarifas\Tarifa;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TarifaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Tarifas.index');
    }


    public function getLastID()
    {
        $max_tarifa = Tarifa::max('idtarifa');

        if ($max_tarifa != null){
            $max_tarifa += 1;
        } else {
            $max_tarifa = 1;
        }

        return response()->json(['id' => $max_tarifa]);
    }


    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
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


    public function getAreaCaudal($idtarifa)
    {
        /*return Tarifa::join('area', 'area.idtarifa', '=', 'tarifa.idtarifa')
                        ->join('caudal', 'caudal.idtarifa', '=', 'tarifa.idtarifa')
                        ->where('tarifa.aniotarifa', date('Y'))
                        ->where('tarifa.idtarifa', $idtarifa)
                        ->get();*/

        /*$tarifa = Tarifa::with(['area' => function($query) use ($idtarifa) {
            $query->where('aniotarifa', 2016)
                ->where('idtarifa', $idtarifa);
        }]);*/

        return Tarifa::with('area', 'caudal')
                            ->where('idtarifa', $idtarifa)
                            ->where('aniotarifa', date('Y'))
                            ->get();

    }


    public function saveSubTarifas(Request $request)
    {
        $subtarifas = $request->input('subtarifas');

        foreach ($subtarifas as $item) {
            if($item['area']['idarea'] == 0) {
                $area = new Area();
                $caudal = new Caudal();
            } else {
                $area = Area::find($item['area']['idarea']);
                $caudal = Caudal::find($item['caudal']['idcaudal']);
            }

            $area->idtarifa = $item['area']['idtarifa'];
            $area->desde = $item['area']['desde'];
            $area->hasta = $item['area']['hasta'];
            $area->costo = $item['area']['costo'];
            $area->esfija = $item['area']['esfija'];
            $area->aniotarifa = date('Y');
            $area->observacion = $item['area']['observacion'];
            $area->save();

            $caudal->idtarifa = $item['caudal']['idtarifa'];
            $caudal->desde = $item['caudal']['desde'];
            $caudal->hasta = $item['caudal']['hasta'];
            $caudal->aniotarifa = date('Y');
            $caudal->save();
        }

        return response()->json(['success' => true]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tarifa = new Tarifa();

        $tarifa->nombretarifa = $request->input('nombretarifa');

        $year = date('Y');
        $tarifa->aniotarifa = $year;
        $tarifa->save();

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
        //
    }
}
