<?php

namespace App\Http\Controllers\Cuentas;

use App\Modelos\Cuentas\CobroAgua;
use App\Modelos\Terreno\Terreno;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CobroAguaController extends Controller
{
    /**
     * Mostrar vista de cobro de agua
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Cuentas.cobroagua');
    }

    /**
     * Verificar si se ha generado cobros en el periodo actual
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyPeriodo()
    {
        $count = CobroAgua::where('fechaperiodo', date('Y'))
                                ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Obtener los cobros generados
     *
     * @return mixed
     */
    public function getCobros()
    {
        return CobroAgua::join('terreno', 'terreno.idterreno', '=', 'cobroagua.idterreno')
                            ->join('cliente', 'terreno.codigocliente', '=', 'cliente.codigocliente')
                            ->join('tarifa', 'terreno.idtarifa', '=', 'tarifa.idtarifa')
                            ->join('barrio', 'terreno.idbarrio', '=', 'barrio.idbarrio')
                            ->join('derivacion', 'terreno.idderivacion', '=', 'derivacion.idderivacion')
                            ->join('toma', 'derivacion.idtoma', '=', 'toma.idtoma')
                            ->join('canal', 'toma.idcanal', '=', 'canal.idcanal')
                            ->orderBy('fechaperiodo', 'desc')
                            ->get();
    }

    /**
     * Obtener el listado de Cobros ordenadas por estado en base a busqueda por filtros
     *
     * @param $filters
     * @return mixed
     */
    public function getByFilters($filters)
    {
        $filter = json_decode($filters);

        $cobro = CobroAgua::join('terreno', 'terreno.idterreno', '=', 'cobroagua.idterreno')
                                ->join('cliente', 'terreno.codigocliente', '=', 'cliente.codigocliente')
                                ->join('tarifa', 'terreno.idtarifa', '=', 'tarifa.idtarifa')
                                ->join('barrio', 'terreno.idbarrio', '=', 'barrio.idbarrio')
                                ->join('derivacion', 'terreno.idderivacion', '=', 'derivacion.idderivacion')
                                ->join('toma', 'derivacion.idtoma', '=', 'toma.idtoma')
                                ->join('canal', 'toma.idcanal', '=', 'canal.idcanal');

        if($filter->text != null){
            $cobro->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
            $cobro->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');
        }

        if($filter->estado != null && $filter->estado != '3'){
            $estado = ($filter->estado == '1') ? true : false;
            $cobro->where('estapagada', $estado);
        }

        return $cobro->orderBy('fechaperiodo', 'desc')
                            ->get();
    }

    /**
     * Generar los cobros
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate()
    {
        $terreno = Terreno::all();

        $result = 0;

        if (count($terreno) > 0){

            foreach ($terreno as $item){
                $cobro = new CobroAgua();

                $cobro->idterreno = $item->idterreno;
                $cobro->fechaperiodo = date('Y');
                $cobro->total = $item->valoranual;
                $cobro->estapagada = false;

                $cobro->save();
            }

            $result = 1;

        } else {
            $result = 2;
        }

        return response()->json(['result' => $result]);
    }


    /**
     * Actualizar estado de pago en el cobro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cobro = CobroAgua::find($id);
        $cobro->estapagada = $request->input('estapagada');
        $cobro->save();
        return response()->json(['success' => true]);
    }


}
