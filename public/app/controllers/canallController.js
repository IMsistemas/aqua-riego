

app.controller('canallController', function($scope, $http, API_URL) {

    $scope.canals = [];
    $scope.idcanal_del = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'canal/getCanall').success(function (response) {
            $scope.canals = response;
        });
    };

    $scope.viewModalAdd = function () {

        $scope.idcanal_del = 0;
        $scope.nombrecanal = '';
        $scope.observacionCanal = '';

        $scope.title_modal = 'Nuevo Canal';

        $('#modalNueva').modal('show');

    };

    $scope.saveCanal = function () {

        var data = {
            nombrecanal: $scope.nombrecanal,
            observacion: $scope.observacionCanal
        };

        if ($scope.idcanal_del === 0) {

            $http.post(API_URL + 'canal', data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.initLoad();
                    $scope.message = 'Se insertó correctamente el Canal';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar guardar un Canal...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        } else {

            $http.put(API_URL + 'canal/' + $scope.idcanal_del, data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.idcanal_del = 0;
                    $scope.initLoad();
                    $scope.message = 'Se editó correctamente el Canal seleccionado';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar editar un Canal...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        }

    };

    $scope.showModalDelete = function (item) {
        $scope.idcanal_del = item.idcanal;
        $scope.nom_canal = item.nombrecanal;
        $('#modalDelete').modal('show');
    };

    $scope.showModalEdit = function (item) {
        $scope.idcanal_del = item.idcanal;
        $scope.nombrecanal = item.nombrecanal;
        $scope.observacionCanal = item.observacion;

        $scope.title_modal = 'Editar Canal';

        $('#modalNueva').modal('show');
    };

    $scope.delete = function(){

        $http.delete(API_URL + 'canal/' + $scope.idcanal_del).success(function(response) {
            $('#modalDelete').modal('hide');

            if(response.success === true){

                $scope.initLoad();
                $scope.idcanal_del = 0;
                $scope.message = 'Se eliminó correctamente el Canal seleccionado...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();

            } else if(response.success === false) {

                if (response.msg === 'exist_derivacion') {

                    $scope.message_error = 'El Canal no puede ser eliminado porque está presente en un Terreno...';

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar eliminar un Canal...';

                }

                $('#modalMessageError').modal('show');
            }
        });

    };

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };

    $scope.initLoad();

});

function convertDatetoDB(now, revert){
    if (revert === undefined){
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