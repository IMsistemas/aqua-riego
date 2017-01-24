<?php

namespace App\Http\Controllers\Guiaremision;

use Illuminate\Http\Request;

use App\Modelos\Clientes\Cliente;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DateTime;
use DB;



class GuiaremisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Guiaremision/index_guiaremision');
        //view('Guiaremision/from_guiaremision');

    }

    public function show()
    {
       /* $guiaRemision = Cont_DocumentoGuiaRemision::
            join('cont_documentoventa', 'cont_documentoguiaremision.iddocumentoventa', '=', 'cont_documentoventa.iddocumentoventa')
            ->join('cliente', 'cont_documentoguiaremision.idcliente', '=', 'cliente.idcliente')
            /*->select('cont_documentoguiaremision.iddocumentoguiarevision', 'cont_documentoventa.iddocumentoventa', 'orders.price')
            ->get();

        dd($guiaRemision);

        $cliente= Cliente::join('persona','$guiaremision->cliente.idpersona','=','personaidpersona')/*->select('persona.nombre','persona.apellido')->get();

        dd($cliente);

        return ['$guiaRemision' => $guiaRemision, '$cliente' => $cliente];*/

    return $guiaremision::table('cont_documentoguiaremision', 'cont_documentoventa', 'cliente', 'persona')->where( 'cont_documentoguiaremision.iddocumentoventa','=', 'cont_documentoventa.iddocumentoventa')->where('cliente.idpersona','=','persona.idpersona')->get();
        
    }
    public function getItemsVenta()
    {
        return $mercaderia::table('cont_documentoguiaremision','cont_documentoventa','cont_itemventa', 'cont_catalogoitem','cont_categoria')->where( 'cont_documentoguiaremision.iddocumentoguiaremision','=', valor)->where( 'cont_documentoventa.iddocumentoventa','=', 'cont_itemventa.iddocumentoventa')->where('cont_itemventa.iditemventa','=','cont_catalogoitem.iditemventa') ->where('cont_catalogoitem.idicatalogoitem','=','cont_categoria.idcatalogoitem')->get();
        
    }

}
