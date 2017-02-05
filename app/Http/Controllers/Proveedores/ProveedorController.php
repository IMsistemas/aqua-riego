<?php

namespace App\Http\Controllers\Proveedores;

use App\Modelos\Proveedores\Proveedor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Proveedor.index_proveedor');
    }


    public function getProveedores(Request $request)
    {

        $filter = json_decode($request->get('filter'));
        $search = $filter->search;
        $employee = null;

        $proveedor = Proveedor::join('persona', 'persona.idpersona', '=', 'proveedor.idpersona')
                        ->join('cont_plancuenta', 'cont_plancuenta.idplancuenta', '=', 'proveedor.idplancuenta')
                        ->select('proveedor.*', 'persona.*', 'cont_plancuenta.*');

        if ($search != null) {
            $proveedor = $proveedor->whereRaw("persona.razonsocial LIKE '%" . $search . "%'");
        }

        return $proveedor->orderBy('fechaingreso', 'desc')->paginate(10);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
