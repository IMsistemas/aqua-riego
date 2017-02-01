<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Modelos\Contabilidad\Cont_PlanCuenta;
use App\Modelos\Contabilidad\Cont_RegistroContable;
use App\Modelos\Contabilidad\Cont_Transaccion;


use Carbon\Carbon;
use DateTime;
use DB;


class CoreContabilidad extends Controller
{
	/**
	 *
	 * Validacion del numero de comprobante por el tipo de transaccion
	 *
	 *
	 */
	public function getnumerocomprobante($id,$numero)
	{	
		$aux_numerocomprobante=1;
		$transaccion=Cont_Transaccion::whereRaw("idtipotransaccion='$id' AND numcomprobante='$numero' ")->get();
		if($transaccion->idtransaccion){
			$aux_numerocomprobante=($transaccion->numcomprobante+1);
		}else{
			$aux_numerocomprobante=$transaccion->numcomprobante;
		}
		return $aux_numerocomprobante;
	}
	/**
	 *
	 * Validacion del numero de comprobante por el tipo de transaccion
	 *
	 *
	 */
	public  function getnumerocontable()
	{	
		$aux_numero = DB::select("SELECT (count(*)+1) numero FROM cont_transaccion");
		return $aux_numero[0]->numero;
	}
	/**
	 *
	 * Asiento contalbe para todo tipo de transaccion contable
	 *
	 *
	 */
	public   function SaveAsientoContable($transaccioncontable)
	{	
		$transaccioncontable = json_decode($transaccioncontable);
		
		$aux_core=new CoreContabilidad;
		$aux_transaccion=$transaccioncontable->transaccion;
		$aux_registro=$transaccioncontable->registro;

		$transaccion= array(
			'idtipotransaccion'=> $aux_transaccion->idtipotransaccion,
			'numcontable'=> $aux_core->getnumerocontable(),
			'fechatransaccion' => $aux_transaccion->fecha,
			'numcomprobante'=> $aux_core->getnumerocomprobante($aux_transaccion->idtipotransaccion,$aux_transaccion->numcomprobante),
			'descripcion' => $aux_transaccion->descripcion
			 );
		$transaccionguardada=Cont_Transaccion::create($transaccion);
		$idtransaccion=$transaccion->idtransaccion;
		$fecharegistro=$aux_transaccion->fecha;
		if($idtransaccion){
			$aux_respuesta=$this->SaveRegistroAsientoContable($$aux_registro,$idtransaccion,$fecharegistro);
			if($aux_respuesta==1){
				return $idtransaccion;
			}
		}else{
			return 0;
		}
	}
	/**
	 *
	 * Guardar el registro contable de la transaccion
	 *
	 *
	 */
	public function SaveRegistroAsientoContable($aux_registro,$idtransaccion,$fecharegistro)
	{
		$aux_primeracuentacomanda=1;
		$aux_controlhabercomanda="";
		$aux_tipocuentacontablecomanda="";
		foreach ($aux_registro as  $cuenta) {
			if($aux_primeracuentacomanda==1){
				//Se guarda la primera cuenta o asiento que va a comandar para aplicar  la regla contable a las demas cuentas
				$cuentacomada = array(
					'idtransaccion' => $idtransaccion ,
					'idplancuenta'=> $cuenta->idplancuenta,
					'fecha'=> $fecharegistro,
					'descripcion'=> $cuenta->Descipcion,
					'debe'=> $cuenta->Debe,
					'haber'=> $cuenta->Haber,
					'debe_c'=> $cuenta->Debe,
					'haber_c'=> $cuenta->Haber
					 );
				$cuentacomandasave=Cont_RegistroContable::create($cuentacomada);
				if($cuenta->controlhaber=="-"){
					if($cuenta->Debe>0 & $cuenta->Haber==0){
						$aux_controlhabercomanda="+"; //la cuenta que comanda esta aumentando
					}elseif ($cuenta->Debe==0 & $cuenta->Haber>0) {
						$aux_controlhabercomanda="-"; //la cuenta que comanda esta disminuye
					}
				}elseif ($cuenta->controlhaber=="+") {
					if($cuenta->Debe>0 & $cuenta->Haber==0){
						$aux_controlhabercomanda="-"; //la cuenta que comanda esta disminuye
					}elseif ($cuenta->Debe==0 & $cuenta->Haber>0) {
						$aux_controlhabercomanda="+"; //la cuenta que comanda esta aumenta
					}
				}
				$aux_tipocuentacontablecomanda=$cuenta->tipocuenta;
			}else{
				$aux_cuentacontrolhaber="";
				if($cuenta->controlhaber=="-"){
					if($cuenta->Debe>0 & $cuenta->Haber==0){
						$aux_cuentacontrolhaber="+"; //la cuenta que comanda esta aumentando
					}elseif ($cuenta->Debe==0 & $cuenta->Haber>0) {
						$aux_cuentacontrolhaber="-"; //la cuenta que comanda esta disminuye
					}
				}elseif ($cuenta->controlhaber=="+") {
					if($cuenta->Debe>0 & $cuenta->Haber==0){
						$aux_cuentacontrolhaber="-"; //la cuenta que comanda esta disminuye
					}elseif ($cuenta->Debe==0 & $cuenta->Haber>0) {
						$aux_cuentacontrolhaber="+"; //la cuenta que comanda esta aumenta
					}
				}
				if($aux_cuentacontrolhaber==$aux_controlhabercomanda && $aux_tipocuentacontablecomanda==$cuenta->tipocuenta){ // la cuenta o asiento tiene el mismo comportamiento que la que comanda
					$cuentacontable = array(
						'idtransaccion' => $idtransaccion ,
						'idplancuenta'=> $cuenta->idplancuenta,
						'fecha'=> $fecharegistro,
						'descripcion'=> $cuenta->Descipcion,
						'debe'=> $cuenta->Debe,
						'haber'=> $cuenta->Haber,
						'debe_c'=> $cuenta->Debe,
						'haber_c'=> $cuenta->Haber
						 );
					$cuentacontablesave=Cont_RegistroContable::create($cuentacontable);
				}else{ //la cuenta se le aplicara  la regla contable
					$this->ReglaContable($aux_tipocuentacontablecomanda,$aux_controlhabercomanda,$cuenta,$idtransaccion,$fecharegistro);
				}
			}
			$aux_primeracuentacomanda++;
		}
		return 1;
	}
	/**
	 *
	 *
	 * Regla contable para las cuentas o asientos contables que no son iguales a la cuenta contable que comanda
	 *
	 */
	public function ReglaContable($cuentacomanda,$aumentadisminuye,$cuenta,$idtransaccion,$fecharegistro)
	{
		$aux_debe=0.0;
		$aux_haber=0.0;
		$aux_regla=$cuentacomanda."".$aumentadisminuye;
		if($aux_regla=="P+"  || $aux_regla=="PT+" ){ //PASIVO PATRIMONIO AUMENTAN
			if($cuenta->tipocuenta=="A"){ // ACTIVO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif($cuenta->tipocuenta=="I"){ // INGRESO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}else{
				//LAS CUENTAS DISMINUYEN SOLO AUMENTA SI ESTAN A EL MISMO LADO DE LA CUENTA QUE COMANDA 
                //PERO CUANDO YA LLEGA A ESTA PARTE SIGNIGICA QUE NO ESTA A EL MISMO LADO LA CUENTA
               if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}
			
		}elseif($aux_regla=="C+" || $aux_regla=="G+"  ){ // COSTO O CASTO AUMENTA
			if($cuenta->tipocuenta=="A" || $cuenta->tipocuenta=="I"){// ACTIVO e INGRESO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G") {
				//LAS CUENTAS DISMINUYEN SOLO AUMENTA SI ESTAN A EL MISMO LADO DE LA CUENTA QUE COMANDA 
                //PERO CUANDO YA LLEGA A ESTA PARTE SIGNIGICA QUE NO ESTA A EL MISMO LADO LA CUENTA
                if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}				
			}
		}elseif ($aux_regla=="P-" || $aux_regla=="PT-" ) { //PASIVO, PATRIMONIO DISMINUYEN
			if($cuenta->tipocuenta=="A"){// ACTIVO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="I") { // INGRESO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}else{
				//LAS CUENTAS AUMENTAN SOLO DISMINUYEN SI ESTAN A EL MISMO LADO DE LA CUENTA QUE COMANDA 
                //PERO CUANDO YA LLEGA A ESTA PARTE SIGNIGICA QUE NO ESTA A EL MISMO LADO LA CUENTA
                if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}
			
		}elseif($aux_regla=="C-" || $aux_regla=="G-"  ){ // COSTO O CASTO DISMINUYE
			if($cuenta->tipocuenta=="A" || $cuenta->tipocuenta=="I"){// ACTIVO e INGRESO AUMENTA POR EL DEBE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G") {
				//LAS CUENTAS AUMENTA SOLO DISMINUYE SI ESTAN A EL MISMO LADO DE LA CUENTA QUE COMANDA 
                //PERO CUANDO YA LLEGA A ESTA PARTE SIGNIGICA QUE NO ESTA A EL MISMO LADO LA CUENTA
                if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}
		}elseif ($aux_regla=="A+") { //ACTIVOS AUMENTAN 
			if( $cuenta->tipocuenta=="P" || $cuenta->tipocuenta=="PT" ){// PASIVO, PATRIMONIO AUMENTA
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G" ) { //COSTO GASTO DISMINUYE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="A") { // ACTIVO DISMINUYE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="I") { // INGRESO AUMENTA
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}
			
		}elseif ($aux_regla=="I+") { // Ingreso aumenta
			if($cuenta->tipocuenta=="P" || $cuenta->tipocuenta=="PT" || $cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G"){ //PASIVO, PATRIMONIO, COSTO GASTO DISMINUYE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="A") { //	ACTIVO AUMENTA
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="I") { // INGRESO DISMINUYE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}		
		}elseif ($aux_regla=="A-") {// ACTIVO DISMINUYE
			if( $cuenta->tipocuenta=="P" || $cuenta->tipocuenta=="PT" ){// PASIVO, PATRIMONIO DISMINUYE
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G" ) { //COSTO GASTO AUMENTA
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="A") { // ACTIVO AUMENTA
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="I") { // INGRESO DISMINUYE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}
		}elseif ($aux_regla=="I-") {// INGRESO DISMINUYE
			if($cuenta->tipocuenta=="P" || $cuenta->tipocuenta=="PT" || $cuenta->tipocuenta=="C" || $cuenta->tipocuenta=="G"){ //PASIVO, PATRIMONIO, COSTO GASTO AUMENTA
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="A") { //	ACTIVO DISMINUYE
				if($cuenta->Debe>0){
					$aux_haber=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_haber=$cuenta->Haber;
				}
			}elseif ($cuenta->tipocuenta=="I") { // INGRESO AUMENTA
				if($cuenta->Debe>0){
					$aux_debe=$cuenta->Debe;
				}elseif($cuenta->Haber>0){
					$aux_debe=$cuenta->Haber;
				}
			}		
		}

		$cuentacontable = array(
			'idtransaccion' => $idtransaccion ,
			'idplancuenta'=> $cuenta->idplancuenta,
			'fecha'=> $fecharegistro,
			'descripcion'=> $cuenta->Descipcion,
			'debe'=> $cuenta->Debe,
			'haber'=> $cuenta->Haber,
			'debe_c'=> $aux_debe,
			'haber_c'=> $aux_haber
			 );
		$cuentacontablesave=Cont_RegistroContable::create($cuentacontable);
	}
}