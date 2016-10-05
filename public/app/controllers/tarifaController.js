
app.controller('tarifaController', function($scope, $http, API_URL) {

    $scope.showModal = function () {
        var now = new Date();
        $scope.year_ingreso = now.getFullYear();

        $http.get(API_URL + 'tarifa/getLastID').success(function(response){

            $scope.idtarifa = response.id;
        });

        $('#modalTarifa').modal('show');
    };

    $scope.saveTarifa = function () {

        var data = {
            nombretarifa: $scope.nombretarifa
        };

        $http.post(API_URL + 'tarifa', data ).success(function (response) {

            console.log(response);

            $('#modalTarifa').modal('show');
            /*$scope.message = 'Se insertó correctamente el Cargo';
            $('#modalMessage').modal('show');*/

        }).error(function (res) {

        });
    };

});