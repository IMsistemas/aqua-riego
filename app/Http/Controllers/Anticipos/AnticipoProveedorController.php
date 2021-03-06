<?php

namespace App\Http\Controllers\Anticipos;

use App\Http\Controllers\Contabilidad\CoreContabilidad;
use App\Modelos\Contabilidad\Cont_AnticipoProveedor;
use App\Modelos\Contabilidad\Cont_RegistroProveedor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnticipoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Anticipos/index_proveedor');
    }

    public function getAnticipos()
    {
        return Cont_AnticipoProveedor::join('proveedor', 'proveedor.idproveedor', '=', 'cont_anticipoproveedor.idproveedor')
                                ->join('persona', 'proveedor.idpersona', '=', 'persona.idpersona')
                                ->join('cont_plancuenta', 'cont_plancuenta.idplancuenta', '=', 'cont_anticipoproveedor.idplancuenta')
                                ->join('cont_formapago', 'cont_formapago.idformapago', '=', 'cont_anticipoproveedor.idformapago')
                                ->where('cont_anticipoproveedor.estado', true)
                                ->orderBy('fecha', 'desc')
                                ->selectRaw('cont_anticipoproveedor.*, persona.razonsocial, cont_plancuenta.concepto, cont_formapago.nameformapago')->paginate(10);
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

        /*
         * ----------------------------------------CONTABILIDAD-------------------------------------------------------
         */

        $filtro = json_decode($request->input('contabilidad'));

        //--Parte contable
        $id_transaccion = CoreContabilidad::SaveAsientoContable( $filtro->DataContabilidad);
        //--Fin parte contable

        $registro = [
            'idproveedor' => $request->input('idproveedor'),
            'idtransaccion' => $id_transaccion,
            'fecha' => date('Y-m-d'),
            'debe' => 0,
            'haber' => $filtro->DataContabilidad->registro[0]->Debe,
            'numerodocumento' => "",
            'estadoanulado' => false
        ];

        $aux_registro  = Cont_RegistroProveedor::create($registro);

        /*
         * ----------------------------------------CONTABILIDAD-------------------------------------------------------
         */

        $anticipo = new Cont_AnticipoProveedor();

        $anticipo->idproveedor = $request->input('idproveedor');
        $anticipo->idformapago = $request->input('idformapago');
        $anticipo->idplancuenta = $request->input('idplancuenta');
        $anticipo->idtransaccion = $id_transaccion;
        $anticipo->fecha = $request->input('fecha');
        $anticipo->monto = $request->input('monto');
        $anticipo->observacion = $request->input('observacion');
        $anticipo->estado = true;

        if ($anticipo->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }


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

        $anticipo = Cont_AnticipoProveedor::find($id);
        $anticipo->estado =  false;

        if ($anticipo->save()) {

            CoreContabilidad::AnularAsientoContable($anticipo->idtransaccion);

            return response()->json(['success' => true]);

        } else {

            return response()->json(['success' => false]);

        }

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
