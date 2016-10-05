
app.controller('tarifaController', function($scope, $http, API_URL) {

    $scope.initData = function () {
        $scope.getTarifas();
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
            console.log(response);

            $scope.area_caudal = response[0].area;
        });
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

    $scope.initData();

});