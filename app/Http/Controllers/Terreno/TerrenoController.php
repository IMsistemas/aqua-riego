<?php

namespace App\Http\Controllers\Terreno;

use App\Modelos\Configuracion\ConfiguracionSystem;
use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Tomas\Calle;
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
        return Terreno::with('cultivo', 'tarifa', 'cliente.persona', 'derivacion.canal.calle.barrio')
                            ->get();

    }

    public function getByFilter($filter)
    {
        $object_filter = json_decode($filter);

        $terreno = Terreno::with(['cultivo', 'tarifa', 'cliente',
            'derivacion' => function ($query) use ($object_filter){
                $result_derivacion = $query->with([
                    'canal' => function ($query_canal) use ($object_filter) {
                        $result_canal = $query_canal->with([
                            'calle' => function ($query_calle) use ($object_filter) {
                                $result_calle = $query_calle->with([
                                    'barrio' => function ($query_barrio) use ($object_filter) {
                                        if ($object_filter->barrio != 0) {
                                            $query_barrio->where('idbarrio', $object_filter->barrio);
                                        }
                                    }
                                ]);
                                if ($object_filter->calle != 0) {
                                    return $result_calle->where('idcalle', $object_filter->calle);
                                }
                            }
                        ]);
                        if ($object_filter->canal != 0) {
                            return $result_canal->where('idcanal', $object_filter->canal);
                        }
                    }
                ]);
                if ($object_filter->derivacion != 0) {
                    return $result_derivacion->where('idderivacion', $object_filter->derivacion);
                }
            }
        ]);

        if ($object_filter->tarifa != 0){
            $terreno = $terreno->where('idtarifa', $object_filter->tarifa);
        }

        if ($object_filter->year != '' && $object_filter->year != null) {
            $terreno = $terreno->whereRaw('EXTRACT( YEAR FROM fechacreacion) = ' . $object_filter->year);
        }

        return $terreno->get();
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
        return Barrio::orderBy('namebarrio', 'asc')->get();
    }


    /**
     * Obtener los cultivos de la tarifa ordenados ascendentemente
     *
     * @param $idtarifa
     * @return mixed
     */
    public function getCultivos($idtarifa)
    {
        return Cultivo::orderBy('nombrecultivo', 'asc')
                        ->where('idtarifa', $idtarifa)->get();
    }

    /**
     * Obtener los canales ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCanales($idcalle)
    {
        return Canal::where('idcalle', $idcalle)->orderBy('nombrecanal', 'asc')->get();
    }

    /**
     * Obtener las tomas de un canal ordenadas ascendentemente
     *
     * @param $idbarrio
     * @return mixed
     */
    public function getTomas($idbarrio)
    {
        return Calle::where('idbarrio', $idbarrio)->orderBy('namecalle', 'asc')->get();
    }

    /**
     * Obtener las derivaciones de una toma ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getDerivaciones($idcanal)
    {
        return Derivacion::where('idcanal', $idcanal)->orderBy('nombrederivacion', 'asc')->get();
    }


    /**
     * Obtener la constante en los datos de configuracion
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getConstante()
    {
        return ConfiguracionSystem::where('optionname','PISQUE_CONSTANTE')->get();
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
        $configuracion = ConfiguracionSystem::where('optionname','PISQUE_CONSTANTE')->get();

        $costo_area = Area::where('desde', '<', $area_h)
            ->where('hasta', '>=', $area_h)
            ->get();

        if ($costo_area[0]->esfija == true){
            $costo = $costo_area[0]->costo;
        } else {
            $costo = $area_h * $configuracion[0]->optionvalue * $costo_area[0]->costo;
        }

        if ($action_interno == true) {
            return $costo;
        } else {
            return response()->json(['costo' => $costo]);
        }

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

        $url_file = null;

        if ($request->hasFile('file')) {

            $pdf = $request->file('file');
            //$destinationPath = storage_path() . '/app/empleados';
            $destinationPath = public_path() . '/uploads/escrituras';
            $name = rand(0, 9999).'_'.$pdf->getClientOriginalName();
            if(!$pdf->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                // $url_file = '/app/empleados/' . $name;
                $url_file = 'uploads/escrituras/' . $name;
            }

        }

        $terreno = Terreno::find($id);

        //$terreno->idbarrio = $request->input('idbarrio');
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->idderivacion = $request->input('idderivacion');

        $terreno->area = $request->input('area');
        $terreno->caudal = $request->input('caudal');

        //$costo = $this->calculateValor($request->input('area'), true);

        $terreno->valoranual = $request->input('valoranual');

        if ($url_file != null) {
            $terreno->urlescrituras = $url_file;
        }

        $terreno->save();

        return response()->json(['success' => true]);
    }


}
