
app.controller('tarifaController', function($scope, $http, API_URL) {

    $scope.area_caudal = [];
    $scope.constante = 0;

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
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
        });
    };

    $scope.getAreaCaudal = function() {
        var idtarifa = $scope.t_tarifa;

        $http.get(API_URL + 'tarifa/getAreaCaudal/' + idtarifa).success(function(response){
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
        });
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

    $scope.initData();

});