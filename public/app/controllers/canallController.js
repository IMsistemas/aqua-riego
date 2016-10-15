app.controller('canallController', function($scope, $http, API_URL) {

    $scope.canals = [];
    $scope.idcanal_del = 0;


    $scope.initLoad = function () {
        $http.get(API_URL + 'canal/getCanall').success(function (response) {
            console.log(response);
            $scope.canals = response;
        });
    };


    $scope.FiltroCalle = function () {
        $http.get(API_URL + 'canal/getCalles').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--Tomas--', id: 0}];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calless = array_temp;
            $scope.t_calle = 0;
        });
    };

    $scope.FiltroBarrio = function () {
        $http.get(API_URL + 'canal/getBarrios').success(function (response) {
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
        $http.get(API_URL + 'canal/getCalle').success(function (response) {
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calles = array_temp;
        });
        $http.get(API_URL + 'canal/getLastID').success(function(response){
            console.log(response);

            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrecanal = '';
            $scope.observacionCanal = '';

            $('#modalNueva').modal('show');
        });

    }

    $scope.saveCanal = function () {
        var data = {
            nombrecanal: $scope.nombrecanal,
            idcalle: $scope.t_calle,
            observacion: $scope.observacionCanal
        };

        $http.post(API_URL + 'canal', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente el Canal';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };

    $scope.showModalDelete = function (item) {
        $scope.idcanal_del = item.idcanal;
        $scope.nom_canal = item.nombrecanal;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){
        $http.delete(API_URL + 'canal/' + $scope.idcanal_del).success(function(response) {
            $('#modalDelete').modal('hide');
            if(response.success == true){
                console.log(response);
                $scope.initLoad();
                $scope.idcanal_del = 0;
                $scope.message = 'Se elimino correctamente el Canal seleccionado...';
                $('#modalMessage').modal('show');
            } else if(response.success == false && response.msg == 'exist_derivacion') {
                $scope.message_error = 'El Canal no puede ser eliminado porque contiene Derivaciones...';
                $('#modalMessageError').modal('show');
            }
        });

    };

    $scope.showModalInfo = function (item) {
        $scope.name_canal = item.nombrecanal;
        $scope.fecha_ingreso = item.fechaingreso;

        var array_derivaciones = item.derivacion;
        var text = '';
        for(var i  = 0; i < array_derivaciones.length; i++){
            text += array_derivaciones[i].nombrederivacion + ',';
        }
        $scope.canal_derivacion = text;

        $('#modalInfo').modal('show');


    };

    $scope.editar = function ()  {
        var arr_canales = { arr_canales: $scope.canals };

        $http.post(API_URL + 'canal/editar_canal', arr_canales).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente los Canales';
            $('#modalMessage').modal('show');
        });
    };



    $scope.initLoad();
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