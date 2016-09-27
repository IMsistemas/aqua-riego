<?php 
namespace App\Http\Controllers\Tomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modelos\Tomas\Canal;
use App\Modelos\Tomas\Toma;

class TomaController extends Controller
{
	public function index($idcanal)
	{
		return$tomas=DB::table('toma')->where('idcanal',$idcanal)->get();
	}
	public function show($idtoma)
	{
		return $toma=Toma::find($idtoma);
	}

	public function maxId()
	{
		$toma=Toma::max('idtoma');
		return $toma=$toma+1;
	}

	public function postCrearToma(Request $request,$idcanal)
	{
		$toma= new Toma;
		$toma->idcanal = $idcanal;
		$toma->descripciontoma = $request->input('descripciontoma');
		$toma->save();
		return 'La Toma fue creada exitosamente';
	}
	public function postActualizarToma(Request $request,$idtoma)
	{
		$toma = Toma::find($idtoma);
		$toma->descripciontoma = $request->input('descripciontoma');
		$toma->save();
		return 'El toma fue actualizada exitosamente';

	}

	public function destroy($idtoma)
	{
		$toma = Toma::find($idtoma);
		$toma->delete();
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
