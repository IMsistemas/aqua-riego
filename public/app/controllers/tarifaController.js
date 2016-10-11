
app.controller('tarifaController', function($scope, $http, API_URL) {

    $scope.area_caudal = [];
    $scope.constante = 0;
    $scope.item_delete = 0;

    $scope.initData = function () {
        $scope.getTarifas();
        $scope.searchConstante();
    };

    $scope.searchConstante = function() {
        $http.get(API_URL + 'tarifa/getConstante').success(function(response){
            $scope.constante = parseFloat(response[0].constante);
        });
    };

    $scope.getTarifas = function () {
        $http.get(API_URL + 'tarifa/getTarifas').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
        });
    };

    $scope.getAreaCaudal = function() {

        $('.datepicker').datetimepicker({
            locale: 'es',
            format: 'YYYY'
        });


        if ($scope.t_tarifa != 0 && $scope.t_tarifa != undefined){
            var idtarifa = $scope.t_tarifa;
            var year = $scope.t_year;

            if ($scope.t_year == undefined || $scope.t_year == '0'){
                year = '';
            }

            var data = {
                idtarifa: idtarifa,
                year: year
            }

            $http.get(API_URL + 'tarifa/getAreaCaudal/' + JSON.stringify(data)).success(function(response){
                var longitud = (response[0].area).length;

                var list = [];

                for (var i = 0; i < longitud; i++) {
                    var object = {
                        area: response[0].area[i],
                        caudal: response[0].caudal[i]
                    };

                    list.push(object);
                }

                $scope.area_caudal = list;
                $('#btn_create_row').prop('disabled', false);
            });
        } else {
            $scope.area_caudal = [];
            $('#btn_create_row').prop('disabled', true);
        }
    };

    $scope.createRow = function () {
        var object_row = {
            area: {
                aniotarifa: '',
                costo: '0.00',
                desde: '0.00',
                esfija: false,
                hasta: '0.00',
                idarea: 0,
                idtarifa: $scope.t_tarifa,
                observacion: ''
            },
            caudal: {
                aniotarifa: '',
                desde: '0.00',
                hasta: '0.00',
                idcaudal: 0,
                idtarifa: $scope.t_tarifa
            }
        };

        ($scope.area_caudal).push(object_row);

    };

    $scope.showModal = function () {
        var now = new Date();
        $scope.year_ingreso = now.getFullYear();

        $http.get(API_URL + 'tarifa/getLastID').success(function(response){
            $scope.nombretarifa = '';
            $scope.idtarifa = response.id;
        });

        $('#modalTarifa').modal('show');
    };

    $scope.saveTarifa = function () {

        var data = {
            nombretarifa: $scope.nombretarifa
        };

        $http.post(API_URL + 'tarifa', data ).success(function (response) {
            $scope.getTarifas();
            $('#modalTarifa').modal('hide');
            $scope.message = 'Se insertó correctamente la Tarifa';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });
    };

    $scope.calculateCaudalDesde = function (item) {
        item.caudal.desde = (item.area.desde * $scope.constante).toFixed(2);
    };

    $scope.calculateCaudalHasta = function (item) {
        item.caudal.hasta = (item.area.hasta * $scope.constante).toFixed(2);
    };

    $scope.saveSubTarifas = function () {

        var subtarifas = { subtarifas: $scope.area_caudal };

        $http.post(API_URL + 'tarifa/saveSubTarifas', subtarifas).success(function(response){
            console.log(response);
            $scope.getAreaCaudal();
            $scope.message = 'Se insertó correctamente las SubTarifa';
            $('#modalMessage').modal('show');
        });

    };

    $scope.showDeleteRow = function (item) {

        $scope.item_delete = item;

        $('#modalConfirmDelete').modal('show');
    };

    $scope.deleteRow = function () {

        var data = {
            idarea: $scope.item_delete.area.idarea,
            idcaudal: $scope.item_delete.caudal.idcaudal
        };

        $http.post(API_URL + 'tarifa/deleteSubTarifas', data).success(function(response){
            console.log(response);
            $scope.getAreaCaudal();

            $('#modalConfirmDelete').modal('hide');
            $scope.message = 'Se eliminó correctamente la SubTarifa...';
            $('#modalMessage').modal('show');
            $scope.item_delete = 0;
        });

    };

    $scope.generate = function () {
        $http.get(API_URL + 'tarifa/generate').success(function(response){
            console.log(response);
            $scope.message = 'Se generó correctamente las tarifas para el actual año...';
            $('#modalMessage').modal('show');
        });
    };

    $scope.onlyDecimal = function ($event) {

        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /\d/;
        var n = String.fromCharCode(k);

        if (n == ".") {
            return true;
        } else {

            if(patron.test(n) == false){
                $event.preventDefault();
            }
            else return true;
        }
    };

    $scope.initData();

});

$(function(){

    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'YYYY'
    });

});