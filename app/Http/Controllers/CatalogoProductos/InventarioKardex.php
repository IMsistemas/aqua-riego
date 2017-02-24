<?php

namespace App\Http\Controllers\CatalogoProductos;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


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
}