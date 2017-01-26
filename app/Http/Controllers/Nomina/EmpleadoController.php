<?php

namespace App\Http\Controllers\Nomina;

use App\Modelos\Nomina\Cargo;
use App\Modelos\Nomina\Departamento;
use App\Modelos\Nomina\Empleado;
use App\Modelos\Persona;
use App\Modelos\SRI\SRI_TipoIdentificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class EmpleadoController extends Controller
{

    /**
     * Devolver la vista
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Nomina.index_empleado');
    }

    /**
     * Obtener todos los empleados
     *
     * @return mixed
     */
    public function getEmployees()
    {

        $employee = null;

        $employees = Empleado::join('persona', 'persona.idpersona', '=', 'empleado.idpersona')
                                ->join('departamento', 'departamento.iddepartamento', '=', 'empleado.iddepartamento')
                                ->join('cargo', 'cargo.idcargo', '=', 'empleado.idcargo')
                                ->select('empleado.*', 'departamento.namedepartamento', 'cargo.namecargo', 'persona.*')
                                ->orderBy('fechaingreso', 'asc')->get();

        return $employees;

        //return Empleado::with('cargo')->orderBy('fechaingreso', 'asc')->get();
    }


    /**
     * Obtener todos los cargos
     *
     * @return mixed
     */
    public function getAllPositions()
    {
        return Cargo::orderBy('namecargo', 'asc')->get();
    }

    /**
     * Obtener todos los departamentos
     *
     * @return mixed
     */
    public function getDepartamentos()
    {
        return Departamento::orderBy('namedepartamento', 'asc')->get();
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
     * Almacenar el recurso empleado
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $url_file = null;

        if ($request->hasFile('file')) {

            $image = $request->file('file');
            //$destinationPath = storage_path() . '/app/empleados';
            $destinationPath = public_path() . '/uploads/empleados';
            $name = rand(0, 9999).'_'.$image->getClientOriginalName();
            if(!$image->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                // $url_file = '/app/empleados/' . $name;
                $url_file = '/uploads/empleados/' . $name;
            }

        }

        $persona = new Persona();
        $persona->lastnamepersona = $request->input('apellidos');
        $persona->namepersona = $request->input('nombres');
        $persona->numdocidentific = $request->input('documentoidentidadempleado');
        $persona->fechaingreso = $request->input('fechaingreso');
        $persona->email = $request->input('correo');
        $persona->celphone = $request->input('celular');
        $persona->idtipoidentificacion = $request->input('tipoidentificacion');

        if ($persona->save()) {
            $empleado = new Empleado();
            $empleado->idpersona = $persona->idpersona;
            $empleado->idcargo = $request->input('idcargo');
            $empleado->iddepartamento = $request->input('departamento');
            $empleado->idplancuenta = $request->input('cuentacontable');
            $empleado->estado = true;

            $empleado->telefprincipaldomicilio = $request->input('telefonoprincipaldomicilio');
            $empleado->telefsecundariodomicilio = $request->input('telefonosecundariodomicilio');
            $empleado->direcciondomicilio = $request->input('direcciondomicilio');
            $empleado->salario = $request->input('salario');

            if ($url_file != null) {
                $empleado->rutafoto = $url_file;
            }

            $empleado->save();
        } else {

        }
        return response()->json(['success' => true]);
    }










    /**
     * Mostrar un recurso empleado especifico.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Empleado::with('persona', 'cargo')->where('idempleado', $id) ->get();
    }

    /**
     * Actualizar el recurso empleado seleccionado
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

    }


    public function updateEmpleado(Request $request, $id)
    {
        $empleado1 = Empleado::where ('documentoidentidadempleado',$request->input('documentoidentidadempleado'))-> count();


        if($empleado1 > 0) {
            return response()->json(['success' => false]);
        }else
        {
        $url_file = null;

        if ($request->hasFile('file')) {

            $image = $request->file('file');
            $destinationPath = public_path() . '/uploads/empleados';
            $name = rand(0, 9999).'_'.$image->getClientOriginalName();
            if(!$image->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                $url_file = '/uploads/empleados/' . $name;
            }
        }

        $empleado = Empleado::find($id);
        $empleado->documentoidentidadempleado = $request->input('documentoidentidadempleado');
        $empleado->idcargo = $request->input('idcargo');
        $empleado->apellido = $request->input('apellidos');
        $empleado->nombre = $request->input('nombres');
        $empleado->telefonoprincipal = $request->input('telefonoprincipaldomicilio');
        $empleado->telefonosecundario = $request->input('telefonosecundariodomicilio');
        $empleado->celular = $request->input('celular');
        $empleado->direccion = $request->input('direcciondomicilio');
        $empleado->correo = $request->input('correo');
        $empleado->salario = $request->input('salario');

        if ($url_file != null) {
            $empleado->foto = $url_file;
        }

        $empleado->save();

        return response()->json(['success' => true, 'request' => $request]);
    }
    }

    /**
     * Eliminar el recurso empleado seleccionado
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $empleado = Empleado::find($id);
        $empleado->delete();
        return response()->json(['success' => true]);
    }

}
