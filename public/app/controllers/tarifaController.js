
    app.controller('tarifaController', function($scope, $http, API_URL) {

        $scope.area_caudal = [];
        $scope.constante = 0;
        $scope.item_delete = 0;

        $scope.initData = function () {
            $scope.searchConstante();
        };

        $scope.searchConstante = function() {
            $http.get(API_URL + 'tarifa/getConstante').success(function(response){
                if (response[0].optionvalue == null || response[0].optionvalue == ''){
                    $('#btn_inform').prop('disabled', true);
                    $('#btn_edit').prop('disabled', true);
                    $('#btn_create_row').prop('disabled', true);

                    $scope.message_info = 'Para Trabajar con las Tarifas, se necesita especificar la constante de calculo en Configuración del Sistema...';
                    $('#modalMessageInfo').modal('show');
                } else {
                    $('#btn_inform').prop('disabled', false);
                    $('#btn_edit').prop('disabled', false);
                    $('#btn_create_row').prop('disabled', false);

                    $scope.getTarifas();
                    $scope.constante = parseFloat(response[0].optionvalue);
                }
            });
        };

        $scope.getTarifas = function (idtarifa) {
            $http.get(API_URL + 'tarifa/getTarifas').success(function(response){
                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: 0}];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
                }
                $scope.tarifas = array_temp;

                if (idtarifa != undefined) {
                    $scope.t_tarifa = idtarifa;
                } else $scope.t_tarifa = 0;
            });
        };

        $scope.getAreaCaudal = function() {

            $scope.t_year = $('#t_year').val();

            if ($scope.t_tarifa != 0 && $scope.t_tarifa != undefined){
                var idtarifa = $scope.t_tarifa;
                var year = $scope.t_year;

                if ($scope.t_year == undefined || $scope.t_year == '0'){
                    year = '';
                }

                var data = {
                    idtarifa: idtarifa,
                    year: year
                };

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
                    $('#btn-save-tarifas').prop('disabled', false);
                });
            } else {
                $scope.area_caudal = [];
                $('#btn_create_row').prop('disabled', true);
                $('#btn-save-tarifas').prop('disabled', true);
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
                $scope.getTarifas($scope.t_tarifa);
                $('#modalTarifa').modal('hide');
                $scope.message = 'Se insertó correctamente la Tarifa...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();

            }).error(function (res) {

            });
        };

        $scope.calculateCaudalDesde = function (item) {
            item.caudal.desde = (parseFloat(item.area.desde) * parseFloat($scope.constante)).toFixed(2);
        };

        $scope.calculateCaudalHasta = function (item) {
            item.caudal.hasta = (parseFloat(item.area.hasta) * parseFloat($scope.constante)).toFixed(2);
        };

        $scope.saveSubTarifas = function () {

            var subtarifas = { subtarifas: $scope.area_caudal };

            $http.post(API_URL + 'tarifa/saveSubTarifas', subtarifas).success(function(response){
                console.log(response);
                $scope.getAreaCaudal();
                $scope.message = 'Se actualizó correctamente las SubTarifa del Tipo seleccionado....';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
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

                if (response.success == true){
                    $scope.message = 'Se generó correctamente las tarifas para el actual año...';
                    $('#modalMessage').modal('show');
                } else if (response.success == false && response.msg == 'no_exists_tarifa') {
                    $scope.message_info = 'Debe crear tarifas a generar...';
                    $('#modalMessageInfo').modal('show');
                }

            });
        };

        $scope.hideModalMessage = function () {
            setTimeout("$('#modalMessage').modal('hide')", 3000);
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

        $('.datepicker').datetimepicker({
            viewMode: 'years',
            locale: 'es',
            format: 'YYYY'
        }).on('dp.change', function (e) {
            $scope.getAreaCaudal();
        });

    });

/*$(document).ready(function () {



});*/


