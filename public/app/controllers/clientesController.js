
app.filter('formatDate', function(){
    return function(texto){
        return convertDatetoDB(texto, true);
    }
});

app.controller('clientesController', function($scope, $http, API_URL) {

    $scope.clientes = [];
    $scope.codigocliente_del = 0;
    $scope.objectAction = null;

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

    /*
     *  ACTION FOR CLIENT-------------------------------------------------------------------
     */

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

        $scope.title_modal_cliente = 'Editar Cliente';

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
            $scope.message = 'Se eliminó correctamente el Cliente seleccionado...';
            $('#modalMessage').modal('show');
        });
    };

    $scope.showModalAddCliente = function () {
        $scope.t_codigocliente = 0;
        $scope.t_fecha_ingreso = $scope.nowDate();

        $scope.t_doc_id = '';
        $scope.t_apellidos = '';
        $scope.t_nombres = '';
        $scope.t_telf_principal = '';
        $scope.t_telf_secundario = '';
        $scope.t_celular = '';
        $scope.t_direccion = '';
        $scope.t_telf_principal_emp = '';
        $scope.t_telf_secundario_emp = '';
        $scope.t_direccion_emp = '';
        $scope.t_email = '';

        $scope.title_modal_cliente = 'Nuevo Cliente';

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

        if (item.estaactivo == true){
            $scope.estado_solicitud = 'Activo';
        } else {
            $scope.estado_solicitud = 'Inactivo';
        }



        $('#modalInfoCliente').modal('show');

    };


    /*
     *  GET DATA FOR SOLICITUD RIEGO-------------------------------------------------------------------
     */

    $scope.getLastID = function () {
        $http.get(API_URL + 'cliente/getLastID').success(function(response){
            $scope.nro_terreno = response.id;
        });
    };

    $scope.getBarrios = function(){
        $http.get(API_URL + 'cliente/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios = array_temp;
            $scope.t_junta = 0;
        });
    };

    $scope.getTomas = function(){
        var idbarrio = $scope.t_junta;

        $http.get(API_URL + 'cliente/getTomas/' + idbarrio).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.tomas = array_temp;
            $scope.t_toma = 0;
        });

    };

    $scope.getCanales = function(){

        var idcalle = $scope.t_toma;

        $http.get(API_URL + 'cliente/getCanales/' + idcalle).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canales = array_temp;
            $scope.t_canal = 0;
        });

    };

    $scope.getDerivaciones = function(){
        var idcanal = $scope.t_canal;

        $http.get(API_URL + 'cliente/getDerivaciones/' + idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
            }
            $scope.derivaciones = array_temp;
            $scope.t_derivacion = 0;
        });

    };

    $scope.getTarifas = function(){
        $http.get(API_URL + 'cliente/getTarifas').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
            $scope.t_tarifa = 0;
        });
    };

    $scope.getCultivos = function(){

        var idtarifa = $scope.t_tarifa;

        $http.get(API_URL + 'cliente/getCultivos/' + idtarifa).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecultivo, id: response[i].idcultivo})
            }
            $scope.cultivos = array_temp;
            $scope.t_cultivo = 0;
        });

    };

    $scope.calculate = function () {
        $scope.calculateCaudal();
        $scope.calculateValor();
    };

    $scope.calculateCaudal = function () {
        $http.get(API_URL + 'cliente/getConstante').success(function(response){
            var area = parseInt($scope.t_area);
            var constante = parseFloat(response[0].constante);

            var caudal_result = (area / 1000) * constante;

            $scope.calculate_caudal = caudal_result.toFixed(2);
        });
    };

    $scope.calculateValor = function () {
        var area = $scope.t_area;

        $http.get(API_URL + 'cliente/calculateValor/' + area).success(function(response){
            $scope.valor_total = parseFloat(response.costo).toFixed(2);
        });
    };

    /*
     *  SHOW MODAL ACTION-------------------------------------------------------------------
     */

    $scope.showModalAction = function (item) {
        $scope.objectAction = item;
        $('#modalAction').modal('show');
    };

    $scope.actionRiego = function () {
        $scope.getLastID();
        $scope.getBarrios();
        $scope.getTarifas();

        $scope.t_fecha_process = $scope.nowDate();

        $scope.h_codigocliente = $scope.objectAction.codigocliente;
        $scope.documentoidentidad_cliente = $scope.objectAction.documentoidentidad;
        $scope.nom_cliente = $scope.objectAction.apellido + ' ' + $scope.objectAction.nombre;
        $scope.direcc_cliente = $scope.objectAction.direcciondomicilio;
        $scope.telf_cliente = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente = $scope.objectAction.celular;
        $scope.telf_trab_cliente = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.t_area = '';
        $scope.t_observacion_riego = '';

        $('#modalActionRiego').modal('show');
    };

    $scope.actionOtro = function () {

        $scope.t_fecha_otro = $scope.nowDate();

        $scope.h_codigocliente_otro = $scope.objectAction.codigocliente;
        $scope.documentoidentidad_cliente_otro = $scope.objectAction.documentoidentidad;
        $scope.nom_cliente_otro = $scope.objectAction.apellido + ' ' + $scope.objectAction.nombre;
        $scope.direcc_cliente_otro = $scope.objectAction.direcciondomicilio;
        $scope.telf_cliente_otro = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente_otro = $scope.objectAction.celular;
        $scope.telf_trab_cliente_otro = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.t_observacion_otro = '';

        $('#modalActionOtro').modal('show');
    };



    $scope.saveSolicitudRiego = function () {

        var solicitud = {
            //fechacreacion: convertDatetoDB($scope.t_fecha_process),
            codigocliente: $scope.h_codigocliente,
            idbarrio: $scope.t_junta,
            idcultivo: $scope.t_cultivo,
            area: $scope.t_area,
            caudal: $scope.calculate_caudal,
            valoranual: $scope.valor_total,
            idtarifa: $scope.t_tarifa,
            idderivacion : $scope.t_derivacion,
            observacion: $scope.t_observacion_riego
            //idsolicitud: $scope.num_solicitud
        };

        $http.post(API_URL + 'cliente/storeSolicitudRiego', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $('#modalActionRiego').modal('hide');
                $scope.message = 'Se ha procesado la solicitud correctamente...'
                $('#modalMessage').modal('show');
            }

        });

    };

    $scope.saveSolicitudOtro = function () {

        var solicitud = {
            codigocliente: $scope.h_codigocliente_otro,
            observacion: $scope.t_observacion_otro
        };

        $http.post(API_URL + 'cliente/storeSolicitudOtro', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $('#modalActionOtro').modal('hide');
                $scope.message = 'Se ha procesado la solicitud correctamente...'
                $('#modalMessage').modal('show');
            }

        });

    };

    $scope.initLoad();


    $scope.onlyCharasterAndSpace = function ($event) {

        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /^([a-zA-Záéíóúñ\s]+)$/;
        var n = String.fromCharCode(k);

        if(patron.test(n) == false){
            $event.preventDefault();
            return false;
        }
        else return true;

    };

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