

app.controller('anticipoProveedorController', function($scope, $http, API_URL) {

    $scope.select_cuenta = null;
    $scope.proveedor = null;

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

    $scope.autoAssignDate = function () {

        $scope.fecha = $('#fecha').val();

    };

    $scope.showDataProveedor = function (object) {

        if (object != undefined && object.originalObject != undefined) {

            console.log(object);

            /*$scope.razon = object.originalObject.razonsocial;
            $scope.direccion = object.originalObject.direccion;
            $scope.telefono = object.originalObject.proveedor[0].telefonoprincipal;
            $scope.iva = object.originalObject.proveedor[0].sri_tipoimpuestoiva.nametipoimpuestoiva;*/

            $scope.proveedor = object;

        }

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

        var Transaccion = {
            fecha: $('#fecha').val(),
            idtipotransaccion: 13,
            numcomprobante: 1,
            descripcion: $scope.observacion
        };

        var RegistroC = [];

        var proveedor = {
            idplancuenta: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.idplancuenta,
            concepto: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.concepto,
            controlhaber: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.controlhaber,
            tipocuenta: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.tipocuenta,
            Debe: parseFloat($scope.monto),
            Haber: 0,
            Descipcion: $scope.observacion
        };

        RegistroC.push(proveedor);

        var pago = {
            idplancuenta: $scope.select_cuenta.idplancuenta,
            concepto: $scope.select_cuenta.concepto,
            controlhaber: $scope.select_cuenta.controlhaber,
            tipocuenta: $scope.select_cuenta.tipocuenta,
            Debe: 0,
            Haber: parseFloat($scope.monto),
            Descipcion: $scope.observacion
        };

        RegistroC.push(pago);

        var Contabilidad = {
            transaccion: Transaccion,
            registro: RegistroC
        };

        var transaccion_venta_full = {
            DataContabilidad: Contabilidad
        };

        var data = {
            fecha: $scope.fecha,
            monto: $scope.monto,
            idproveedor: $scope.proveedor.originalObject.proveedor[0].idproveedor,
            idformapago: $scope.idformapago,
            idplancuenta: $scope.select_cuenta.idplancuenta,
            observacion: $scope.observacion,
            contabilidad: JSON.stringify(transaccion_venta_full)
        };

        console.log(data);

        //console.log($scope.select_cuenta);

        $http.post(API_URL + 'anticipoproveedor', data ).success(function (response) {

            $('#modalAction').modal('hide');

            if (response.success === true) {
                $scope.initLoad(1);


                $scope.message = 'Se insertó correctamente el Anticiop...';
                $('#modalMessage').modal('show');
                //$scope.hideModalMessage();
            }
            else {
                $scope.message_error = 'Ha ocurrido un error...';
                $('#modalMessageError').modal('show');
            }
        });

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
