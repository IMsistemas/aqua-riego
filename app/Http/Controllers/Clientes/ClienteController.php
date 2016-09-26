<?php
namespace App\Http\Controllers\Clientes;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Modelos\Clientes\Cliente;

class ClienteController extends Controller
{
    public function index()
	{		 
		return $clientes=Cliente::all();
		//$clientes=Cliente::with('profesion','actividad')->get();
	}
	public function store(Request $request)
	{
		$cliente= new Cliente;
		$cliente->idprofecion = $request->input('idprofecion');
		$cliente->idactividad = $request->input('idactividad');
		$cliente->documentoidentidad = $request->input('documentoidentidad');
		$cliente->fechaingreso = date("Y-m-d H:i:s");
		$cliente->nombre = $request->input('nombre');
		$cliente->apellido = $request->input('apellido');
		$cliente->celular = $request->input('celular');
		$cliente->correo = $request->input('correo');
		$cliente->direcciondomicilio = $request->input('direccion');
		$cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipal');
		$cliente->telefonosecundariodomicilio = $request->input('telefonosecundario');
		$cliente->direcciontrabajo = $request->input('direcciontrabajo');
		$cliente->telefonoprincipaltrabajo = $request->input('telefonoprincipaltrabajo');
		$cliente->telefonosecundariotrabajo = $request->input('telefonosecundariotrabajo');
		$cliente->estaactivo = $request->input('estaactivo');
		$cliente->save();
		return 'El Cliente fue creado exitosamente';
	}

	public function show($codigocliente)
	{
		return Cliente::find($codigocliente);
	}

	public function update(Request $request,$codigocliente)
	{
		$cliente = Cliente::find($codigocliente);
		//$cliente->idprofesion = "";//$request->input('idprofesion');
		//$cliente->idactividad = "";//$request->input('idactividad');
		$cliente->documentoidentidad = $request->input('documentoidentidad');
		$cliente->fechaingreso = $request->input('fechaingreso');
		$cliente->nombre = $request->input('nombre');
		$cliente->apellido = $request->input('apellido');
		$cliente->celular = $request->input('celular');
		$cliente->correo = $request->input('correo');
		$cliente->direcciondomicilio = $request->input('direcciondomicilio');
		$cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipaldomicilio');
		$cliente->telefonosecundariodomicilio = $request->input('telefonosecundariodomicilio');
		$cliente->direcciontrabajo = $request->input('direcciontrabajo');
		$cliente->telefonoprincipaltrabajo = $request->input('telefonoprincipaltrabajo');
		$cliente->telefonosecundariotrabajo = $request->input('telefonosecundariotrabajo');
		$cliente->estaactivo = $request->input('estaactivo');
		$cliente->save();
		return "Se actualizado correctamente el cliente";

		/*$parroquia=DB::table('parroquia')->where('idparroquia',$idparroquia)->get();
		$nombreparroquiaupdate=$parroquia[0]->nombreparroquia =$request->input('nombreparroquia');
		$result = DB::table('parroquia')->where('idparroquia', $idparroquia)->update(array('nombreparroquia' => $nombreparroquiaupdate));
		//return $result;
		return "Se actualizo correctamente".$parroquia[0]->idparroquia;*/
	}
	public function destroy(Request $request)
	{
		$cliente = Cliente::find($request->input('codigocliente'));
		$cliente->delete();
		return "Cliente borrado exitosamente";
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}
}
  