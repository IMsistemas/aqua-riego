<?php

namespace App\Http\Controllers\ConfiguracionSystem;

use App\Modelos\SRI\SRI_Establecimiento;
use Illuminate\Http\Request;

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
        $url_file = null;

        if ($request->hasFile('rutalogo')) {
            $image = $request->file('rutalogo');
            $destinationPath = public_path() . '/uploads/configuracion';
            $name = rand(0, 9999) . '_' . $image->getClientOriginalName();
            if(!$image->move($destinationPath, $name)) {
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
    public function updateEstablecimiento(Request $request, $id)
    {

        $url_file = null;

        if ($request->hasFile('rutalogo')) {
            $image = $request->file('rutalogo');
            $destinationPath = public_path() . '/uploads/configuracion';
            $name = rand(0, 9999) . '_' . $image->getClientOriginalName();
            if(!$image->move($destinationPath, $name)) {
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
