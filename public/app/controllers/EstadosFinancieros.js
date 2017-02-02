app.controller('Contabilidad', function($scope, $http, API_URL) {
    $scope.GenerarPlanCuentasTipo="E"; //Por default selecciona estado de resultados
    $scope.FechaI=first(); //Cargar por default el primer dia del año actual
    $scope.FechaF=now();  // Cargar por default el dia actual 
    $scope.Mensaje="";  // Mensaje de validacion
    $scope.CuentasContables=[];//Cargar las cuentas contables

    $scope.TipoestadoF="E"; //Tipo estado financiero de cueta para agregar una madre
    $scope.ConceptoCCM=""; //concepto cuenta madre
    $scope.TipoCuenta=""; // tipo cuenta madre
    $scope.CodigoSRICCM=""; //codigo sri

    $scope.FechaIASC=now(); //Cargar por default el primer dia del año actual

    $scope.RegistroC=[];

    $scope.FechaRI=first(); //Cargar por default el primer dia del año actual
    $scope.FechaRF=now();  // Cargar por default el dia actual 

    ///---
    $scope.GenereraFiltroPlanCuentas=function(){
        var aux_fechai=$("#FechaI").val();
        var aux_fechaf=$("#FechaF").val();
        var FiltroCuentasC={
            Tipo : $scope.GenerarPlanCuentasTipo,
            FechaI: convertDatetoDB(aux_fechai),
            FechaF: convertDatetoDB(aux_fechaf)
        };
        $http.get(API_URL + 'estadosfinacieros/plancuentastipo/'+JSON.stringify(FiltroCuentasC))
        .success(function(response){
            $scope.CuentasContables=response;
        });
    };
    ///---
    $scope.AgregarCuentaMadre=function(){
        $("#AddCCMadre").modal("show");
    };
    ///---
    $scope.GuardarCCMadre=function(){
        if($scope.ConceptoCCM !=""){
            if($scope.TipoCuenta!=""){
                $scope.SendDataSaveCCMadre();
            }else{
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-warning");
                $("#msm").modal("show");
                $scope.Mensaje="Seleccione un tipo de cuenta";    
            }
        }else{
            QuitarClasesMensaje();
            $("#titulomsm").addClass("btn-warning");
            $("#msm").modal("show");
            $scope.Mensaje="Agregre un concepto";
        }
    };
    $scope.SendDataSaveCCMadre=function(){
        var validacioncontrolhaber="+";
        switch($scope.TipoCuenta){
            case "A":
                validacioncontrolhaber="-";
                break;
            case "I":
                validacioncontrolhaber="-";
                break;
            default:
                validacioncontrolhaber="+";
                break;
        };

        var CuentaContable={
            concepto: $scope.ConceptoCCM,
            codigosri : $scope.CodigoSRICCM,
            tipoestadofinanz : $scope.TipoestadoF,
            estado: true,
            controlhaber: validacioncontrolhaber,
            jerarquia: "100000",
            tipocuenta: $scope.TipoCuenta
        };
        $http.post(API_URL+'Contabilidad',CuentaContable)
                .success(function (response) {
                    QuitarClasesMensaje();
                    $("#titulomsm").addClass("btn-success");
                    $scope.Mensaje="Se guardo correctamente";
                    $("#msm").modal("show");
                    $scope.GenereraFiltroPlanCuentas();
                    $scope.ClearCuentaMadre();
                    $("#AddCCMadre").modal("hide");
        });
    };
    $scope.ClearCuentaMadre=function(){
        $scope.TipoestadoF="E"; 
        $scope.ConceptoCCM=""; 
        $scope.TipoCuenta=""; 
        $scope.CodigoSRICCM=""; 
    };
    ///---
    $scope.aux_cuentaMadre={};
    $scope.AgregarCuentahija=function(cuenta){
        $scope.aux_cuentaMadre=cuenta;
        $("#AddCCNodo").modal("show");
    };
    $scope.GuardarCCNodo=function(){
        if($scope.ConceptoCCM !=""){
            $scope.SendDataSaveCCnodo();
        }else{
            QuitarClasesMensaje();
            $("#titulomsm").addClass("btn-warning");
            $("#msm").modal("show");
            $scope.Mensaje="Agregre un concepto";
        }
    };
    $scope.SendDataSaveCCnodo=function(){
        var CuentaContable={
            concepto: $scope.ConceptoCCM,
            codigosri : $scope.CodigoSRICCM,
            tipoestadofinanz : $scope.aux_cuentaMadre.tipoestadofinanz,
            estado: true,
            controlhaber: $scope.aux_cuentaMadre.controlhaber,
            jerarquia: $scope.aux_cuentaMadre.jerarquia,
            tipocuenta: $scope.aux_cuentaMadre.tipocuenta
        };
        $http.post(API_URL+'Contabilidad',CuentaContable)
                .success(function (response) {
                    QuitarClasesMensaje();
                    $("#titulomsm").addClass("btn-success");
                    $scope.Mensaje="Se guardo correctamente";
                    $("#msm").modal("show");
                    $scope.GenereraFiltroPlanCuentas();
                    $scope.ClearCuentaMadre();
                    $("#AddCCNodo").modal("hide");
        });
        $scope.aux_cuentaMadre={};// limpiar aux cuenta madre
    };
    ///---
    $scope.ModificarCuentaC=function(cuenta){
        $("#ModifyCCNodo").modal("show");
        $scope.aux_cuentaMadre={
            idplancuenta:cuenta.idplancuenta,
            concepto : cuenta.concepto,
            codigosri : cuenta.codigosri,
            tipoestadofinanz : cuenta.tipoestadofinanz,
            estado : cuenta.estado,
            controlhaber : cuenta.controlhaber,
            jerarquia : cuenta.jerarquia,
            tipocuenta : cuenta.tipocuenta
        };
        $scope.ConceptoCCM=$scope.aux_cuentaMadre.concepto;
        $scope.CodigoSRICCM=$scope.aux_cuentaMadre.codigosri;
    };
    $scope.GuardarModificacionNodo=function(){
        if($scope.ConceptoCCM !=""){
            $scope.SendDataSaveModifyCCnodo();
        }else{
            QuitarClasesMensaje();
            $("#titulomsm").addClass("btn-warning");
            $("#msm").modal("show");
            $scope.Mensaje="Agregre un concepto";
        }
    };
    $scope.SendDataSaveModifyCCnodo=function(){
        $scope.aux_cuentaMadre.concepto=$scope.ConceptoCCM;
        $scope.aux_cuentaMadre.codigosri=$scope.CodigoSRICCM;
        $http.put(API_URL+'Contabilidad/'+$scope.aux_cuentaMadre.idplancuenta,$scope.aux_cuentaMadre)
                .success(function (response) {
                    QuitarClasesMensaje();
                    $("#titulomsm").addClass("btn-success");
                    $scope.Mensaje="Se guardo correctamente";
                    $("#msm").modal("show");
                    $scope.GenereraFiltroPlanCuentas();
                    $scope.ClearCuentaMadre();
                    $("#ModifyCCNodo").modal("hide");
        });
        $scope.aux_cuentaMadre={};// limpiar aux cuenta madre
    };
    ///---
    $scope.BorrarCuentaC=function(cuenta){
        $scope.aux_cuentaMadre=cuenta;
        $("#msmBorarCC").modal("show");
    };
    $scope.okBorrarCuenta=function(){
        $http.get(API_URL + 'estadosfinacieros/borrarcuenta/'+JSON.stringify($scope.aux_cuentaMadre))
        .success(function(response){
            if(response=="Ok"){
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-success");
                $scope.Mensaje="Se borro correctamente";
                $("#msm").modal("show");
                $scope.GenereraFiltroPlanCuentas();
                $scope.ClearCuentaMadre();
                $("#msmBorarCC").modal("hide");
            }else{
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-danger");
                $scope.Mensaje="Error al borrar la cuenta contable";
                $("#msmBorarCC").modal("hide");
                $("#msm").modal("show");
            }
        });
    };
    ///---
    $scope.NumeroIASC="";
    $scope.AddAsientoContable=function(){
        $("#AddAsc").modal("show");
        $scope.TipoTransaccion();
    };
    ///---
    $scope.AddIntemCotable=function(){
        var item={
            idplancuenta:"",
            concepto:"",
            controlhaber:"",
            tipocuenta:'',
            Debe:0,
            Haber:0,
            Descipcion:""
        };
        $scope.RegistroC.push(item);
    };
    ///---
    $scope.BorrarFilaAsientoContable=function(item){
        var posicion= $scope.RegistroC.indexOf(item);
         $scope.RegistroC.splice(posicion,1);
         $scope.SumarDebeHaber();
    };
    ///---
    $scope.listatipotransaccion=[];
    $scope.tipotransaccion="";
    $scope.TipoTransaccion=function(){
      $http.get(API_URL + 'transacciones/alltipotransacciones')
        .success(function(response){
            $scope.listatipotransaccion=response;
        });  
    };
    ///---
    $scope.aux_plancuentas=[];
    $scope.aux_cuentabuscar={};
    $scope.BuscarCuentaContable=function(registro){
        $scope.aux_cuentabuscar=registro;
        $("#PlanContable").modal("show");
        $http.get(API_URL + 'estadosfinacieros/plancontabletotal')
        .success(function(response){
            console.log(response);
            $scope.aux_plancuentas=response;
        });
    };
    ///---
    $scope.AsignarCuentaContable=function(cuenta){
        $scope.aux_cuentabuscar.idplancuenta=cuenta.idplancuenta;
        $scope.aux_cuentabuscar.concepto=cuenta.concepto;
        $scope.aux_cuentabuscar.controlhaber=cuenta.controlhaber;
        $scope.aux_cuentabuscar.tipocuenta=cuenta.tipocuenta;
        $("#PlanContable").modal("hide");
    };
    ///---
    $scope.AsientoContable=function(){

        if($scope.tipotransaccion!=""){
            if($scope.NumeroIASC!=""){
                if($scope.ValidaRegistriContable()==true){
                    if($scope.ValidaDebeHaber()==true){
                        $scope.ProcesarDatosAsientoContable();
                    }else{
                        QuitarClasesMensaje();
                        $("#titulomsm").addClass("btn-warning");
                        $scope.Mensaje="El Debe no es igual a el Haber";
                        $("#msm").modal("show");    
                    }
                }else{
                    QuitarClasesMensaje();
                    $("#titulomsm").addClass("btn-warning");
                    $scope.Mensaje="Transacción contable erronea";
                    $("#msm").modal("show");    
                }
            }else{
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-warning");
                $scope.Mensaje="Ingrese un número de egreo o ingreso";
                $("#msm").modal("show");
            }
        }else{
            QuitarClasesMensaje();
            $("#titulomsm").addClass("btn-warning");
            $scope.Mensaje="Seleccione un tipo de transacción";
            $("#msm").modal("show");
        }
    };
    ///---
    $scope.ProcesarDatosAsientoContable=function () {
        $("#procesarinfomracion").modal("show");
        var aux_fecha=convertDatetoDB($("#FechaIASC").val());
        var Transaccion={
            fecha: aux_fecha,
            idtipotransaccion: $scope.tipotransaccion,
            numcomprobante: $scope.NumeroIASC,
            descripcion: $scope.DescripcionASC
        };

        var Contabilidad={
            transaccion: Transaccion,
            registro: $scope.RegistroC
        };
        $http.get(API_URL + 'estadosfinacieros/asc/'+JSON.stringify(Contabilidad))
        .success(function(response){
           if(!isNaN(response)){
                QuitarClasesMensaje();
                $("#procesarinfomracion").modal("hide");
                $("#titulomsm").addClass("btn-success");
                $scope.Mensaje="Se Guardo Correctamente";
                $("#AddAsc").modal("hide");
                $("#msm").modal("show");
                $scope.ClearAsientoContable();
           }else{
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-danger");
                $scope.Mensaje="Error Al Guardar El Asiento Contable";
                $("#msm").modal("show");
           }
        });
    };
    ///---
    $scope.ClearAsientoContable=function(){
        $scope.tipotransaccion="";
        $scope.NumeroIASC="";
        $scope.DescripcionASC="";
        $scope.RegistroC=[];
        $scope.aux_sumdebe=0;
        $scope.aux_sumhaber=0;
    };
    ///---
    $scope.aux_sumdebe=0.0;
    $scope.aux_sumhaber=0.0;
    $scope.SumarDebeHaber=function() {
        var aux_debe=0.0;
        var aux_haber=0.0;
        for(x=0;x<$scope.RegistroC.length;x++){
            if($scope.RegistroC[x].Debe!="") aux_debe+=parseFloat($scope.RegistroC[x].Debe);
            if($scope.RegistroC[x].Haber!="") aux_haber+=parseFloat($scope.RegistroC[x].Haber);
        }
        $scope.aux_sumdebe=aux_debe;
        $scope.aux_sumhaber=aux_haber;
    };
    ///---
    $scope.ValidaRegistriContable=function(){
        var aux_validacion=0;
        for(x=0;x<$scope.RegistroC.length;x++){
            if($scope.RegistroC[x].concepto!=""){
                if(($scope.RegistroC[x].Debe!="0" & $scope.RegistroC[x].Haber=="0") || ($scope.RegistroC[x].Debe=="0" & $scope.RegistroC[x].Haber!="0") ){
                     aux_validacion=1;
                }else{
                    aux_validacion=0;
                    return false;
                }
            }else{
                aux_validacion=0;
                return false;
            }
        }
        if(aux_validacion==1) return true;
    };
    ///---
    $scope.ValidaDebeHaber=function(){
        var aux_debe=0.0;
        var aux_haber=0.0;
        for(x=0;x<$scope.RegistroC.length;x++){
            if($scope.RegistroC[x].Debe!="") aux_debe+=parseFloat($scope.RegistroC[x].Debe);
            if($scope.RegistroC[x].Haber!="") aux_haber+=parseFloat($scope.RegistroC[x].Haber);
        }
        if(aux_debe==aux_haber){
            return true;
        }else{
            return false;
        }
    };
    ///---
    $scope.RegistroCuentaContable=[];
    $scope.aux_CuentaContableSelc={};
    $scope.RegistroContableCuenta=function(cuenta) {
        $scope.aux_CuentaContableSelc=cuenta;
        $scope.LoadRegistroCuenta();
    };
    ///---
    $scope.LoadRegistroCuenta=function() {
        $("#procesarinfomracion").modal("show");
        var aux_fechai=$("#FechaRI").val();
        var aux_fechaf=$("#FechaRF").val();
        var filtroregistro={
            idplancuenta: $scope.aux_CuentaContableSelc.idplancuenta,
            controlhaber: $scope.aux_CuentaContableSelc.controlhaber,
            Fechai: convertDatetoDB(aux_fechai),
            Fechaf: convertDatetoDB(aux_fechaf)
        };
      $http.get(API_URL + 'estadosfinacieros/registrocuenta/'+JSON.stringify(filtroregistro))
        .success(function(response){
            $scope.RegistroCuentaContable=response;
            $("#procesarinfomracion").modal("hide");
        });
    };
    ///---
    $scope.ProcesoModificarAsientoCt=function(registro) {
        /// Por definir edicion
    };
    ///--- 
    $scope.ProcesoBorrarAsientoCt=function(registro) {
        /// Por definir morrar
    };
});



function convertDatetoDB(now, revert){
    if (revert == undefined){
        var t = now.split('/');
        return t[2] + '-' + t[1] + '-' + t[0];
    } else {
        var t = now.split('-');
        return t[2] + '/' + t[1] + '/' + t[0];
    }
}

function now(){
    var now = new Date();
    var dd = now.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = now.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;
    var yyyy = now.getFullYear();
    return dd + "\/" + mm + "\/" + yyyy;
}
function first(){
    var now = new Date();
    var yyyy = now.getFullYear();
    return "01/01/"+ yyyy;
}

function completarNumer(valor){
    if(valor.toString().length>0){
        var i=5;
        var completa="0";
        var aux_com=i-valor.toString().length;
        for(x=0;x<aux_com;x++){
            completa+="0";
        }
    }
    return completa+valor.toString();
}

function QuitarClasesMensaje() {
    $("#titulomsm").removeClass("btn-primary");
    $("#titulomsm").removeClass("btn-warning");
    $("#titulomsm").removeClass("btn-success");
    $("#titulomsm").removeClass("btn-info");
    $("#titulomsm").removeClass("btn-danger");
}
$(document).ready(function(){
    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        ignoreReadonly: true
    });
});