
app.controller('barrioController', function($scope, $http, API_URL) {

    $scope.barrios = [];
    $scope.idbarrio_del = 0;

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

    $scope.showModalInfo = function (item) {
        $scope.name_junta = item.nombrebarrio;
        $scope.fecha_ingreso = item.fechaingreso;

        var array_tomas = item.calle;
        var text = '';
        for(var i  = 0; i < array_tomas.length; i++){
            text += array_tomas[i].nombrecalle + ',';
        }
        $scope.junta_tomas = text;

        $('#modalInfo').modal('show');


    };

    $scope.showModalDelete = function (item) {
        $scope.idbarrio_del = item.idbarrio;
        $scope.nom_junta_modular = item.nombrebarrio;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){
        $http.delete(API_URL + 'barrio/' + $scope.idbarrio_del).success(function(response) {
            $scope.initLoad();
            $('#modalDelete').modal('hide');
            $scope.idbarrio_del = 0;
            $scope.message = 'Se elimino correctamente la Junta Modular seleccionada...';
            $('#modalMessage').modal('show');
        });
    };

    $scope.saveCalle = function () {
        var data = {
            nombrecalle: $scope.nombrecalle,
            idbarrio: $scope.id_barrio,
            observacion: $scope.observacionCalle
        };

        $http.post(API_URL + 'calle', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNuevaToma').modal('hide');
            $scope.message = 'Se insertó correctamente la Toma';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };

    $scope.show_toma = function (idbarrio)   {
        $http.get(API_URL + 'calle/getBarrio').success(function (response) {
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios2 = array_temp;
            $scope.id_barrio = idbarrio;
        });
        $http.get(API_URL + 'calle/getLastID').success(function(response){
            console.log(response);

            $scope.codigo_toma = response.id;
            $scope.date_ingreso_toma = now();

            $scope.nombrecalle = '';
            $scope.observacionCalle = '';

            $('#modalNuevaToma').modal('show');
        });
    };

    $scope.saveCalle = function () {
        var data = {
            nombrecalle: $scope.nombrecalle,
            idbarrio: $scope.id_barrio,
            observacion: $scope.observacionCalle
        };

        $http.post(API_URL + 'calle', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNuevaToma').modal('hide');
            $scope.message = 'Se insertó correctamente la Toma';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };

    $scope.editar = function ()  {
        var arr_barrio = { arr_barrio: $scope.barrios };
        console.log(arr_barrio);
        $http.post(API_URL + 'barrio/editar_Barrio', arr_barrio).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Juntas Modulares';
            $('#modalMessage').modal('show');
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