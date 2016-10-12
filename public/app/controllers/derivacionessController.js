app.controller('derivacionessController', function($scope, $http, API_URL) {

    $scope.derivacions = [];
    $scope.idderiv_del = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'derivaciones/getDerivaciones').success(function (response) {
           $scope.derivacions = response;

        });
    };

    $scope.FiltroCanal = function () {
        $http.get(API_URL + 'derivaciones/getCanaless').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--Canales--', id: 0}];
            //var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canaless = array_temp;
        });
    };

    $scope.FiltroCalle = function () {
        $http.get(API_URL + 'derivaciones/getCalles').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--Tomas--', id: 0}];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calless = array_temp;
        });
    };

    $scope.FiltroBarrio = function () {
        $http.get(API_URL + 'derivaciones/getBarrios').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--Juntas Modulares--', id: 0}];

            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrioss = array_temp;
        });
    };

    $scope.viewModalAdd = function () {

        $http.get(API_URL + 'derivaciones/getCanales').success(function (response) {
            console.log(response);
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canals = array_temp;
        });

        $http.get(API_URL + 'derivaciones/getLastID').success(function(response){
            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrederi = '';
            $scope.observacionderi = '';

            $('#modalNueva').modal('show');
        });

    }

    $scope.saveDeri = function () {
        var data = {
            nombrederivacion: $scope.nombrederi,
            observacion: $scope.observacionderi,
            idcanal: $scope.t_canal
        };
        $http.post(API_URL + 'derivaciones', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente la Derivacion';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };

    $scope.editar = function ()  {
        var arr_deri = { arr_deri: $scope.derivacions };

        $http.post(API_URL + 'derivaciones/editar_derivaciones', arr_deri).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Derivaciones';
            $('#modalMessage').modal('show');
        });
    };

    $scope.showModalDelete = function (item) {
        $scope.idderiv_del = item.idderivacion;
        $scope.nom_deriv = item.nombrederivacion;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){
        $http.delete(API_URL + 'derivaciones/' + $scope.idderiv_del).success(function(response) {
            $scope.initLoad();
            $('#modalDelete').modal('hide');
            $scope.idderiv_del = 0;
            $scope.message = 'Se elimino correctamente la Derivacion seleccionada...';
            $('#modalMessage').modal('show');
        });
    };

    $scope.editar = function ()  {
        var arr_deriva = { arr_deriva: $scope.derivacions };

        $http.post(API_URL + 'derivaciones/editar_derivaciones', arr_deriva).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Derivaciones';
            $('#modalMessage').modal('show');
        });
    };


    $scope.initLoad();
    $scope.FiltroCanal();
    $scope.FiltroCalle();
    $scope.FiltroBarrio();

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