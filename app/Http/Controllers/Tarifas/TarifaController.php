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


    public function getAreaCaudal($data)
    {

        $data = json_decode($data);

        if($data->year != '' && $data->year != 0 && $data->year != '0' ){
            $year = $data->year;
        } else {
            $year = date('Y');
        }

        return Tarifa::with(
            [
                'area' => function ($query) use ($year){
                    $query->where('aniotarifa', $year);
                }
            ,
                'caudal' => function ($query0) use ($year){
                    $query0->where('aniotarifa', $year);
                }
            ]
        )
        ->where('idtarifa', $data->idtarifa)
            //->orderBy('idarea', 'asc')
            ->get();






        /*return Tarifa::with('area', 'caudal')
            ->where('idtarifa', $data->idtarifa)
            ->where('aniotarifa', $year)
            ->get();*/

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

    public function deleteSubTarifas(Request $request)
    {
        $area = Area::find($request->input('idarea'));
        $area->delete();

        $caudal = Caudal::find($request->input('idcaudal'));
        $caudal->delete();

        return response()->json(['success' => true]);
    }

    public function generate()
    {
        $tarifas = Tarifa::orderBy('idtarifa', 'asc')->get();

        if (count($tarifas) > 0){

            foreach ($tarifas as $item) {

                $area_search = Area::where('idtarifa', $item['idtarifa'])
                                ->where('aniotarifa', date('Y'))
                                ->get();

                if (count($area_search) == 0){
                    $area = Area::where('idtarifa', $item['idtarifa'])
                                    ->where('aniotarifa', date('Y') - 1)
                                    ->get();

                    if (count($area) > 0){
                        foreach ($area as $item_area) {
                            $newArea = new Area();
                            $newArea->idtarifa = $item_area['idtarifa'];
                            $newArea->desde = $item_area['desde'];
                            $newArea->hasta = $item_area['hasta'];
                            $newArea->costo = $item_area['costo'];
                            $newArea->esfija = $item_area['esfija'];
                            $newArea->observacion = $item_area['observacion'];
                            $newArea->aniotarifa = date('Y');
                            $newArea->save();
                        }
                    }

                    $caudal = Caudal::where('idtarifa', $item['idtarifa'])
                                        ->where('aniotarifa', date('Y') - 1)
                                        ->get();

                    if (count($caudal) > 0){
                        foreach ($caudal as $item_caudal) {
                            $newCaudal = new Caudal();
                            $newCaudal->idtarifa = $item_caudal['idtarifa'];
                            $newCaudal->desde = $item_caudal['desde'];
                            $newCaudal->hasta = $item_caudal['hasta'];
                            $newCaudal->aniotarifa = date('Y');
                            $newCaudal->save();
                        }
                    }
                }

            }

            return response()->json(['success' => true]);

        } else {
            return response()->json(['success' => false, 'msg' => 'no_exists_tarifa']);
        }
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
