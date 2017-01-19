<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Modelos\Contabilidad\Cont_PlanCuenta;

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
    /**
     * Obtener plan de cuentas por tipo
     *
     * 
     */
    public function getplancuentasportipo($filtro)
    {
        $filtro = json_decode($filtro);
        return Cont_PlanCuenta::where("tipoestadofinanz","=",$filtro->Tipo)
                ->orderBy('jerarquia', 'ASC')
                ->get();
    }
}
