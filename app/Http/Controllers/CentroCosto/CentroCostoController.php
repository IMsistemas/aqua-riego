<?php

namespace App\Http\Controllers\CentroCosto;

use App\Modelos\Contabilidad\Cont_CentroCosto;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CentroCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('CentroCosto.index');
    }

    public function getCentroCostos()
    {
        return Cont_CentroCosto::orderBy('namecentrocosto', 'asc')->paginate(10);
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
        $centrocosto = new Cont_CentroCosto();

        $centrocosto->namecentrocosto = $request->input('namecentrocosto');
        $centrocosto->observacion = $request->input('observacion');

        if ($centrocosto->save()) {

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
        $centrocosto = Cont_CentroCosto::find($id);

        $centrocosto->namecentrocosto = $request->input('namecentrocosto');
        $centrocosto->observacion = $request->input('observacion');

        if ($centrocosto->save()) {

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
        /*$aux =  Terreno::where ('idcanal',$id)->count();

        if ($aux > 0){

            return response()->json(['success' => false, 'msg' => 'exist_derivacion']);

        } else {*/

            $centrocosto = Cont_CentroCosto::find($id);

            if ($centrocosto->delete()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }

        //}
    }
}
