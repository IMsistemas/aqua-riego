<?php

namespace App\Http\Controllers\Cuentas;

use App\Modelos\Cuentas\CobroAgua;
use App\Modelos\Cuentas\Descuento;
use App\Modelos\Cuentas\Recargo;
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
        $count = CobroAgua::where('aniocobro', date('Y'))
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
                            ->join('derivacion', 'terreno.idderivacion', '=', 'derivacion.idderivacion')
                            ->join('canal', 'derivacion.idcanal', '=', 'canal.idcanal')
                            ->join('calle', 'canal.idcalle', '=', 'calle.idcalle')
                            ->join('barrio', 'calle.idbarrio', '=', 'barrio.idbarrio')
                            ->orderBy('aniocobro', 'desc')
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
                            ->join('derivacion', 'terreno.idderivacion', '=', 'derivacion.idderivacion')
                            ->join('canal', 'derivacion.idcanal', '=', 'canal.idcanal')
                            ->join('calle', 'canal.idcalle', '=', 'calle.idcalle')
                            ->join('barrio', 'calle.idbarrio', '=', 'barrio.idbarrio');

        if($filter->estado != null && $filter->estado != '3'){
            $estado = ($filter->estado == '1') ? true : false;
            $cobro->where('estapagada', $estado);
        }

        return $cobro->orderBy('aniocobro', 'desc')->get();
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
                $cobro->aniocobro = date('Y');

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

        $descuento_recargo_exists = false;

        $descuento = Descuento::where('year', date('Y'))
                                ->where('mes', date('n'))
                                ->get();

        if(count($descuento) > 0) {
            /*$valorconsumo = $cobro->valorconsumo;
            $total = ($valorconsumo * $descuento[0]->porcentaje) / 100;

            $cobro->iddescuento = $descuento[0]->iddescuento;
            $cobro->valorconsumo = round($total, 2);
            $cobro->total = round($total + $cobro->valoratrasados, 2);*/

            $total = ($cobro->total * $descuento[0]->porcentage) / 100;

            $cobro->total = round($total, 2);

            $cobro->iddescuento = $descuento[0]->iddescuento;

            $descuento_recargo_exists = true;

        } else {
            $recargo = Recargo::where('year', date('Y'))
                                    ->where('mes', date('n'))
                                    ->get();

            /*$valorconsumo = $cobro->valorconsumo;
            $total = ($valorconsumo * $recargo[0]->porcentaje) / 100;

            $cobro->iddescuento = $recargo[0]->iddescuento;
            $cobro->valorconsumo = round($total, 2);
            $cobro->total = round($total + $cobro->valoratrasados, 2);

            $cobro->idrecargo = $recargo[0]->idrecargo;*/


            if (count($recargo) > 0) {
                $total = ($cobro->total * $recargo[0]->porcentage) / 100;

                $cobro->total = round($total, 2);

                $cobro->idrecargo = $recargo[0]->idrecargo;

                $descuento_recargo_exists = true;
            }


        }

        $cobro->fechapago = date('Y-m-d');
        $cobro->estapagada = $request->input('estapagada');

        if ($descuento_recargo_exists == true){
            $cobro->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'descuento_recargo_exists' => false]);
        }

    }

    /**
     * Obtener de existir los valores de atraso, en caso de no existir, 0
     *
     * @param $idterreno
     * @return array|int
     */
    private function searchAtraso($idterreno)
    {
        $cobro = CobroAgua::where('aniocobro', (date('Y') - 1))
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
