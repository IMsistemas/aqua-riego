<?php

namespace App\Http\Controllers\Tarifas;

use App\Modelos\Configuracion\ConfiguracionSystem;
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


    /**
     * Obtener el ultimo ID insertado en la tabla Tarifa
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Obtener el nombre de todas las tarifas
     *
     * @return mixed
     */
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
        return ConfiguracionSystem::where('optionname', 'PISQUE_CONSTANTE')->get();
    }

    /**
     * Obtener el area y caudal de las tarifas en base al anno ingresado
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
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
                    $query->where('aniotarifa', $year)->orderBy('desde', 'asc');
                }
            ,
                'caudal' => function ($query0) use ($year){
                    $query0->where('aniotarifa', $year)->orderBy('desde', 'asc');
                }
            ]
        )
        ->where('idtarifa', $data->idtarifa)
        ->get();
    }

    /**
     * Guardar los cambios en las Subtarifas y las nuevas subtarifas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSubTarifas(Request $request)
    {
        $subtarifas = $request->input('subtarifas');
        $action_edit = false;

        foreach ($subtarifas as $item) {
            if($item['area']['idarea'] == 0) {
                $area = new Area();
                $caudal = new Caudal();
            } else {
                $action_edit = true;
                $area = Area::find($item['area']['idarea']);
                $caudal = Caudal::find($item['caudal']['idcaudal']);
            }

            $area->idtarifa = $item['area']['idtarifa'];
            $area->desde = $item['area']['desde'];
            $area->hasta = $item['area']['hasta'];
            $area->costo = $item['area']['costo'];
            $area->esfija = $item['area']['esfija'];
            $area->observacion = $item['area']['observacion'];

            $caudal->idtarifa = $item['caudal']['idtarifa'];
            $caudal->desde = $item['caudal']['desde'];
            $caudal->hasta = $item['caudal']['hasta'];

            /*if ($action_edit == false) {
                $area->aniotarifa = date('Y');
                $caudal->aniotarifa = date('Y');
            }*/

            $area->aniotarifa = date('Y');
            $caudal->aniotarifa = date('Y');

            $area->save();
            $caudal->save();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Eliminar los datos de area y caudal de la subtarifa seleccionada
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
     * Almacenar la Tarifa creada
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


    public function update(Request $request, $id)
    {
        $tarifa = Tarifa::find($id);
        $tarifa->nombretarifa = $request->input('nombretarifa');
        $tarifa->save();

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {

        $count_area = Area::where('idtarifa', $id)->count();

        $count_caudal = Caudal::where('idtarifa', $id)->count();


        if ($count_area == 0 && $count_caudal == 0) {

            $tarifa = Tarifa::find($id);
            $tarifa->delete();

            return response()->json(['success' => true]);

        } else {

            return response()->json(['success' => false]);

        }



    }


}
