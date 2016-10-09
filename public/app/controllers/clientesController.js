

app.controller('clientesController', function($scope, $http, API_URL) {

    $scope.clientes = [];
    $scope.codigocliente_del = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'cliente/getClientes').success(function(response){
            $scope.clientes = response;
        });
    };

    $scope.nowDate = function () {
        var now = new Date();
        var dd = now.getDate();
        if (dd < 10) dd = '0' + dd;
        var mm = now.getMonth() + 1;
        if (mm < 10) mm = '0' + mm;
        var yyyy = now.getFullYear();
        return dd + "\/" + mm + "\/" + yyyy;
    };

    $scope.convertDatetoDB = function (now, revert) {
        if (revert == undefined){
            var t = now.split('/');
            return t[2] + '-' + t[1] + '-' + t[0];
        } else {
            var t = now.split('-');
            return t[2] + '/' + t[1] + '/' + t[0];
        }
    };

    $scope.edit = function (item) {
        $scope.t_codigocliente = item.codigocliente;
        $scope.t_fecha_ingreso = $scope.convertDatetoDB(item.fechaingreso, true);
        $scope.t_doc_id = item.documentoidentidad;
        $scope.t_email = item.correo;
        $scope.t_apellidos = item.apellido;
        $scope.t_nombres = item.nombre;
        $scope.t_telf_principal = item.telefonoprincipaldomicilio;
        $scope.t_telf_secundario = item.telefonosecundariodomicilio;
        $scope.t_celular = item.celular;
        $scope.t_direccion = item.direcciondomicilio;
        $scope.t_telf_principal_emp = item.telefonoprincipaltrabajo;
        $scope.t_telf_secundario_emp = item.telefonosecundariotrabajo;
        $scope.t_direccion_emp = item.direcciontrabajo;

        $('#modalAddCliente').modal('show');
    };

    $scope.saveCliente = function () {

        var data = {
            fechaingreso: $scope.convertDatetoDB($scope.t_fecha_ingreso),
            codigocliente: $scope.t_doc_id,
            apellido: $scope.t_apellidos,
            nombre: $scope.t_nombres,
            telefonoprincipal: $scope.t_telf_principal,
            telefonosecundario: $scope.t_telf_secundario,
            celular: $scope.t_celular,
            direccion: $scope.t_direccion,
            telfprincipalemp: $scope.t_telf_principal_emp,
            telfsecundarioemp: $scope.t_telf_secundario_emp,
            direccionemp: $scope.t_direccion_emp,
            email: $scope.t_email
        };

        var url = API_URL + "cliente";

        if ($scope.t_codigocliente == 0){

            $http.post(url, data ).success(function (response) {
                $scope.initLoad();
                $('#modalAddCliente').modal('hide');
                $scope.message = 'Se insertó correctamente el cliente...';
                $('#modalMessage').modal('show');
            }).error(function (res) {
                console.log(res);
            });

        } else {
            url += '/' + $scope.t_codigocliente;

            $http.put(url, data ).success(function (response) {
                $scope.initLoad();
                $('#modalAddCliente').modal('hide');
                $scope.message = 'Se edito correctamente el Cliente seleccionado...';
                $('#modalMessage').modal('show');
            }).error(function (res) {

            });
        }

    };

    $scope.deleteCliente = function(){
        $http.delete(API_URL + 'cliente/' + $scope.codigocliente_del).success(function(response) {
            $scope.initLoad();
            $('#modalDeleteCliente').modal('hide');
            $scope.codigocliente_del = 0;
            $scope.message = 'Se elimino correctamente el Cliente seleccionado...';
            $('#modalMessage').modal('show');
        });
    };

    $scope.showModalAddCliente = function () {
        $scope.t_codigocliente = 0;
        $scope.t_fecha_ingreso = $scope.nowDate();

        $('#modalAddCliente').modal('show');
    };

    $scope.showModalDeleteCliente = function (item) {
        $scope.codigocliente_del = item.codigocliente;
        $scope.nom_cliente = item.apellido + ' ' + item.nombre;
        $('#modalDeleteCliente').modal('show');
    };

    $scope.showModalInfoCliente = function (item) {
        $scope.name_cliente = item.apellido + ' ' + item.nombre;
        $scope.identify_cliente = item.documentoidentidad;
        $scope.fecha_solicitud = item.fechaingreso;
        $scope.address_cliente = item.direcciondomicilio;
        $scope.email_cliente = item.correo;
        $scope.celular_cliente = item.celular;
        $scope.telf_cliente = item.telefonoprincipaldomicilio + ' / ' + item.telefonosecundariodomicilio;
        $scope.telf_cliente_emp = item.telefonoprincipaltrabajo + ' / ' + item.telefonosecundariotrabajo;
        $scope.estado_solicitud = item.estaactivo;

        $('#modalInfoCliente').modal('show');

    };



    $scope.initLoad();

});
