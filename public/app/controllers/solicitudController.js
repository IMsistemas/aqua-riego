
app.controller('solicitudController', function($scope, $http, API_URL) {

    $scope.solicitudes = [];

    $scope.initLoad = function () {
        $http.get(API_URL + 'solicitud/getSolicitudes').success(function(response){
            $scope.solicitudes = response;
        });
    };

    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':

                /*$http.get(API_URL + 'cargo/lastId').success(function(response){

                    $scope.idcargo = response.lastId;
                    $scope.form_title = "Ingresar nuevo Cargo";
                    $scope.nombrecargo = '';
                    $('#modalActionCargo').modal('show');
                });*/

                $('#modalIngSolicitud').modal('show');

                break;
            case 'edit':
                $scope.form_title = "Editar Cargo";
                $scope.id = id;

                $http.get(API_URL + 'cargo/' + id).success(function(response) {
                    $scope.idcargo = (response.idcargo).trim();
                    $scope.nombrecargo = (response.nombrecargo).trim();
                    $('#modalActionCargo').modal('show');
                });

                break;
            default:
                break;
        }


    };

});