
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

                var now = new Date();
                var dd = now.getDate();
                if (dd < 10) dd = '0' + dd;
                var mm = now.getMonth() + 1;
                if (mm < 10) mm = '0' + mm;
                var yyyy = now.getFullYear();

                $scope.t_fecha_ingreso = dd + "\/" + mm + "\/" + yyyy;

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

    $scope.save = function () {

        var url = API_URL + "solicitud";

        var data = {
            fechaingreso: convertDatetoDB($scope.t_fecha_ingreso),
            codigocliente: $scope.t_doc_id,
            apellido: $scope.t_apellidos,
            nombre: $scope.t_nombres,
            telefonoprincipal: $scope.t_telf_principal,
            telefonosecundario: $scope.t_telf_secundario,
            celular: $scope.t_celular,
            direccion: $scope.t_direccion,
            telfprincipalemp: $scope.t_telf_principal_emp,
            telfsecundarioemp: $scope.t_telf_secundario_emp,
            direccionemp: $scope.t_direccion_emp
        };

        $http.post(url, data ).success(function (response) {
            $scope.initLoad();
            $('#modalIngSolicitud').modal('hide');

        }).error(function (res) {
            console.log(res);
        });

    };

    $scope.initLoad();
});

$(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY'
    });

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

function isOnlyNumberPto(field, e, length) {
    var valor = document.getElementById(field.id);
    if (length != undefined) {
        if (valor.length == length) return false;
    }
    if (valor != undefined) {
        var k = (document.all) ? e.keyCode : e.which;
        if (k == 8 || k == 0) return true;
        var patron = /\d/;
        var n = String.fromCharCode(k);
        if (n == ".") {
            if (valor.indexOf('.') != -1 || valor.length < 0) {
                return false;
            } else return true;
        } else return patron.test(n);
    }
}