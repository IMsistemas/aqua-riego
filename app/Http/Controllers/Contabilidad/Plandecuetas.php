<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modelos\Contabilidad\Cont_PlanCuenta;

use App\Http\Controllers\Contabilidad\CoreContabilidad;

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
    public function deletecuenta($filtro){
        $filtro = json_decode($filtro);
        $results = DB::select("SELECT count(*) as nivel FROM cont_plancuenta WHERE jerarquia ~ '".$filtro->jerarquia.".*{1}'");
        if($results[0]->nivel=="0"){
            //$cuenta=Cont_PlanCuenta::where("idplancuenta","=",$filtro->idplancuenta)->get();
            $cuenta=Cont_PlanCuenta::find($filtro->idplancuenta);
            $respuesta=$cuenta->delete();
            return "Ok";
        }else{
            return "Error";
        }
    }
    /**
     *
     * Plan cotable total
     *
     */
    public function plancontabletotal(){
        $aux_sqlplan="SELECT * , ";
        $aux_sqlplan.=" (SELECT count(*)  FROM cont_plancuenta aux WHERE aux.jerarquia <@ pl.jerarquia) madreohija ";
        $aux_sqlplan.=" FROM cont_plancuenta pl";
        $aux_sqlplan.=" ORDER BY pl.jerarquia; ";
        $aux_data=DB::select($aux_sqlplan);
        return $aux_data;
    }
    /**
     *
     *
     *
     *
     */
    public function GuardarAsientoContable($transaccion)
    {
        $transaccion = json_decode($transaccion);
        /*$aux=new CoreContabilidad;
        $resp=$aux->SaveAsientoContable($transaccion);*/
        $res=CoreContabilidad::SaveAsientoContable($transaccion);
        return $resp;
    }
}
