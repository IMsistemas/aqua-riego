<?php

namespace App\Http\Controllers\ConfiguracionSystem;

use App\Modelos\Configuracion\ConfiguracionSystem;
use App\Modelos\Contabilidad\Cont_PlanCuenta;
use App\Modelos\SRI\SRI_Establecimiento;
use Illuminate\Http\Request;
use App\Modelos\SRI\SRI_TipoImpuestoIva;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfiguracionSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ConfiguracionSystem.index');
    }


    public function getDataEmpresa()
    {
        return SRI_Establecimiento::get();
    }

    public function getConfigurations()
    {
        return ConfiguracionSystem::get();
    }

    public function getIVADefault()
    {
        return ConfiguracionSystem::where('optionname', 'SRI_IVA_DEFAULT')->get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url_file = null;

        if ($request->hasFile('rutalogo')) {
            $image = $request->file('rutalogo');
            $destinationPath = public_path() . '/uploads/configuracion';
            $name = rand(0, 9999) . '_' . $image->getClientOriginalName();
            if (!$image->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                $url_file = '/uploads/configuracion/' . $name;
            }
        }

        $configuracion = new SRI_Establecimiento();

        $configuracion->ruc = $request->input('ruc');
        $configuracion->razonsocial = $request->input('razonsocial');
        $configuracion->nombrecomercial = $request->input('nombrecomercial');
        $configuracion->direccionestablecimiento = $request->input('direccionestablecimiento');
        $configuracion->rutalogo = $request->input('rutalogo');

        if ($request->input('contribuyenteespecial') == '') {
            $configuracion->contribuyenteespecial = null;
        } else {
            $configuracion->contribuyenteespecial = $request->input('contribuyenteespecial');
        }

        if ($request->input('obligadocontabilidad') == '1') {
            $configuracion->obligadocontabilidad = true;
        } else {
            $configuracion->obligadocontabilidad = false;
        }

        if ($url_file != null) {
            $configuracion->rutalogo = $url_file;
        }

        if ($configuracion->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateEstablecimiento(Request $request, $id)
    {

        $url_file = null;

        if ($request->hasFile('rutalogo')) {
            $image = $request->file('rutalogo');
            $destinationPath = public_path() . '/uploads/configuracion';
            $name = rand(0, 9999) . '_' . $image->getClientOriginalName();
            if (!$image->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                $url_file = '/uploads/configuracion/' . $name;
            }
        }

        $configuracion = SRI_Establecimiento::find($id);

        $configuracion->ruc = $request->input('ruc');
        $configuracion->razonsocial = $request->input('razonsocial');
        $configuracion->nombrecomercial = $request->input('nombrecomercial');
        $configuracion->direccionestablecimiento = $request->input('direccionestablecimiento');
        $configuracion->rutalogo = $request->input('rutalogo');

        if ($request->input('contribuyenteespecial') == '') {
            $configuracion->contribuyenteespecial = null;
        } else {
            $configuracion->contribuyenteespecial = $request->input('contribuyenteespecial');
        }

        if ($request->input('obligadocontabilidad') == '1') {
            $configuracion->obligadocontabilidad = true;
        } else {
            $configuracion->obligadocontabilidad = false;
        }

        if ($url_file != null) {
            $configuracion->rutalogo = $url_file;
        }

        if ($configuracion->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    /**
     * Obtener los valores para seleccionar configuración
     */


    public function getImpuestoIVA()
    {
        return SRI_TipoImpuestoIva::orderBy('nametipoimpuestoiva', 'asc')->get();
    }

    public function getPlanCuenta()
    {
        return Cont_PlanCuenta::orderBy('jerarquia', 'asc')->get();
    }



    public function updateIvaDefault(Request $request, $id)
    {

        $configuracion = ConfiguracionSystem::find($id);

        $configuracion->optionname = $request->input('optionname');
        $configuracion->optionvalue = $request->input('optionvalue');


        if ($configuracion->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    public function getConfigCompra()
    {
        return ConfiguracionSystem::where('optionname','CONT_IRBPNR_COMPRA'
            OR 'optionname','CONT_PROPINA_COMPRA'
            OR 'optionname','SRI_RETEN_IVA_COMPRA'
            OR 'optionname','SRI_RETEN_RENTA_COMPRA')->get();

    }

    public function getConfigVenta()
    {
        return ConfiguracionSystem::where('optionname','CONT_IRBPNR_VENTA'
            OR 'optionname','CONT_PROPINA_VENTA'
            OR 'optionname','SRI_RETEN_IVA_VENTA'
            OR 'optionname','SRI_RETEN_RENTA_VENTA'
            OR 'optionname','CONT_COSTO_VENTA')->get();

    }

    public function getConfigNC()
    {
        return ConfiguracionSystem::where('optionname','CONT_IRBPNR_NC'
            OR 'optionname','CONT_PROPINA_NC'
            OR 'optionname','SRI_RETEN_IVA_NC'
            OR 'optionname','SRI_RETEN_RENTA_NC')->get();

    }

    public function getConfigSRI()
    {
        return ConfiguracionSystem::where('optionname','SRI_TIPO_AMBIENTE'
            OR 'optionname','SRI_TIPO_EMISION')->get();

    }

    public function getConfigPisque()
    {
        return ConfiguracionSystem::where('optionname','PISQUE_CONSTANTE')->get();

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}



