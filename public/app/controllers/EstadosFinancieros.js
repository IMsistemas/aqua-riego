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
            console.log(response);
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
                $("#titulomsm").addClass("btn-warning");
                $("#msm").modal("show");
                $scope.Mensaje="Seleccione un tipo de cuenta";    
            }
        }else{
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
                    console.log(response)
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
    $scope.AgregarCuentahija=function(cuenta){
        console.log(cuenta);
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

$(document).ready(function(){
    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        ignoreReadonly: true
    });
});