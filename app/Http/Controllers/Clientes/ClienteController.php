<?php

namespace App\Http\Controllers\Clientes;

use App\Modelos\Clientes\Cliente;
use App\Modelos\Clientes\ClienteArriendo;
use App\Modelos\Configuracion\ConfiguracionSystem;
use App\Modelos\Configuraciones\Configuracion;
use App\Modelos\Persona;
use App\Modelos\Sectores\Barrio;
use App\Modelos\Solicitud\Solicitud;
use App\Modelos\Solicitud\SolicitudCambioNombre;
use App\Modelos\Solicitud\SolicitudOtro;
use App\Modelos\Solicitud\SolicitudReparticion;
use App\Modelos\Solicitud\SolicitudRiego;
use App\Modelos\SRI\SRI_TipoIdentificacion;
use App\Modelos\SRI\SRI_TipoImpuestoIva;
use App\Modelos\Tarifas\Area;
use App\Modelos\Tarifas\Tarifa;
use App\Modelos\Terreno\Cultivo;
use App\Modelos\Terreno\Terreno;
use App\Modelos\Tomas\Calle;
use App\Modelos\Tomas\Canal;
use App\Modelos\Tomas\Derivacion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Clientes/index_cliente');
    }


    /**
     * Obtener los clientes paginados
     *
     * @param Request $request
     * @return mixed
     */
    public function getClientes(Request $request)
    {
        $filter = json_decode($request->get('filter'));
        $search = $filter->search;
        $cliente = null;

        $cliente = Cliente::join('persona', 'persona.idpersona', '=', 'cliente.idpersona')
            ->join('cont_plancuenta', 'cont_plancuenta.idplancuenta', '=', 'cliente.idplancuenta')
            ->select('cliente.*', 'persona.*', 'cont_plancuenta.*');

        if ($search != null) {
            $cliente = $cliente->whereRaw("persona.razonsocial ILIKE '%" . $search . "%'");
        }

        return $cliente->orderBy('fechaingreso', 'desc')->paginate(10);
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
     * Obtener y devolver los numeros de identificacion que concuerden con el parametro a buscar
     *
     * @param $identify
     * @return mixed
     */
    public function getIdentify($identify)
    {
        return Persona::whereRaw("numdocidentific::text ILIKE '%" . $identify . "%'")
                        ->whereRaw('idpersona NOT IN (SELECT idpersona FROM cliente)')
                        ->get();
    }

    /**
     * Obtener y devolver la persona que cumpla con el numero de identificacion buscado
     *
     * @param $identify
     * @return mixed
     */
    public function getPersonaByIdentify($identify)
    {
        return Persona::whereRaw("numdocidentific::text ILIKE '%" . $identify . "%'")->get();
    }

    /**
     * Obtener el listado de los tipos de impuestos IVA
     *
     * @return mixed
     */
    public function getImpuestoIVA()
    {
        return SRI_TipoImpuestoIva::orderBy('nametipoimpuestoiva', 'asc')->get();
    }

    public function getIVADefault()
    {
        return ConfiguracionSystem::where('optionname', 'SRI_IVA_DEFAULT')->get();
    }

    public function searchDuplicate($numidentific)
    {
        $result = $this->searchExist($numidentific);
        return response()->json(['success' => $result]);
    }


    private function searchExist($numidentific)
    {
        $count = Cliente::join('persona', 'cliente.idpersona', '=', 'persona.idpersona')
            ->where('persona.numdocidentific', $numidentific)->count();

        return ($count >= 1) ? true : false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('idpersona') == 0) {
            $persona = new Persona();
        } else {
            $persona = Persona::find($request->input('idpersona'));
        }

        $persona->numdocidentific = $request->input('documentoidentidadempleado');
        $persona->email = $request->input('correo');
        $persona->celphone = $request->input('celular');
        $persona->idtipoidentificacion = $request->input('tipoidentificacion');
        $persona->razonsocial = $request->input('nombres') . ' ' . $request->input('apellidos');
        $persona->lastnamepersona = $request->input('apellidos');
        $persona->namepersona = $request->input('nombres');
        $persona->direccion = $request->input('direccion');

        if ($persona->save()) {
            $cliente = new Cliente();
            $cliente->fechaingreso = $request->input('fechaingreso');
            $cliente->estado = true;
            $cliente->idpersona = $persona->idpersona;
            $cliente->idplancuenta = $request->input('cuentacontable');
            $cliente->idtipoimpuestoiva = $request->input('impuesto_iva');
            $cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipaldomicilio');
            $cliente->telefonosecundariodomicilio = $request->input('telefonosecundariodomicilio');
            $cliente->telefonoprincipaltrabajo = $request->input('telefonoprincipaltrabajo');
            $cliente->telefonosecundariotrabajo = $request->input('telefonosecundariotrabajo');
            $cliente->direcciontrabajo = $request->input('direcciontrabajo');

            if ($cliente->save()) {
                return response()->json(['success' => true]);
            } else return response()->json(['success' => false]);

        } else return response()->json(['success' => false]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::find($request->input('idpersona'));

        $persona->numdocidentific = $request->input('documentoidentidadempleado');
        $persona->email = $request->input('correo');
        $persona->celphone = $request->input('celular');
        $persona->idtipoidentificacion = $request->input('tipoidentificacion');
        $persona->razonsocial = $request->input('nombres') . ' ' . $request->input('apellidos');
        $persona->lastnamepersona = $request->input('apellidos');
        $persona->namepersona = $request->input('nombres');
        $persona->direccion = $request->input('direccion');

        if ($persona->save()) {
            $cliente = Cliente::find($id);
            $cliente->fechaingreso = $request->input('fechaingreso');
            $cliente->estado = true;
            $cliente->idpersona = $persona->idpersona;
            $cliente->idplancuenta = $request->input('cuentacontable');
            $cliente->idtipoimpuestoiva = $request->input('impuesto_iva');
            $cliente->telefonoprincipaldomicilio = $request->input('telefonoprincipaldomicilio');
            $cliente->telefonosecundariodomicilio = $request->input('telefonosecundariodomicilio');
            $cliente->telefonoprincipaltrabajo = $request->input('telefonoprincipaltrabajo');
            $cliente->telefonosecundariotrabajo = $request->input('telefonosecundariotrabajo');
            $cliente->direcciontrabajo = $request->input('direcciontrabajo');

            if ($cliente->save()) {
                return response()->json(['success' => true]);
            } else return response()->json(['success' => false]);

        } else return response()->json(['success' => false]);
    }

    /**
     * Obtener si el cliente esta relacionado a alguna solicitud
     *
     * @param $codigocliente
     * @return mixed
     */
    public function getIsFreeCliente($codigocliente)
    {
        return Solicitud::where('idcliente', $codigocliente)->count();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente->delete()) {
            return response()->json(['success' => true]);
        } else return response()->json(['success' => false]);
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     */


    public function getLastID($table)
    {
        $max = null;

        $table = json_decode($table);

        if ($table->name == 'solicitudriego') {
            $max = SolicitudRiego::max('idsolicitudriego');
        } else if ($table->name == 'terreno') {
            $max = Terreno::max('idterreno');
        } else if ($table->name == 'solicitudotro') {
            $max = SolicitudOtro::max('idsolicitudotro');
        } else if ($table->name == 'solicitudcambionombre') {
            $max = SolicitudCambioNombre::max('idsolicitudcambionombre');
        } else if ($table->name == 'solicitudreparticion') {
            $max = SolicitudReparticion::max('idsolicitudreparticion');
        }

        if ($max != null){
            $max += 1;
        } else {
            $max = 1;
        }

        return response()->json(['id' => $max]);
    }


    public function getTerrenosByCliente($idcliente)
    {
        $cliente = json_decode($idcliente);

        return Terreno::with('derivacion.canal.calle.barrio', 'cultivo')
                        ->where('idcliente', $cliente->idcliente)->get();
    }

    public function getIdentifyClientes($idcliente)
    {
        $cliente = json_decode($idcliente);

        return Cliente::join('persona', 'persona.idpersona', '=', 'cliente.idpersona')
            ->where('idcliente', '!=', $cliente->idcliente)->get();
    }

    public function getClienteByIdentify($idcliente)
    {
        $cliente = json_decode($idcliente);

        return Cliente::join('persona', 'persona.idpersona', '=', 'cliente.idpersona')
                            ->where('idcliente', $cliente->idcliente)->get();
    }

    /**
     * Obtener los barrios ordenados ascendentemente
     *
     * @return mixed
     */
    public function getBarrios()
    {
        return Barrio::orderBy('namebarrio', 'asc')->get();
    }

    public function getTarifas()
    {
        return Tarifa::orderBy('nombretarifa', 'asc')->get();
    }

    public function getCultivos($idtarifa)
    {
        return Cultivo::where('idtarifa', $idtarifa)->orderBy('nombrecultivo', 'asc')->get();
    }

    /**
     * Obtener las tomas de un canal ordenadas ascendentemente
     *
     * @param $idbarrio
     * @return mixed
     */
    public function getTomas($idbarrio)
    {
        return Calle::where('idbarrio', $idbarrio)->orderBy('namecalle', 'asc')->get();
    }

    /**
     * Obtener los canales ordenados ascendentemente
     *
     * @return mixed
     */
    public function getCanales($idcalle)
    {
        return Canal::where('idcalle', $idcalle)->orderBy('nombrecanal', 'asc')->get();
    }

    /**
     * Obtener las derivaciones de una toma ordenadas ascendentemente
     *
     * @param $idcanal
     * @return mixed
     */
    public function getDerivaciones($idcanal)
    {
        return Derivacion::where('idcanal', $idcanal)->orderBy('nombrederivacion', 'asc')->get();
    }

    /**
     * Obtener la constante en los datos de configuracion
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getConstante()
    {
        return ConfiguracionSystem::where('optionname','PISQUE_CONSTANTE')->get();
    }

    /**
     * Obtener el resultado de calculo del costo en base al area
     *
     * @param $area
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateValor($area)
    {
        $area_h = $area / 1000;
        $configuracion = ConfiguracionSystem::where('optionname','PISQUE_CONSTANTE')->get();

        $costo_area = Area::where('desde', '<', $area_h)
            ->where('hasta', '>=', $area_h)
            ->where('aniotarifa', date('Y'))
            ->get();

        if (count($costo_area) != 0) {
            if ($costo_area[0]->esfija == true){
                $costo = $costo_area[0]->costo;
            } else {
                $costo = $area_h * $configuracion[0]->optionvalue * $costo_area[0]->costo;
            }

            return response()->json(['success' => true, 'costo' => $costo]);
        } else {
            return response()->json(['success' => false]);
        }

    }



    public function storeSolicitudRiego(Request $request)
    {

        $url_file = null;

        if ($request->hasFile('file')) {

            $pdf = $request->file('file');
            //$destinationPath = storage_path() . '/app/empleados';
            $destinationPath = public_path() . '/uploads/escrituras';
            $name = rand(0, 9999).'_'.$pdf->getClientOriginalName();
            if(!$pdf->move($destinationPath, $name)) {
                return response()->json(['success' => false]);
            } else {
                // $url_file = '/app/empleados/' . $name;
                $url_file = 'uploads/escrituras/' . $name;
            }

        }

        $terreno = new Terreno();
        $terreno->idcultivo = $request->input('idcultivo');
        $terreno->idtarifa = $request->input('idtarifa');
        $terreno->idcliente = $request->input('codigocliente');
        $terreno->idderivacion = $request->input('idderivacion');
        $terreno->fechacreacion = date('Y-m-d');
        $terreno->caudal = $request->input('caudal');
        $terreno->area = $request->input('area');
        $terreno->valoranual = $request->input('valoranual');
        $terreno->observacion = $request->input('observacion');
        //$terreno->urlescrituras = $url_file;

        if ($terreno->save()){

            $solicitud = new Solicitud();

            $solicitud->idcliente = $request->input('codigocliente');
            $solicitud->fechasolicitud = date('Y-m-d');
            $solicitud->fechaprocesada = date('Y-m-d');
            $solicitud->estaprocesada = false;

            if ($solicitud->save()) {
                $solicitudriego = new SolicitudRiego();

                $solicitudriego->idsolicitud = $solicitud->idsolicitud;
                $solicitudriego->idterreno = $terreno->idterreno;
                $solicitudriego->observacion = $request->input('observacion');

                $result = $solicitudriego->save();

                $max_idsolicitud = SolicitudRiego::where('idsolicitudriego', $solicitudriego->idsolicitudriego)->get();

                return ($result) ? response()->json(['success' => true, 'idsolicitud' => $max_idsolicitud[0]->idsolicitud]) :
                    response()->json(['success' => false]);
            } else {
                response()->json(['success' => false]);
            }

        } else response()->json(['success' => false]);

    }

    public function storeSolicitudOtro(Request $request)
    {
        /*$solicitudriego = new SolicitudOtro();
        $solicitudriego->codigocliente = $request->input('codigocliente');
        $solicitudriego->fechasolicitud = date('Y-m-d');
        $solicitudriego->estaprocesada = false;
        $solicitudriego->descripcion = $request->input('observacion');

        $result = $solicitudriego->save();

        $max_idsolicitud = SolicitudOtro::where('idsolicitudotro', $solicitudriego->idsolicitudotro)->get();

        return ($result) ? response()->json(['success' => true, 'idsolicitud' => $max_idsolicitud[0]->idsolicitud]) :
                                                                                response()->json(['success' => false]);*/

        $fecha_actual = date('Y-m-d');

        $solicitud = new Solicitud();
        $solicitud->idcliente = $request->input('codigocliente');
        $solicitud->fechasolicitud = $fecha_actual;
        $solicitud->fechaprocesada = $fecha_actual;
        $solicitud->estaprocesada = false;

        if ($solicitud->save()) {

            $solicitudriego = new SolicitudOtro();
            $solicitudriego->idsolicitud = $solicitud->idsolicitud;
            $solicitudriego->descripcion = $request->input('observacion');

            $result = $solicitudriego->save();

            $max_idsolicitud = SolicitudOtro::where('idsolicitudotro', $solicitudriego->idsolicitudotro)->get();

            return ($result) ? response()->json(['success' => true, 'idsolicitud' => $max_idsolicitud[0]->idsolicitud]) :
                response()->json(['success' => false]);

        } else {
            response()->json(['success' => false]);
        }
    }

    public function storeSolicitudSetName(Request $request)
    {

        $fecha_actual = date('Y-m-d');

        $solicitud = new Solicitud();
        $solicitud->idcliente = $request->input('codigocliente_old');
        $solicitud->fechasolicitud = $fecha_actual;
        $solicitud->fechaprocesada = $fecha_actual;
        $solicitud->estaprocesada = false;

        if ($solicitud->save()) {
            $solicitudsetname = new SolicitudCambioNombre();
            $solicitudsetname->idsolicitud = $solicitud->idsolicitud;

            $solicitudsetname->idcliente = $request->input('codigocliente_new');
            $solicitudsetname->idterreno = $request->input('idterreno');
            $solicitudsetname->observacion = $request->input('observacion');

            $result = $solicitudsetname->save();

            return ($result) ? response()->json(['success' => true,
                'idsolicitud' => $solicitudsetname->idsolicitudcambionombre]) :
                response()->json(['success' => false]);
        } else {
            response()->json(['success' => false]);
        }

    }

    public function storeSolicitudFraccion(Request $request)
    {

        $fecha_actual = date('Y-m-d');

        $solicitud = new Solicitud();
        $solicitud->idcliente = $request->input('codigocliente_old');
        $solicitud->fechasolicitud = $fecha_actual;
        $solicitud->fechaprocesada = $fecha_actual;
        $solicitud->estaprocesada = false;

        if ($solicitud->save()) {

            $solicitud_r = new SolicitudReparticion();

            $solicitud_r->idcliente = $request->input('codigocliente_new');
            $solicitud_r->idterreno = $request->input('idterreno');
            $solicitud_r->idsolicitud = $solicitud->idsolicitud;
            $solicitud_r->observacion = $request->input('observacion');
            $solicitud_r->nuevaarea = $request->input('area');

            $result = $solicitud_r->save();

            return ($result) ? response()->json(['success' => true,
                'idsolicitud' => $solicitud_r->idsolicitudreparticion]) : response()->json(['success' => false]);

        } else {
            response()->json(['success' => false]);
        }

    }

    public function processSolicitud(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);

        $solicitud->estaprocesada = true;
        $solicitud->fechaprocesada = date('Y-m-d');

        $solicitud->save();

        return response()->json(['success' => true]);
    }

    public function processSolicitudSetName(Request $request, $id)
    {
        $solicitud_setname = SolicitudCambioNombre::find($id);

        $terreno = Terreno::find($solicitud_setname->idterreno);
        $terreno->idcliente = $solicitud_setname->idcliente;

        if ($terreno->save()) {
            $solicitud = Solicitud::find($solicitud_setname->idsolicitud);

            $solicitud->estaprocesada = true;
            $solicitud->fechaprocesada = date('Y-m-d');

            if ($solicitud->save()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function processSolicitudFraccion(Request $request, $id)
    {
        $solicitud = SolicitudReparticion::find($id);

        $arriendo = new ClienteArriendo();
        $arriendo->codigoclientearrendador = $solicitud->codigonuevocliente;
        $arriendo->codigoclientearrendatario = $solicitud->codigocliente;
        $arriendo->idterreno = $solicitud->idterreno;
        $arriendo->areaarriendo = $solicitud->nuevaarea;
        $arriendo->save();

        $solicitud->estaprocesada = true;
        $solicitud->fechaprocesada = date('Y-m-d');
        $solicitud->save();

        $this->updateTerreno($solicitud->idterreno, $solicitud->nuevaarea);

        return response()->json(['success' => true]);
    }

    private function updateTerreno($idterreno, $nuevaarea)
    {
        $constante = Configuracion::all();

        $terreno = Terreno::find($idterreno);
        $result_area = $terreno->area - $nuevaarea;

        $result_caudal = ($result_area / 1000) * $constante[0]->constante;

        $area_h = $result_caudal / 1000;

        $costo_area = Area::where('desde', '<', $area_h)
                            ->where('hasta', '>=', $area_h)
                            ->where('aniotarifa', date('Y'))
                            ->get();

        if ($costo_area[0]->esfija == true){
            $costo = $costo_area[0]->costo;
        } else {
            $costo = $area_h * $constante[0]->constante * $costo_area[0]->costo;
        }

        $terreno->area = $result_area;
        $terreno->caudal = $result_caudal;
        $terreno->valoranual = $costo;
        $terreno->save();

    }


}
