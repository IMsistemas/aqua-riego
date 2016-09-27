<?php 
namespace App\Http\Controllers\Tomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Tomas\Toma;
use App\Modelos\Tomas\Derivacion;

class DerivacionController extends Controller
{
	public function index($idtoma)
	{
		return $derivaciones=DB::table('derivacion')->where('idtoma',$idtoma)->get();
	}
	public function show($idderivacion)
	{
		return $barrio=DB::table('derivacion')->where('idderivacion',$idderivacion)->get();
	}

	/*public function maxId()
	{
		$derivacion=Derivacion::max('idderivacion');		
		return $derivacion;
	}*/

	public function maxId() {
		return "holas";
		//return $derivacion=DB::table('derivacion')->max('idderivacion');		
		//$length = count($derivacion);
		//$idderivacion=$derivacion[$length-1]->idderivacion;
		//return $derivacion=$derivacion+1;
	}
	public function postCrearDerivacion(Request $request,$idtoma)
	{
		$derivacion= new Derivacion;
		$derivacion->idtoma= $idtoma;
		$derivacion->descripcionderivacion = $request->input('descripcionderivacion');
		$derivacion->save();
		return 'La derivacion fue creada exitosamente';
	}
	public function postActualizarDerivacion(Request $request,$idderivacion)
	{
		$derivacion=DB::table('derivacion')->where('idderivacion',$idderivacion)->get();
		$descripcionderivacion=$derivacion[0]->descripcionderivacion =$request->input('descripcionderivacion');
		$result = DB::table('derivacion')->where('idderivacion', $idderivacion)->update(array('descripcionderivacion' => $descripcionderivacion));
		//return $result;
		return "Se actualizo correctamente";

	}

	public function destroy($idderivacion)
	{
		$parroquia=DB::table('derivacion')->where('idderivacion',$idderivacion)->get();
		$result = DB::table('derivacion')->where('idderivacion', $idderivacion)->delete();
		return "Se elimino correctamente";
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
