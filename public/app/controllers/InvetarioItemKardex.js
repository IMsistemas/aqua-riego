app.controller('Kardex', function($scope, $http, API_URL) {
    $scope.FechaK=now();  // Cargar por default el dia actual 

    $scope.Bodegas=[]; //listas Bodegas
    $scope.Categoria1=[]; //lista categoria 1
    $scope.Categoria2=[]; //lista categoria 2 (subcategoria)

    $scope.CategoriaItem="";
    ///---
    $scope.CargarBodegas=function(){
        $http.get(API_URL + 'procesoskardex/loadbodegas')
        .success(function(response){
            $scope.Bodegas=response;
        });
    };
    ///---
    $scope.CargarCategoriaNivel1=function(){
        $http.get(API_URL + 'procesoskardex/loadcategoria')
        .success(function(response){
            $scope.Categoria1=response;
        });
    };
    ///---
    $scope.CargarCategoriaNivel2=function(){
        if($scope.CategoriaItem!=""){
            $http.get(API_URL + 'procesoskardex/loadsubcategoria/'+$scope.CategoriaItem)
            .success(function(response){
                $scope.Categoria2=response;
            });
        }
    };
     ///---
     $scope.RegistroKardexPP=function (item) {
         $("#RegistroKardePromedioPonderado").modal("show")
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