<?php 
namespace App\Http\Controllers\Sectores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Sectores\Provincia;
use App\Modelos\Sectores\Canton;
use App\Modelos\Sectores\Parroquia;
use App\Modelos\Sectores\Barrio;

class BarrioController extends Controller
{
	public function index($idparroquia)
	{
		if($idparroquia==0)
		{
			return $barrios=DB::table('barrio')->orderby('idbarrio')->get();
		}else
		{
			return $barrios=DB::table('barrio')->where('idparroquia',$idparroquia)->get();
		}
	}
	public function show($idbarrio)
	{
		return $barrio=DB::table('barrio')->where('idbarrio',$idbarrio)->get();
	}

	public function maxId(Request $request)
	{
		$barrio=Barrio::max('idbarrio');				
		$barrio=$barrio+1;
		return $barrio;
	}

	public function postCrearBarrio(Request $request,$idparroquia)
	{
		$barrio= new Barrio;
		//$barrio->idbarrio = $request->input('idbarrio');
		$barrio->idparroquia = $idparroquia;
		$barrio->nombrebarrio = $request->input('nombrebarrio');
		$barrio->save();
		return 'El barrio fue creado exitosamente';
	}
	public function postActualizarBarrio(Request $request,$idbarrio)
	{
		$barrio = Barrio::find($idbarrio);
		$barrio->nombrebarrio = $request->input('nombrebarrio');
		$barrio->save();
		return 'El barrio fue actualizado exitosamente';

	}

	public function destroy($idbarrio)
	{
		$barrio = Barrio::find($idbarrio);
		$barrio->calle()->delete();
		$barrio->delete();
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
