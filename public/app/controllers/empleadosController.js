
app.controller('empleadosController', function($scope, $http, API_URL, Upload) {

    $scope.empleados = [];
    $scope.empleado_del = 0;
    $scope.idpersona = 0;
    $scope.id = 0;

    $scope.select_cuenta = null;

    $scope.initLoad = function(verifyPosition){

        if (verifyPosition != undefined){
            $scope.searchPosition();
        }

        $http.get(API_URL + 'empleado/getEmployees').success(function(response){
            var longitud = response.length;
            for (var i = 0; i < longitud; i++) {
                var complete_name = {
                    value: response[i].namepersona + ' ' + response[i].lastnamepersona,
                    writable: true,
                    enumerable: true,
                    configurable: true
                };
                Object.defineProperty(response[i], 'complete_name', complete_name);
            }
            $scope.empleados = response;

        });

    };

    $scope.searchPosition = function(){
        $http.get(API_URL + 'empleado/getAllPositions').success(function(response){
            var longitud = response.length;
            if(longitud == 0){
                $('#btnAgregar').prop('disabled', true);
                $('#message-positions').show();
            } else {
                $('#btnAgregar').prop('disabled', false);
                $('#message-positions').hide();
            }
        });
    };

    $scope.toggle = function(modalstate, item) {
        $scope.modalstate = modalstate;
        switch (modalstate) {
            case 'add':

                $http.get(API_URL + 'empleado/getDepartamentos').success(function(response){
                    var longitud = response.length;
                    var array_temp = [{label: '-- Seleccione --', id: 0}];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].namedepartamento, id: response[i].iddepartamento})
                    }
                    $scope.iddepartamentos = array_temp;
                    $scope.departamento = 0;
                });

                $http.get(API_URL + 'empleado/getTipoIdentificacion').success(function(response){
                    var longitud = response.length;
                    var array_temp = [{label: '-- Seleccione --', id: 0}];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].nameidentificacion, id: response[i].idtipoidentificacion})
                    }
                    $scope.idtipoidentificacion = array_temp;
                    $scope.tipoidentificacion = 0;
                });

                $http.get(API_URL + 'empleado/getAllPositions').success(function(response){
                    var longitud = response.length;
                    var array_temp = [{label: '-- Seleccione --', id: 0}];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].namecargo, id: response[i].idcargo})
                    }
                    $scope.idcargos = array_temp;
                    $scope.idcargo = 0;

                    $scope.documentoidentidadempleado = '';
                    $scope.apellido = '';
                    $scope.nombre = '';
                    $scope.telefonoprincipal = '';
                    $scope.telefonosecundario = '';
                    $scope.celular = '';
                    $scope.direccion = '';
                    $scope.correo = '';
                    $scope.salario = '';

                    $scope.fechaingreso = fecha();

                    $scope.form_title = "Ingresar Nuevo Colaborador";

                    $scope.url_foto = 'img/empleado.png';

                    $('#modalAction').modal('show');
                });

                break;
            case 'edit':
                $scope.form_title = "Editar Colaborador";
                $scope.id = item.idempleado;

                $http.get(API_URL + 'empleado/getDepartamentos').success(function(response){
                    var longitud = response.length;
                    var array_temp = [{label: '-- Seleccione --', id: 0}];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].namedepartamento, id: response[i].iddepartamento})
                    }
                    $scope.iddepartamentos = array_temp;
                    $scope.departamento = 0;
                });

                $http.get(API_URL + 'empleado/getTipoIdentificacion').success(function(response){
                    var longitud = response.length;
                    var array_temp = [{label: '-- Seleccione --', id: 0}];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].nameidentificacion, id: response[i].idtipoidentificacion})
                    }
                    $scope.idtipoidentificacion = array_temp;
                    $scope.tipoidentificacion = 0;
                });

                $http.get(API_URL + 'empleado/getAllPositions').success(function(response){
                    var longitud = response.length;
                    var array_temp = [];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].namecargo, id: response[i].idcargo})
                    }
                    $scope.idcargos = array_temp;

                     // $scope.fechaingreso = item.fechaingreso;

                    $scope.fechaingreso = convertDatetoDB(item.fechaingreso, true);
                    $scope.documentoidentidadempleado = item.numdocidentific;
                    $scope.idcargo = item.idcargo;
                    $scope.apellido = item.lastnamepersona;
                    $scope.nombre = item.namepersona;
                    $scope.telefonoprincipal = item.telefprincipaldomicilio;
                    $scope.telefonosecundario = item.telefsecundariodomicilio;
                    $scope.celular = item.celphone;
                    $scope.direccion = item.direcciondomicilio;
                    $scope.correo = item.email;
                    $scope.salario = item.salario;

                    $scope.idpersona = item.idpersona;

                    if (item.rutafoto != null && item.rutafoto != ''){
                        $scope.url_foto = item.rutafoto;
                    } else {
                        $scope.url_foto = 'img/empleado.png';
                    }


                    $scope.departamento = item.iddepartamento;

                    $scope.cuenta_employee = item.idplancuenta;

                    $scope.tipoidentificacion = item.idtipoidentificacion;

                    $('#modalAction').modal('show');
                });
                break;

            case 'info':

                $scope.name_employee = item.complete_name;
                $scope.cargo_employee = item.namecargo;
                $scope.date_registry_employee = convertDatetoDB(item.fechaingreso, true);
                //$scope.date_registry_employee = response[0].fechaingreso;
                $scope.phones_employee = item.telefprincipaldomicilio + '/' + item.telefsecundariodomicilio;
                $scope.cel_employee = item.celphone;
                $scope.address_employee = item.direcciondomicilio;
                $scope.email_employee = item.email;
                $scope.salario_employee = item.salario;



                if (item.rutafoto != null && item.rutafoto != ''){
                    $scope.url_foto = item.rutafoto;
                } else {
                    $scope.url_foto = 'img/empleado.png';
                }

                $('#modalInfoEmpleado').modal('show');

                break;

            default:
                break;
        }
    };

    $scope.save = function() {
        var url = API_URL + "empleado";
        var method = 'POST';

        if ($scope.modalstate == 'edit'){
            url += "/updateEmpleado/" + $scope.id;
        }

        var fechaingreso = $('#fechaingreso').val();

        var data ={
            fechaingreso: convertDatetoDB(fechaingreso),
            idcargo: $scope.idcargo,
            apellidos: $scope.apellido,
            nombres: $scope.nombre,
            telefonoprincipaldomicilio: $scope.telefonoprincipal,
            telefonosecundariodomicilio: $scope.telefonosecundario,
            celular: $scope.celular,
            direcciondomicilio: $scope.direccion,
            correo: $scope.correo,
            salario: $scope.salario,
            file: $scope.file,
            documentoidentidadempleado: $scope.documentoidentidadempleado,

            idpersona:  $scope.idpersona,

            departamento: $scope.departamento,
            tipoidentificacion: $scope.tipoidentificacion,
            cuentacontable: $scope.cuenta_employee
        };

        Upload.upload({
            url: url,
            method: method,
            data: data
        }).success(function(data, status, headers, config) {
            if (data.success == true) {
                $scope.idpersona = 0;

                $scope.initLoad();
                $scope.message = 'Se guardó correctamente la información del Colaborador...';
                $('#modalAction').modal('hide');
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }
            else {
                $('#modalAction').modal('hide');
                $scope.message_error = 'Ya existe ese Colaborador...';
                $('#modalMessageError').modal('show');
            }
        });

    };

    $scope.showModalConfirm = function(item){
        $scope.empleado_del = item.idempleado;
        $scope.empleado_seleccionado = item.namepersona + ' ' + item.lastnamepersona;
        $('#modalConfirmDelete').modal('show');
    };

    $scope.destroy = function(){
        $http.delete(API_URL + 'empleado/' + $scope.empleado_del).success(function(response) {
            $scope.initLoad(1);
            $('#modalConfirmDelete').modal('hide');
            $scope.empleado_del = 0;
            $scope.message = 'Se eliminó correctamente el Colaborador seleccionado';
            $('#modalMessage').modal('show');
            $scope.hideModalMessage();
        });
    };

    $scope.showPlanCuenta = function () {

        $http.get(API_URL + 'empleado/getPlanCuenta').success(function(response){
            console.log(response);
            $scope.cuentas = response;
            $('#modalPlanCuenta').modal('show');
        });

    };

    $scope.selectCuenta = function () {
        var selected = $scope.select_cuenta;

        $scope.cuenta_employee = selected.concepto;

        $('#modalPlanCuenta').modal('hide');
    };

    $scope.click_radio = function (item) {
        $scope.select_cuenta = item;
    };

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };

    $scope.initLoad(true);

    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY'
    });

});



$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function fecha(){
    var f = new Date();
    var fecha = "";
    var dd = f.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = f.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;
    var yyyy = f.getFullYear();
    fecha = dd + "\/" + mm + "\/" + yyyy;

    return fecha;
}

function convertDatetoDB(now, revert){
    if (revert == undefined){
        var t = now.split('/');
        return t[2] + '-' + t[1] + '-' + t[0];
    } else {
        var t = now.split('-');
        return t[2] + '/' + t[1] + '/' + t[0];
    }
}
