

app.controller('recaudacionController', function($scope, $http, API_URL) {

    $scope.cobros = [];

    $scope.estados = [
        { id: 3, name: 'Todos' },
        { id: 2, name: 'No Pagada' },
        { id: 1, name: 'Pagada' },
    ];

    $scope.t_estado = 3;

    $scope.initLoad = function () {

        $http.get(API_URL + 'recaudacion/verifyPeriodo').success(function(response){
            (response.success == true) ? $('#btn-generate').prop('disabled', false) : $('#btn-generate').prop('disabled', true);
        });

        $http.get(API_URL + 'recaudacion/getCobros').success(function(response){
            /*var longitud = response.length;
            for (var i = 0; i < longitud; i++) {
                var complete_name = {
                    value: response[i].apellido + ', ' + response[i].nombre,
                    writable: true,
                    enumerable: true,
                    configurable: true
                };
                Object.defineProperty(response[i], 'complete_name', complete_name);
            }*/
            console.log(response);
            $scope.cuentas = response;
        });

    };

    $scope.generate = function () {

        $http.get(API_URL + 'recaudacion/generate').success(function(response){
            if (response.result = '1') {
                $scope.initLoad();
                $scope.message = 'Se ha generado los cobros del periodo actual correctamente...';
                $('#modalMessage').modal('show');
            } else if (response.result = '2') {
                $scope.message = 'No existen registros a generar cobros en el periodo...';
                $('#modalMessage').modal('show');
            }
        });

    };

    $scope.infoAction = function (cobro) {

        $scope.periodo = cobro.aniocobro;
        $scope.cliente_info = cobro.complete_name;
        $scope.junta_info = cobro.nombrebarrio;
        $scope.area_info = cobro.area + ' m2';
        $scope.caudal_info = cobro.caudal;
        $scope.tarifa_info = cobro.nombretarifa;
        $scope.canal_info = cobro.nombrecanal;
        $scope.toma_info = cobro.nombrecalle;
        $scope.derivacion_info = cobro.nombrederivacion;

        $scope.idcuenta = cobro.idcuenta;

        $scope.valor_atrasado = (cobro.valoratrasados != null && cobro.valoratrasados != '') ? cobro.valoratrasados : 0;

        $scope.tipo_tarifa = cobro.nombretarifa;
        $scope.valor_base_tarifa = cobro.valoranual;

        $scope.total = '$ ' + cobro.total;

        if (cobro.estapagada == true) {
            $('#btn-pagar').prop('disabled', true);
            $('#btn-print').prop('disabled', false);
        } else {
            $('#btn-pagar').prop('disabled', false);
            $('#btn-print').prop('disabled', true);
        }

        $('#modalInfoAction').modal('show');
    };

    $scope.pagar = function () {

        var id = $scope.idcuenta;

        var param = {
            estapagada: true
        };

        $http.put(API_URL + 'recaudacion/' + id, param).success(function(response){

            console.log(response);
            $('#modalInfoAction').modal('hide');

            if (response.success == true) {
                $scope.initLoad();
                $scope.message = 'Se ha realizado el pago correspondiente...';
                $('#modalMessage').modal('show');
            } else {
                $scope.message_error = 'Ha ocurrido un error, verifique que existan los valores de Descuento y/o Recargo...';
                $('#modalMessageError').modal('show');
            }

        });

    };

    $scope.imprimir = function () {
        var objeto=document.getElementById('region-imprimir');  //obtenemos el objeto a imprimir
        var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana
    };

    $scope.searchByFilter = function() {
        var text = null;
        var estado = null;

        if($scope.search != undefined && $scope.search != ''){
            text = $scope.search;
        }

        if ($scope.t_estado != undefined && $scope.t_estado != ''){
            estado = $scope.t_estado;
        }

        var filters = {
            estado: estado
        };

        $http.get(API_URL + 'recaudacion/getByFilter/' + JSON.stringify(filters)).success(function(response){
            var longitud = response.length;
            for (var i = 0; i < longitud; i++) {
                var complete_name = {
                    value: response[i].apellido + ', ' + response[i].nombre,
                    writable: true,
                    enumerable: true,
                    configurable: true
                };
                Object.defineProperty(response[i], 'complete_name', complete_name);
            }
            $scope.cobros = response;
        });
    };

    $scope.sort = function(keyname){
        $scope.sortKey = keyname;
        $scope.reverse = !$scope.reverse;
    };

    $scope.loadViewFactura = function (idterreno) {

        $http.get(API_URL + 'recaudacion/getTerrenoForFactura/' + idterreno).success(function(response){

            $scope.currentProjectUrl = '';

            $scope.currentProjectUrl = API_URL + 'DocumentoVenta?flag_suministro=1';
            $("#aux_venta").html("<object height='450px' width='100%' data='"+$scope.currentProjectUrl+"'></object>");
            $('#modalFactura').modal('show');
        });

    };

    $scope.initLoad();

});

$(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY'
    });

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
