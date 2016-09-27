<?php 
namespace App\Http\Controllers\Tomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Tomas\Toma;
use App\Modelos\Tomas\Canal;

class DerivacionController extends Controller
{
	public function index($idparroquia)
	{
		return $canales=Canal::all();
	}
	public function show($idbarrio)
	{
		return $barrio=DB::table('barrio')->where('idbarrio',$idbarrio)->get();
	}

	public function maxId(Request $request)
	{
		$barrio=Barrio::max('idbarrio');		
		if($barrio==NULL){
			$barrio='JM00001';
		}else{
			$identificadorLetras=substr($barrio, 0,-5);//obtiene las tetras del barrio de Provincia
			$identificadorNumero=substr($barrio, 3); //obtiene las tetras del barrio de Provincia
			$identificadorNumero=$identificadorNumero+1;
			$longitudNumero =strlen($identificadorNumero);//obtiene el número de caracteres existentes
			//asigna el identificador numerico del siguiente registro
			switch ($longitudNumero) {
    	     	case 1:
        		$identificadorNumero='0000'.$identificadorNumero;
             	break;
    	    	case 2:
        		$identificadorNumero='000'.$identificadorNumero;
             	break;
             	case 3:
        		$identificadorNumero='00'.$identificadorNumero;
             	break;
             	case 4:
        		$identificadorNumero='0'.$identificadorNumero;
             	break;
			}
			
			$barrio=$identificadorLetras.$identificadorNumero;
			
			
		}
		return $barrio;
	}

	public function postCrearBarrio(Request $request,$idparroquia)
	{
		$barrio= new Barrio;
		$barrio->idbarrio = $request->input('idbarrio');
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
