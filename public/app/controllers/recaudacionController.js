

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
            (response.count == 0) ? $('#btn-generate').prop('disabled', false) : $('#btn-generate').prop('disabled', true);
        });

        $http.get(API_URL + 'recaudacion/getCobros').success(function(response){
            $scope.cobros = response;
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
        $scope.cliente_info = cobro.apellido + ' ' + cobro.nombre;
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
        } else {
            $('#btn-pagar').prop('disabled', false);
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
            $scope.cobros = response;
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
