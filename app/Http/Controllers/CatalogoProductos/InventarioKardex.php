<?php

namespace App\Http\Controllers\CatalogoProductos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modelos\Contabilidad\Cont_Bodega;
use App\Modelos\Contabilidad\Cont_Categoria;

use Carbon\Carbon;
use DateTime;
use DB;


class InventarioKardex extends Controller
{

	/**
     * Carga la vista
     *
     * 
     */
    public function index()
    {   
        return view('catalogoproductos/InvearioKardex');
    }
    /**
     *
     * Cargar todoas la bodegas
     *
     */
    public function cargarbodegas()
    {
    	return Cont_Bodega::all();
    }
    /**
     *
     * Cargar categorias nivel 1
     *
     */
    public function cargarcategoria()
    {
    	return Cont_Categoria::whereRaw(" jerarquia  ~ '*{1}' ")
    							->orderBy('jerarquia', 'asc')
    							->get();
    	;	
    }
    /**
     *
     * Cargar categorias nivel 2
     *
     */
    public function cargarsubcategoria($id)
    {
    	$aux_nivel1=Cont_Categoria::find($id);
    	return Cont_Categoria::whereRaw("jerarquia <@ '".$aux_nivel1->jerarquia."' AND  idcategoria!=$id ")
    							->orderBy('jerarquia', 'asc')
    							->get();			
    }
}