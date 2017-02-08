<?php

namespace App\Http\Controllers\Proveedores;

use App\Modelos\Persona;
use App\Modelos\Proveedores\Proveedor;
use App\Modelos\Proveedores\Provincias;
use App\Modelos\Sectores\Canton;
use App\Modelos\Sectores\Parroquia;
use App\Modelos\SRI\SRI_TipoIdentificacion;
use App\Modelos\SRI\SRI_TipoImpuestoIva;
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
     * Obtener todos los tipos de identificacion
     *
     * @return mixed
     */
    public function getTipoIdentificacion()
    {
        return SRI_TipoIdentificacion::orderBy('nameidentificacion', 'asc')->get();
    }


    /**
     * Obtener y devolver los numeros de identificacion que concuerden con el parametro a buscar
     *
     * @param $identify
     * @return mixed
     */
    public function getIdentify($identify)
    {
        return Persona::whereRaw("numdocidentific::text ILIKE '%" . $identify . "%'")
                        ->whereRaw('idpersona NOT IN (SELECT idpersona FROM proveedor)')
                        ->get();
    }


    public function getProvincias()
    {
        return Provincias::orderBy('nameprovincia', 'asc')->get();
    }

    public function getCantones($idprovincia)
    {
        return Canton::where('idprovincia', $idprovincia)->orderBy('namecanton', 'asc')->get();
    }

    public function getParroquias($idcanton)
    {
        return Parroquia::where('idcanton', $idcanton)->orderBy('nameparroquia', 'asc')->get();
    }

    public function getImpuestoIVA()
    {
        return SRI_TipoImpuestoIva::orderBy('nametipoimpuestoiva', 'asc')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state = false;

        if ($request->input('idpersona') == 0) {
            $persona = new Persona();
        } else {
            $persona = Persona::find($request->input('idpersona'));
            $state = true;
        }

        $persona->numdocidentific = $request->input('documentoidentidadempleado');
        $persona->email = $request->input('correo');
        $persona->celphone = $request->input('celular');
        $persona->idtipoidentificacion = $request->input('tipoidentificacion');
        $persona->razonsocial = $request->input('razonsocial');
        $persona->direccion = $request->input('direccion');

        if ($state == false) {
            $persona->lastnamepersona = $request->input('razonsocial');
            $persona->namepersona = $request->input('razonsocial');
        }

        if ($persona->save()) {
            $proveedor = new Proveedor();
            $proveedor->fechaingreso = $request->input('fechaingreso');
            $proveedor->estado = true;
            $proveedor->idpersona = $persona->idpersona;
            $proveedor->telefonoprincipal = $request->input('telefonoprincipal');
            $proveedor->idparroquia = $request->input('parroquia');
            $proveedor->idplancuenta = $request->input('cuentacontable');
            $proveedor->idtipoimpuestoiva = $request->input('impuesto_iva');

            if ($proveedor->save()) {
                return response()->json(['success' => true]);
            } else return response()->json(['success' => false]);

        } else return response()->json(['success' => false]);
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