<?php

namespace App\Http\Controllers\Reportes;

use App\Modelos\Contabilidad\Cont_DocumentoCompra;
use App\Modelos\SRI\SRI_Establecimiento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReporteCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes.reporteCompra');
    }


    public function getCompras(Request $request)
    {

        $filter = json_decode($request->get('filter'));

        return  Cont_DocumentoCompra::join('proveedor', 'proveedor.idproveedor', '=', 'cont_documentocompra.idproveedor')
                                        ->join('persona','persona.idpersona','=','proveedor.idpersona')
                                        ->select('persona.razonsocial', 'cont_documentocompra.*')
                                        ->whereRaw("cont_documentocompra.fecharegistrocompra BETWEEN '" . $filter->inicio . "' AND '"  . $filter->fin . "'")
                                        ->get();
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


    public function getComprasPrint($parametro)
    {

        $filter = json_decode($parametro);

        return  Cont_DocumentoCompra::join('proveedor', 'proveedor.idproveedor', '=', 'cont_documentocompra.idproveedor')
                                    ->join('persona','persona.idpersona','=','proveedor.idpersona')
                                    ->select('persona.razonsocial', 'cont_documentocompra.*')
                                    ->whereRaw("cont_documentocompra.fecharegistrocompra BETWEEN '" . $filter->FechaI . "' AND '"  . $filter->FechaF . "'")
                                    ->get();
    }

    public function reporte_print($parametro)
    {
        ini_set('max_execution_time', 300);

        $filtro = json_decode($parametro);

        $aux_empresa = SRI_Establecimiento::all();
        $comprobacion = $this->getComprasPrint($parametro);
        $today = date("Y-m-d H:i:s");

        $view =  \View::make('reportes.reporteCompraPrint', compact('filtro','comprobacion','today','aux_empresa'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('reportCompras_' . $today);
    }

}
