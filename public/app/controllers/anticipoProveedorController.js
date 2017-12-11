

app.controller('anticipoProveedorController', function($scope, $http, API_URL) {

    $scope.select_cuenta = null;

    $scope.pageChanged = function(newPage) {
        $scope.initLoad(newPage);
    };

    $scope.initLoad = function(pageNumber){

        $('.datepicker').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD'
        });

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };

        $http.get(API_URL + 'anticipoproveedor/getAnticipos?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).
        success(function(response){
            $scope.anticipos = response.data;
            $scope.totalItems = response.total;
        });
    };

    $scope.showPlanCuenta = function () {

        $http.get(API_URL + 'empleado/getPlanCuenta').success(function(response){
            $scope.cuentas = response;
            $('#modalPlanCuenta').modal('show');
        });

    };

    $scope.selectCuenta = function () {
        var selected = $scope.select_cuenta;

        $scope.idplancuenta = selected.concepto;

        $('#modalPlanCuenta').modal('hide');
    };

    $scope.click_radio = function (item) {
        $scope.select_cuenta = item;
    };

    $scope.getFormaPago = function () {
        $http.get(API_URL + 'DocumentoCompras/getFormaPago').success(function(response){

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for (var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nameformapago, id: response[i].idformapago})
            }

            $scope.listformapago = array_temp;
            $scope.idformapago = array_temp[0].id;

        });
    };

    $scope.getCentroCosto = function () {
        $http.get(API_URL + 'DocumentoVenta/getCentroCosto').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namedepartamento, id: response[i].iddepartamento})
            }
            $scope.listdepartamento = array_temp;
            $scope.iddepartamento = '';
        });
    };

    $scope.createAnticipo = function () {

        $('#modalAction').modal('show');

    };

    $scope.save = function (){

        var centrocosto = false;

        if ($scope.centrocosto === "true") {
            centrocosto = true;
        }

        var data = {
            namedepartamento: $scope.nombrecargo,
            centrocosto: centrocosto
        };

        switch ( $scope.modalstate) {
            case 'add':
                $http.post(API_URL + 'departamento', data ).success(function (response) {
                    if (response.success == true) {
                        $scope.initLoad(1);
                        $('#modalActionCargo').modal('hide');
                        $scope.message = 'Se insertó correctamente el Departamento...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();
                    }
                    else {
                        $('#modalActionCargo').modal('hide');
                        $scope.message_error = 'Ya existe ese Departamento...';
                        $('#modalMessageError').modal('show');
                    }
                });
                break;
            case 'edit':
                $http.put(API_URL + 'departamento/'+ $scope.idc, data ).success(function (response) {

                    if (response.success == true) {
                        $scope.initLoad(1);
                        $('#modalActionCargo').modal('hide');
                        $scope.message = 'Se editó correctamente el Departamento seleccionado';
                        $('#modalMessage').modal('show');
                    } else {
                        if (response.repeat == true) {
                            $scope.message_error = 'Ya existe ese Departamento...';
                        } else {
                            $scope.message_error = 'Ha ocurrido un error al intentar editar el departamento seleccionado...';
                        }
                        $('#modalMessageError').modal('show');
                    }

                    $scope.hideModalMessage();
                }).error(function (res) {

                });
                break;
        }
    };

    $scope.showModalConfirm = function (departamento) {
        $scope.idcargo_del = departamento.iddepartamento;
        $scope.cargo_seleccionado = departamento.namedepartamento;
        $('#modalConfirmDelete').modal('show');
    };

    $scope.delete = function(){
        $http.delete(API_URL + 'departamento/' + $scope.idcargo_del).success(function(response) {
            if(response.success == true){
                $scope.initLoad(1);
                $('#modalConfirmDelete').modal('hide');
                $scope.idcargo_del = 0;
                $scope.message = 'Se eliminó correctamente el Departamento seleccionado...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();

            } else {

                if (response.exists == true) {
                    $scope.message_error = 'El Departamento no puede ser eliminado porque esta asignado a un Cargo...';
                } else {
                    $scope.message_error = 'Ha ocurrido un error al intentar eliminar el departamento seleccionado...';
                }

                $('#modalMessageError').modal('show');
                //$('#modalConfirmDelete').modal('hide');
            }
        });

    };

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };


    $scope.getFormaPago();
    $scope.getCentroCosto();
});
