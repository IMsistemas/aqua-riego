<?php 
namespace App\Http\Controllers\Tomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Tomas\Canal;

class CanalController extends Controller
{
	public function index()
	{
		return $canales=Canal::all();
	}
	public function show($idcanal)
	{
		return $canal=find($idcanal);
	}

	public function maxId(Request $request)
	{
		$canal=canal::max('idcanal');
		return $canal=$canal+1;
	}

	public function postCrearCanal(Request $request)
	{
		$barrio= new Canal;
		//$barrio->idbarrio = $request->input('idbarrio');
		//$barrio->idparroquia = $idparroquia;
		$barrio->descripcioncanal = $request->input('descripcioncanal');
		$barrio->save();
		return 'El canal fue creado exitosamente';
	}
	public function postActualizarCanal(Request $request,$idcanal)
	{
		$canal = Canal::find($idcanal);
		$canal->descripcioncanal = $request->input('descripcioncanal');
		$canal->save();
		return 'El canal fue actualizado exitosamente';

	}

	public function destroy($idbarrio)
	{
		$canal = Canal::find($idcanal);
		$canal->calle()->delete();
		$canal->delete();
		return "Se elimino exitosamente";
	}

	public function missingMethod($parameters = array())
	{
		abort(404);
	}

	/*=============================Kevin Tambien :-( =========================*/
	public function getBarriosCalles(){
		return Barrio::with('calle')->get();
	}

}
