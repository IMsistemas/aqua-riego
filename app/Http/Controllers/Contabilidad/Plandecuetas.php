<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modelos\Contabilidad\Cont_PlanCuenta;


use Carbon\Carbon;
use DateTime;
use DB;


class Plandecuetas extends Controller
{
    /**
     * Carga la vista
     *
     * 
     */
    public function index()
    {
        return view('Estadosfinancieros/PlandeCuentasContables');
        //return view('Estadosfinancieros/aux_PlandeCuentasContables');
    }
    public function getplancuentasportipo($filtro)
    {
        $filtro = json_decode($filtro);
        return Cont_PlanCuenta::where("tipoestadofinanz","=",$filtro->Tipo)
                ->orderBy('jerarquia', 'ASC')
                ->get();
    }
    public function store(Request $request)
    {
        $datos = $request->all();
        $aux_respuesta="";
        if($datos["jerarquia"]=="100000"){// creando cuenta madre
            $aux_cuentacm = Cont_PlanCuenta::create($datos);
            $datos["jerarquia"]=$aux_cuentacm->idplancuenta."";
            $aux_cuentacm1= Cont_PlanCuenta::where("idplancuenta","=",$aux_cuentacm->idplancuenta)
                            ->update($datos);
            $aux_respuesta=$aux_cuentacm1;
        }else{//creando cuenta nodo o hija
            //Buscar nodo siguiente
            /*$results= Cont_PlanCuenta::select("(count(*)+1) ")
                                    ->whereRaw("cont_plancuenta.jerarquia <@ '".$aux_cuentamadre."' AND cont_plancuenta.jerarquia!='".$aux_cuentamadre."'");*/
            $aux_cuentamadre=$datos["jerarquia"];
            //$results = DB::select("SELECT (count(*)+1) as nivel FROM cont_plancuenta WHERE jerarquia <@ '$aux_cuentamadre' AND jerarquia!='$aux_cuentamadre';");
            $results = DB::select("SELECT (count(*)+1) as nivel FROM cont_plancuenta WHERE jerarquia ~ '$aux_cuentamadre.*{1}'");
            $datos["jerarquia"]=$datos["jerarquia"].".".$results[0]->nivel;
            $aux_cuentanodo = Cont_PlanCuenta::create($datos);
            $aux_respuesta= $aux_cuentanodo;  
        }
        return $aux_respuesta;
    }
    public function update(Request $request, $id){
        $datos = $request->all();
        $aux_respuesta=Cont_PlanCuenta::where("idplancuenta","=",$id)
                        ->update($datos);
        return $aux_respuesta;
    }
}
