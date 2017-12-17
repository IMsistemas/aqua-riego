

app.controller('centroCostoController', function($scope, $http, API_URL) {

    $scope.centrocostos = [];
    $scope.id = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'centrocosto/getCentroCostos').success(function (response) {
            $scope.centrocostos = response.data;
        });
    };

    $scope.viewModalAdd = function () {

        $scope.id = 0;
        $scope.namecentrocosto = '';
        $scope.observacion = '';

        $scope.title_modal = 'Nuevo Centro Costo';

        $('#modalNueva').modal('show');

    };

    $scope.save = function () {

        var data = {
            namecentrocosto: $scope.namecentrocosto,
            observacion: $scope.observacion
        };

        if ($scope.id === 0) {

            $http.post(API_URL + 'centrocosto', data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.initLoad();
                    $scope.message = 'Se insertó correctamente el Centro de Costo';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar guardar un Centro de Costo...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        } else {

            $http.put(API_URL + 'centrocosto/' + $scope.id, data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.idcanal_del = 0;
                    $scope.initLoad();
                    $scope.message = 'Se editó correctamente el Centro de Costo seleccionado';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar editar un Centro de Costo...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        }

    };

    $scope.showModalDelete = function (item) {
        $scope.id = item.idcentrocosto;
        $scope.nom = item.namecentrocosto;
        $('#modalDelete').modal('show');
    };

    $scope.showModalEdit = function (item) {
        $scope.id = item.idcentrocosto;
        $scope.namecentrocosto = item.namecentrocosto;
        $scope.observacion = item.observacion;

        $scope.title_modal = 'Editar Canal';

        $('#modalNueva').modal('show');
    };

    $scope.delete = function(){

        $http.delete(API_URL + 'centrocosto/' + $scope.id).success(function(response) {
            $('#modalDelete').modal('hide');

            if(response.success === true){

                $scope.initLoad();
                $scope.id = 0;
                $scope.message = 'Se eliminó correctamente el Centro Costo seleccionado...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();

            } else if(response.success === false) {

                if (response.msg === 'exist_derivacion') {

                    $scope.message_error = 'El Centro Costo no puede ser eliminado porque está presente en Transacciones...';

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar eliminar un Centro Costo...';

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