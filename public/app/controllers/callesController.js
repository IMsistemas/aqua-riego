app.controller('callesController', function($scope, $http, API_URL) {

    $scope.calles = [];

    $scope.initLoad = function () {
        $http.get(API_URL + 'calle/getCalles').success(function (response) {
            console.log(response);

            $scope.calles = response;

        });
    };

    $scope.viewModalAdd = function () {

        $http.get(API_URL + 'calle/getBarrio').success(function (response) {
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios = array_temp;


        });

        $http.get(API_URL + 'calle/getLastID').success(function(response){
            console.log(response);

            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrebarrio = '';
            $scope.observacionBarrio = '';

            $('#modalNueva').modal('show');
        });

    }


    $scope.saveCalle = function () {
        var data = {
            nombrecalle: $scope.nombrecalle,
            idbarrio: $scope.t_barrio,
            observacion: $scope.observacionCalle
        };

        $http.post(API_URL + 'calle', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente la Toma';
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