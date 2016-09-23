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

        if (count($terreno) > 0){

            foreach ($terreno as $item){
                $cobro = new CobroAgua();

                $atraso = $this->searchAtraso($item->idterreno);

                $cobro->idterreno = $item->idterreno;
                $cobro->fechaperiodo = date('Y');

                if ($atraso == 0){
                    $cobro->valoratrasados = 0;
                    $cobro->aniosatrasados = 0;
                } else {
                    $cobro->valoratrasados = $atraso['valoratrasados'];
                    $cobro->aniosatrasados = $atraso['aniosatrasados'];
                }

                $cobro->valorconsumo = $item->valoranual;

                $cobro->total = $item->valoranual + $cobro->valoratrasados;
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

    /**
     * Obtener de existir los valores de atraso, en caso de no existir, 0
     *
     * @param $idterreno
     * @return array|int
     */
    private function searchAtraso($idterreno)
    {
        $cobro = CobroAgua::where('fechaperiodo', (date('Y') - 1))
                            ->where('idterreno', $idterreno)
                            ->get();

        if (count($cobro) == 0){
            return 0;
        } else {
            if ($cobro[0]->estapagada == false) {
                return ['valoratrasados' => $cobro[0]->total, 'aniosatrasados' => $cobro[0]->aniosatrasados + 1];
            } else {
                return 0;
            }
        }
    }

}