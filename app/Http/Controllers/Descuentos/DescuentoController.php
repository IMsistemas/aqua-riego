<?php
namespace App\Http\Controllers\Descuentos;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Modelos\Descuentos\Descuento;

class DescuentoController extends Controller
{
    public function index($anio)
	{		 
		return $descuento=DB::table('descuento')->where('anio',$anio)->get();
	}
	public function anio()
	{		 
		$descuento=DB::table('descuento')->orderBy('anio')->get();
		$length = count($descuento);
		return $anio=$descuento[$length-1]->anio;
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
		$descuento = Descuento::find($iddescuento);
		$descuento->anio = $request->input('anio');
		$descuento->mes = $request->input('mes');
		$descuento->porcentaje = $request->input('porcentaje');
		$descuento->save();
		$cliente->save();
		return "Se actualizado correctamente el descuento";
	}
	public function destroy(Request $request)
	{
		$descuento = Descuento::find($request->input('iddescuento'));
		$descuento->delete();
		return "Descuento borrado exitosamente";
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}
}
  