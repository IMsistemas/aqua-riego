<?php

namespace App\Http\Controllers\Solicitud;

use App\Modelos\Clientes\Cliente;
use App\Modelos\Solicitud\Solicitud;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Solicitud.solicitud');
    }


    public function getSolicitudes()
    {
        //return Solicitud::with('cliente')->get();
        return Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente')->get();
    }

    public function getByFilters($filters)
    {
        $filter = json_decode($filters);

        $solicitud = Solicitud::join('cliente', 'solicitud.codigocliente', '=', 'cliente.codigocliente');

        if($filter->text != null){
            $solicitud->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
            $solicitud->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');
        }

        if($filter->estado != null){
            $solicitud->where('estaprocesada', $filter->estado);
        }

        /*$solicitud = Solicitud::with('cliente');

        if($filter->text != null){

            $solicitud = Solicitud::with([
                'cliente' => function($query) use ($filter) {
                    $query->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
                    $query->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');
                }
            ]);

            $solicitud = Solicitud::with('cliente');
            $solicitud->where('cliente.nombre',  'LIKE',  '%' . $filter->text . '%');
            $solicitud->orWhere('cliente.apellido',  'LIKE',  '%' . $filter->text . '%');

        }*/

        /*if($filter->estado != null){
            $solicitud->whereRaw('estaprocesada = ' . $filter->estado);
        }*/

        return $solicitud->get();
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

        $cliente = new Cliente();

        $cliente->documentoidentidad = $request->input('codigocliente');
        $cliente->fechaingreso = $request->input('fechaingreso');
        $cliente->apellido = $request->input('apellido');
        $cliente->nombre = $request->input('nombre');
        $cliente->celular = $request->input('celular');
        $cliente->direcciondomicilio = $request->input('direccion');
        $cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipal');
        $cliente->telefonosecundariodomicilio = $request->input('telefonosecundario');
        $cliente->direcciontrabajo = $request->input('direccionemp');
        $cliente->telefonoprincipaltrabajo = $request->input('telfprincipalemp');
        $cliente->telefonosecundariotrabajo = $request->input('telfsecundarioemp');
        $cliente->estaactivo = true;

        $cliente->save();

        $solicitud = new Solicitud();
        $solicitud->codigocliente = $cliente->codigocliente;
        $solicitud->fechasolicitud = $request->input('fechaingreso');
        $solicitud->estaprocesada = false;
        $solicitud->save();

        return response()->json(['success' => true]);

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
