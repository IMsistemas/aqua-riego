<?php

namespace App\Http\Controllers\Nomina;

use App\Modelos\Nomina\Cargo;
use App\Modelos\Nomina\Empleado;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CargoController extends Controller
{
    /**
     * Mostrar una lista de los recursos de cargos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Nomina.index_cargo');
    }

    /**
     * Obtener todos los cargos de manera ascendente
     *
     * @return mixed
     */
    public function getCargos()
    {
        return Cargo::orderBy('nombrecargo', 'asc')->get();
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCargoByID($id){
        return Cargo::where('idcargo', $id)->orderBy('nombrecargo')->get();
    }

    /**
     * Obtener los cargos filtrados
     *
     * @param $filter
     * @return mixed
     */
    public function getByFilter($filter)
    {
        $filter = json_decode($filter);

        return Cargo::orderBy('idcargo', 'asc')
                      ->whereRaw("cargo.idcargo LIKE '%" . $filter->text . "%' OR cargo.nombrecargo LIKE '%" . $filter->text . "%' ")
                      ->get();
    }

    /**
     * Almacenar un recurso cargo recién creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cargo1 = Cargo::where ('nombrecargo',$request->input('nombrecargo'))-> count();


        if($cargo1 > 0)
        {
            return response()->json(['success' => false]);
        }else{
            $cargo = new Cargo();

            $cargo->nombrecargo = $request->input('nombrecargo');

            $cargo->save();

            return response()->json(['success' => true]);
        }

    }

    /**
     * Mostrar un recurso cargo especifico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::find($id);
        return response()->json($cargo);
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
        $cargo = Cargo::find($id);

        $cargo->nombrecargo = $request->input('nombrecargo');
        $cargo->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Empleado::where ('idcargo',$id)-> count();
        if($empleado > 0)
        {
            return response()->json(['success' => false]);
        }else{
            $cargo = Cargo::find($id);
            $cargo->delete();
            return response()->json(['success' => true]);
        }

    }
}
