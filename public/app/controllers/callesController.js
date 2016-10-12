app.controller('callesController', function($scope, $http, API_URL) {

    $scope.calles = [];
    $scope.idcalle_del = 0;

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

            $scope.nombrecalle = '';
            $scope.observacionCalle = '';

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

    $scope.showModalDelete = function (item) {
        $scope.idcalle_del = item.idcalle;
        $scope.nom_calle = item.nombrecalle;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){
       /* $http.delete(API_URL + 'calle/' + $scope.idcalle_del).success(function(response) {
            $scope.initLoad();
            $('#modalDelete').modal('hide');
            $scope.idcalle_del = 0;
            $scope.message = 'Se elimino correctamente la Toma seleccionada...';
            $('#modalMessage').modal('show');
        });*/

        $http.delete(API_URL + 'calle/' + $scope.idcalle_del).success(function(response) {
            $('#modalDelete').modal('hide');
            if(response.success == true){
                console.log(response);
                $scope.initLoad();
                $scope.idcalle_del = 0;
                $scope.message = 'Se elimino correctamente la Toma seleccionada...';
                $('#modalMessage').modal('show');
            } else if(response.success == false && response.msg == 'exist_canales') {
                $scope.message_error = 'La Toma no puede ser eliminado porque contiene Canales...';
                $('#modalMessageError').modal('show');
            }
        });

    };

    $scope.showModalInfo = function (item) {
        $scope.name_calle = item.nombrecalle;
        $scope.fecha_ingreso = item.fechaingreso;

        var array_canal = item.canal;
        var text = '';
        for(var i  = 0; i < array_canal.length; i++){
            text += array_canal[i].nombrecanal + ',';
        }
        $scope.calle_canales = text;

        $('#modalInfo').modal('show');


    };

    $scope.editar = function ()  {
        var arr_calle = { arr_calle: $scope.calles };

        $http.post(API_URL + 'calle/editar_calle', arr_calle).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Tomas';
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