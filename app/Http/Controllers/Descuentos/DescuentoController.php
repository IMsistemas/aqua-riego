<?php
namespace App\Http\Controllers\Descuentos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Modelos\Descuentos\Descuento;

class DescuentoController extends Controller
{
    public function index()
	{		 
		return $descuento=Descuento::all();
		//$clientes=Cliente::with('profesion','actividad')->get();
	}
	public function store(Request $request)
	{
		$descuento= new Descuento;
		$descuento->anio = $request->input('anio');
		$descuento->mes = $request->input('mes');
		$descuento->porcentaje = $request->input('porcentaje');
		$descuento->save();
		return 'El descuento fue creado exitosamente';
	}

	public function show($iddescuento)
	{
		return Descuento::find($iddescuento);
	}

	public function update(Request $request,$iddescuento)
	{
		$cliente = Descuento::find($iddescuento);
		$descuento->anio = $request->input('anio');
		$descuento->mes = $request->input('mes');
		$descuento->porcentaje = $request->input('porcentaje');
		$descuento->save();
		$cliente->save();
		return "Se actualizado correctamente el descuento";
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
  