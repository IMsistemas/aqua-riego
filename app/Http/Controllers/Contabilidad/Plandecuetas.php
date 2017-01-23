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
        }
        return $aux_respuesta;
    }
}
