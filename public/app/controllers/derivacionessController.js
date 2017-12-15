

app.controller('derivacionessController', function($scope, $http, API_URL) {

    $scope.derivacions = [];
    $scope.idderiv_del = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'derivaciones/getDerivaciones').success(function (response) {
           $scope.derivacions = response;
        });
    };

    $scope.viewModalAdd = function () {

        $scope.idderiv_del = 0;
        $scope.nombrederi = '';
        $scope.observacionderi = '';

        $scope.title_modal = 'Nueva Derivación';

        $('#modalNueva').modal('show');

    };

    $scope.saveDeri = function () {

        var data = {
            nombrederivacion: $scope.nombrederi,
            observacion: $scope.observacionderi
        };

        if ($scope.idderiv_del === 0) {

            $http.post(API_URL + 'derivaciones', data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.initLoad();
                    $scope.message = 'Se insertó correctamente la Derivación';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar guardar una Derivación...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        } else {

            $http.put(API_URL + 'derivaciones/' + $scope.idderiv_del, data ).success(function (response) {

                $('#modalNueva').modal('hide');

                if (response.success === true) {

                    $scope.idderiv_del = 0;
                    $scope.initLoad();
                    $scope.message = 'Se editó correctamente la Derivación seleccionada';
                    $('#modalMessage').modal('show');

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar editar una Derivación...';
                    $('#modalMessageError').modal('show');

                }

                $scope.hideModalMessage();

            }).error(function (res) {

            });

        }

    };

    $scope.showModalDelete = function (item) {
        $scope.idderiv_del = item.idderivacion;
        $scope.nom_deriv = item.nombrederivacion;
        $('#modalDelete').modal('show');
    };

    $scope.showModalEdit = function (item) {
        $scope.idderiv_del = item.idderivacion;
        $scope.nombrederi = item.nombrederivacion;
        $scope.observacionderi = item.observacion;

        $scope.title_modal = 'Editar Derivación';

        $('#modalNueva').modal('show');
    };

    $scope.delete = function(){

        $http.delete(API_URL + 'derivaciones/' + $scope.idderiv_del).success(function(response) {

            $('#modalDelete').modal('hide');

            if(response.success === true){

                $scope.initLoad();
                $scope.idderiv_del = 0;
                $scope.message = 'Se eliminó correctamente la Derivación seleccionada...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();

            } else if(response.success === false) {

                if (response.msg === 'exist_derivacion') {

                    $scope.message_error = 'La Derivación no puede ser eliminada porque está presente en un Terreno...';

                } else {

                    $scope.message_error = 'Ha ocurrido un error al intentar eliminar una Derivación...';

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