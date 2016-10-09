
app.controller('barrioController', function($scope, $http, API_URL) {

    $scope.barrios = [];

    $scope.initLoad = function () {
        $http.get(API_URL + 'barrio/getBarrios').success(function(response){
            console.log(response);

            $scope.barrios = response;

        });
    };

    $scope.viewModalAdd = function () {

        $http.get(API_URL + 'barrio/getParroquias').success(function(response){
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombreparroquia, id: response[i].idparroquia})
            }
            $scope.parroquias = array_temp;
        });


        $http.get(API_URL + 'barrio/getLastID').success(function(response){
            console.log(response);

            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrebarrio = '';
            $scope.observacionBarrio = '';

            $('#modalNueva').modal('show');
        });


    };

    $scope.saveBarrio = function () {
        var data = {
            nombrebarrio: $scope.nombrebarrio,
            idparroquia: $scope.t_parroquias,
            observacion: $scope.observacionBarrio
        };

        $http.post(API_URL + 'barrio', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente la Junta Modular';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };


    $scope.initLoad();

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