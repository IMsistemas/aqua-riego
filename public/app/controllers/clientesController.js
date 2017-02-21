
app.filter('formatDate', function(){
    return function(texto){
        return convertDatetoDB(texto, true);
    }
});

app.controller('clientesController', function($scope, $http, API_URL, Upload) {

    $scope.clientes = [];
    $scope.codigocliente_del = 0;
    $scope.idsolicitud_to_process = 0;
    $scope.objectAction = null;
    $scope.list_terrenos = [];

    $scope.idcliente = 0;

    $scope.idpersona = 0;
    $scope.id = 0;
    $scope.select_cuenta = null;

    $scope.pageChanged = function(newPage) {
        $scope.initLoad(newPage);
    };

    $scope.initLoad = function (pageNumber) {
        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };

        $http.get(API_URL + 'cliente/getClientes?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){
            console.log(response.data);
            $scope.clientes = response.data;
            $scope.totalItems = response.total;
        });
    };

    $scope.showDataPurchase = function (object) {
        if (object != undefined && object.originalObject != undefined) {

            console.log(object.originalObject);

            $scope.documentoidentidadempleado = object.originalObject.numdocidentific;
            $scope.apellido = object.originalObject.lastnamepersona;
            $scope.nombre = object.originalObject.namepersona;
            $scope.direccion = object.originalObject.direccion;
            $scope.celular = object.originalObject.celphone;
            $scope.correo = object.originalObject.email;
            $scope.tipoidentificacion = object.originalObject.idtipoidentificacion;
            $scope.idpersona = object.originalObject.idpersona;

            $scope.objectPerson = {
                idperson: object.originalObject.idpersona,
                identify: object.originalObject.numdocidentific
            };
        }
    };

    $scope.focusOut = function () {

        if ($scope.documentoidentidadempleado != null && $scope.documentoidentidadempleado != '' && $scope.documentoidentidadempleado != undefined) {
            $http.get(API_URL + 'empleado/getPersonaByIdentify/' + $scope.documentoidentidadempleado).success(function(response){

                var longitud = response.length;

                if (longitud > 0) {
                    $scope.idpersona = response[0].idpersona;
                } else {
                    $scope.idpersona = 0;
                }

            });

            $scope.$broadcast('angucomplete-alt:changeInput', 'documentoidentidadempleado', $scope.documentoidentidadempleado);
        }

    };

    $scope.inputChanged = function (str) {
        $scope.documentoidentidadempleado = str;
    };

    $scope.showPlanCuenta = function () {

        $http.get(API_URL + 'empleado/getPlanCuenta').success(function(response){
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

    $scope.showModalAddCliente = function () {

        $http.get(API_URL + 'cliente/getTipoIdentificacion').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nameidentificacion, id: response[i].idtipoidentificacion})
            }
            $scope.idtipoidentificacion = array_temp;
            $scope.tipoidentificacion = '';


            $http.get(API_URL + 'cliente/getImpuestoIVA').success(function(response){
                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: ''}];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nametipoimpuestoiva, id: response[i].idtipoimpuestoiva})
                }
                $scope.imp_iva = array_temp;
                $scope.iva = '';

                $scope.t_codigocliente = 0;
                $scope.t_fecha_ingreso = $scope.nowDate();

                $scope.idcliente = 0;
                $scope.documentoidentidadempleado = '';
                $scope.$broadcast('angucomplete-alt:changeInput', 'documentoidentidadempleado', '');
                $scope.idpersona = 0;
                $scope.apellido = '';
                $scope.nombre = '';
                $scope.telefonoprincipal = '';
                $scope.telefonosecundario = '';
                $scope.celular = '';
                $scope.direccion = '';
                $scope.telefonoprincipaltrabajo = '';
                $scope.telefonosecundariotrabajo = '';
                $scope.direcciontrabajo = '';
                $scope.correo = '';
                $scope.cuenta_employee = '';

                $scope.select_cuenta = null;

                $scope.title_modal_cliente = 'Nuevo Cliente';

                $('#modalAddCliente').modal('show');

            });

        });

    };

    $scope.saveCliente = function () {

        var url = API_URL + 'cliente';

        var fechaingreso = $('#t_fecha_ingreso').val();

        var data = {

            // datos de persona

            documentoidentidadempleado: $scope.documentoidentidadempleado,
            correo: $scope.correo,
            celular: $scope.celular,
            tipoidentificacion: $scope.tipoidentificacion,
            apellidos: $scope.apellido,
            nombres: $scope.nombre,
            direccion: $scope.direccion,

            // datos de cliente

            fechaingreso: convertDatetoDB(fechaingreso),
            idpersona:  $scope.idpersona,
            cuentacontable: $scope.select_cuenta.idplancuenta,
            impuesto_iva: $scope.iva,

            telefonoprincipaldomicilio: $scope.telefonoprincipal,
            telefonosecundariodomicilio: $scope.telefonosecundario,
            telefonoprincipaltrabajo: $scope.telefonoprincipaltrabajo,
            telefonosecundariotrabajo: $scope.telefonosecundariotrabajo,
            direcciontrabajo: $scope.direcciontrabajo

        };

        if ($scope.idcliente == 0) {
            $http.post(url, data ).success(function (response) {
                if (response.success == true) {
                    $scope.initLoad(1);
                    $scope.message = 'Se guardó correctamente la información del Cliente...';
                    $('#modalAddCliente').modal('hide');
                    $('#modalMessage').modal('show');
                    $scope.hideModalMessage();
                }
                else {
                    $('#modalAddCliente').modal('hide');
                    $scope.message_error = 'Ha ocurrido un error..';
                    $('#modalMessageError').modal('show');
                }
            });
        } else {
            $http.put(url + '/' + $scope.idcliente, data ).success(function (response) {
                if (response.success == true) {
                    $scope.idpersona = 0;
                    $scope.idcliente = 0;
                    $scope.initLoad(1);
                    $scope.message = 'Se editó correctamente la información del Cliente...';
                    $('#modalAddCliente').modal('hide');
                    $('#modalMessage').modal('show');
                    $scope.hideModalMessage();
                }
                else {
                    $('#modalAddCliente').modal('hide');
                    $scope.message_error = 'Ha ocurrido un error..';
                    $('#modalMessageError').modal('show');
                }
            }).error(function (res) {

            });
        }
    };

    $scope.showModalInfoCliente = function (item) {
        $scope.name_cliente = item.razonsocial;
        $scope.identify_cliente = item.numdocidentific;
        $scope.fecha_solicitud = item.fechaingreso;
        $scope.address_cliente = item.direccion;
        $scope.email_cliente = item.email;
        $scope.celular_cliente = item.celphone;
        $scope.telf_cliente = item.telefonoprincipaldomicilio + ' / ' + item.telefonosecundariodomicilio;
        $scope.telf_cliente_emp = item.telefonoprincipaltrabajo + ' / ' + item.telefonosecundariotrabajo;

        if (item.estado == true){
            $scope.estado_solicitud = 'Activo';
        } else {
            $scope.estado_solicitud = 'Inactivo';
        }

        $('#modalInfoCliente').modal('show');

    };

    $scope.showModalEditCliente = function (item) {

        $http.get(API_URL + 'cliente/getTipoIdentificacion').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nameidentificacion, id: response[i].idtipoidentificacion})
            }
            $scope.idtipoidentificacion = array_temp;
            $scope.tipoidentificacion = item.idtipoidentificacion;


            $http.get(API_URL + 'cliente/getImpuestoIVA').success(function(response){
                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: ''}];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nametipoimpuestoiva, id: response[i].idtipoimpuestoiva})
                }
                $scope.imp_iva = array_temp;
                $scope.iva = item.idtipoimpuestoiva;

                console.log(item);

                $scope.idcliente = item.idcliente;

                //$scope.t_codigocliente = 0;

                $scope.t_fecha_ingreso = convertDatetoDB(item.fechaingreso, true);
                $scope.documentoidentidadempleado = item.numdocidentific;
                $scope.$broadcast('angucomplete-alt:changeInput', 'documentoidentidadempleado', item.numdocidentific);
                $scope.idpersona = item.idpersona;
                $scope.apellido = item.lastnamepersona;
                $scope.nombre = item.namepersona;
                $scope.telefonoprincipal = item.telefonoprincipaldomicilio;
                $scope.telefonosecundario = item.telefonoprincipaltrabajo;
                $scope.celular = item.celphone;
                $scope.direccion = item.direccion;
                $scope.telefonoprincipaltrabajo = item.telefonoprincipaltrabajo;
                $scope.telefonosecundariotrabajo = item.telefonosecundariotrabajo;
                $scope.direcciontrabajo = item.direcciontrabajo;
                $scope.correo = item.email;
                $scope.cuenta_employee = item.concepto;

                var objectPlan = {
                    idplancuenta: item.idplancuenta,
                    concepto: item.concepto
                };

                $scope.select_cuenta = objectPlan;

                $scope.title_modal_cliente = 'Editar Cliente';

                $('#modalAddCliente').modal('show');

            });

        });




    };

    $scope.showModalDeleteCliente = function (item) {
        $scope.idcliente = item.idcliente;
        $http.get(API_URL + 'cliente/getIsFreeCliente/' + item.idcliente).success(function(response){
            if (response == 0) {
                $scope.nom_cliente = item.razonsocial;
                $('#modalDeleteCliente').modal('show');
            } else {
                $scope.message_info = 'No se puede eliminar el cliente seleccionado, ya presenta solicitudes a su nombre...';
                $('#modalMessageInfo').modal('show');
            }
        });

    };

    $scope.deleteCliente = function(){
        $http.delete(API_URL + 'cliente/' + $scope.idcliente).success(function(response) {
            $scope.initLoad(1);
            $('#modalDeleteCliente').modal('hide');
            $scope.idcliente = 0;
            $scope.message = 'Se eliminó correctamente el Cliente seleccionado...';
            $('#modalMessage').modal('show');
            $scope.hideModalMessage();
        });
    };

/**
* ----------------------------------------------------------------------------------------------------------------------
*/










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














    /*
     *  GET DATA FOR SOLICITUD RIEGO-------------------------------------------------------------------
     */

    $scope.getLastIDRiego = function () {

        var table = {
            name: 'solicitudriego'
        };

        $http.get(API_URL + 'cliente/getLastID/' + JSON.stringify(table)).success(function(response){
            $scope.num_solicitud_riego = response.id;
        });
    };

    $scope.getLastID = function () {

        var table = {
            name: 'terreno'
        };

        $http.get(API_URL + 'cliente/getLastID/' + JSON.stringify(table)).success(function(response){
            $scope.nro_terreno = response.id;
        });
    };

    $scope.getBarrios = function(){
        $http.get(API_URL + 'cliente/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namebarrio, id: response[i].idbarrio})
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
                array_temp.push({label: response[i].namecalle, id: response[i].idcalle})
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

    $scope.calculateFraccion = function () {

        if ($scope.t_area_fraccion != '' && $scope.t_area_fraccion != undefined){
            $scope.calculateCaudalFraccion();
            $scope.calculateValorFraccion();
        }

    };

    $scope.calculateCaudalFraccion = function () {
        $http.get(API_URL + 'cliente/getConstante').success(function(response){
            var area = parseInt($scope.t_area_fraccion);
            var constante = parseFloat(response[0].constante);

            var caudal_result = (area / 1000) * constante;

            $scope.caudal_new_fraccion = caudal_result.toFixed(2);
        });
    };

    $scope.calculateValorFraccion = function () {
        var area = $scope.t_area_fraccion;

        $http.get(API_URL + 'cliente/calculateValor/' + area).success(function(response){
            $scope.valor_new_fraccion = parseFloat(response.costo).toFixed(2);
        });
    };

    /*
     *  GET DATA FOR SOLICITUD OTROS-------------------------------------------------------------------
     */

    $scope.getLastIDOtros = function () {

        var table = {
            name: 'solicitudotro'
        };

        $http.get(API_URL + 'cliente/getLastID/' + JSON.stringify(table)).success(function(response){
            $scope.num_solicitud_otro = response.id;
        });
    };

    /*
     *  GET DATA FOR SOLICITUD CAMBIO DE NOMBRE--------------------------------------------------------
     */

    $scope.getLastIDSetNombre = function () {
        var table = {
            name: 'solicitudcambionombre'
        };

        $http.get(API_URL + 'cliente/getLastID/' + JSON.stringify(table)).success(function(response){
            $scope.num_solicitud_setnombre = response.id;
        });
    };

    $scope.getTerrenosByCliente = function () {
        var idcliente = {
            codigocliente: $scope.objectAction.codigocliente
        };

        $http.get(API_URL + 'cliente/getTerrenosByCliente/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            $scope.list_terrenos = response;

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].area, id: response[i].idterreno})
            }

            $scope.terrenos_setN = array_temp;
            $scope.t_terrenos_setnombre = 0;
        });
    };

    $scope.getTerrenosFraccionByCliente = function () {
        var idcliente = {
            codigocliente: $scope.objectAction.codigocliente
        };

        $http.get(API_URL + 'cliente/getTerrenosByCliente/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            $scope.list_terrenos = response;

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].area, id: response[i].idterreno})
            }

            $scope.terrenos_fraccion = array_temp;
            $scope.t_terrenos_fraccion = 0;
        });
    };

    $scope.searchInfoTerreno = function () {

        console.log($scope.list_terrenos);

        var longitud = ($scope.list_terrenos).length;

        for (var i = 0; i < longitud; i++){
            if ($scope.list_terrenos[i].idterreno == $scope.t_terrenos_setnombre){
                $scope.junta_setnombre = $scope.list_terrenos[i].derivacion.canal.calle.barrio.nombrebarrio;
                $scope.toma_setnombre = $scope.list_terrenos[i].derivacion.canal.calle.nombrecalle;
                $scope.canal_setnombre = $scope.list_terrenos[i].derivacion.canal.nombrecanal;
                $scope.derivacion_setnombre = $scope.list_terrenos[i].derivacion.nombrederivacion;
                $scope.cultivo_setnombre = $scope.list_terrenos[i].cultivo.nombrecultivo;
                $scope.area_setnombre = $scope.list_terrenos[i].area;
                $scope.caudal_setnombre = $scope.list_terrenos[i].caudal;

                break;
            }
        }

    };

    $scope.searchInfoTerrenoFraccion = function () {

        console.log($scope.list_terrenos);

        var longitud = ($scope.list_terrenos).length;

        for (var i = 0; i < longitud; i++){
            if ($scope.list_terrenos[i].idterreno == $scope.t_terrenos_fraccion){
                $scope.junta_fraccion = $scope.list_terrenos[i].derivacion.canal.calle.barrio.nombrebarrio;
                $scope.toma_fraccion = $scope.list_terrenos[i].derivacion.canal.calle.nombrecalle;
                $scope.canal_fraccion = $scope.list_terrenos[i].derivacion.canal.nombrecanal;
                $scope.derivacion_fraccion = $scope.list_terrenos[i].derivacion.nombrederivacion;
                $scope.cultivo_fraccion = $scope.list_terrenos[i].cultivo.nombrecultivo;
                $scope.area_fraccion = $scope.list_terrenos[i].area;
                $scope.caudal_fraccion = $scope.list_terrenos[i].caudal;
                $scope.valor_fraccion = $scope.list_terrenos[i].valoranual;
                break;
            }
        }

    };

    $scope.getIdentifyClientes = function () {
        var idcliente = {
            codigocliente: $scope.objectAction.codigocliente
        };

        $http.get(API_URL + 'cliente/getIdentifyClientes/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].documentoidentidad, id: response[i].codigocliente})
            }

            //$('.selectpicker').selectpicker('refresh');
            //$('.selectpicker').selectpicker();

            $scope.clientes_setN = array_temp;
            //$('.selectpicker').selectpicker('refresh');
            $scope.t_ident_new_client_setnombre = 0;
        });
    };

    $scope.getIdentifyClientesFraccion = function () {
        var idcliente = {
            codigocliente: $scope.objectAction.codigocliente
        };

        $http.get(API_URL + 'cliente/getIdentifyClientes/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].documentoidentidad, id: response[i].codigocliente})
            }

            //$('.selectpicker').selectpicker('refresh');
            //$('.selectpicker').selectpicker();

            $scope.clientes_fraccion = array_temp;
            //$('.selectpicker').selectpicker('refresh');
            $scope.t_ident_new_client_fraccion = 0;
        });
    };

    $scope.getClienteByIdentify = function () {
        var idcliente = {
            codigocliente: $scope.t_ident_new_client_setnombre
        };

        $http.get(API_URL + 'cliente/getClienteByIdentify/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            $scope.h_new_codigocliente_setnombre = response[0].codigocliente;
            $scope.nom_new_cliente_setnombre = response[0].apellido + ' ' + response[0].nombre;
            $scope.direcc_new_cliente_setnombre = response[0].direcciondomicilio;
            $scope.telf_new_cliente_setnombre = response[0].telefonoprincipaldomicilio;
            $scope.celular_new_cliente_setnombre = response[0].celular;
            $scope.telf_trab_new_cliente_setnombre = response[0].telefonoprincipaltrabajo;

        });
    };

    $scope.getLastIDFraccion = function () {
        var table = {
            name: 'solicitudreparticion'
        };

        $http.get(API_URL + 'cliente/getLastID/' + JSON.stringify(table)).success(function(response){
            $scope.num_solicitud_fraccion = response.id;
        });
    };

    $scope.getClienteByIdentifyFraccion = function () {
        var idcliente = {
            codigocliente: $scope.t_ident_new_client_fraccion
        };

        $http.get(API_URL + 'cliente/getClienteByIdentify/' + JSON.stringify(idcliente)).success(function(response){
            console.log(response);

            $scope.h_new_codigocliente_fraccion = response[0].codigocliente;
            $scope.nom_new_cliente_fraccion = response[0].apellido + ' ' + response[0].nombre;
            $scope.direcc_new_cliente_fraccion = response[0].direcciondomicilio;
            $scope.telf_new_cliente_fraccion = response[0].telefonoprincipaldomicilio;
            $scope.celular_new_cliente_fraccion = response[0].celular;
            $scope.telf_trab_new_cliente_fraccion = response[0].telefonoprincipaltrabajo;

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
        $scope.getLastIDRiego();
        $scope.getLastID();
        $scope.getBarrios();
        $scope.getTarifas();

        $scope.t_fecha_process = $scope.nowDate();

        console.log($scope.objectAction);

        $scope.h_codigocliente = $scope.objectAction.idcliente;
        $scope.documentoidentidad_cliente = $scope.objectAction.numdocidentific;
        $scope.nom_cliente = $scope.objectAction.razonsocial;
        $scope.direcc_cliente = $scope.objectAction.direccion;
        $scope.telf_cliente = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente = $scope.objectAction.celphone;
        $scope.telf_trab_cliente = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.cultivos = [{label: '-- Seleccione --', id: 0}];
        $scope.t_cultivo = 0;
        $scope.tomas = [{label: '-- Seleccione --', id: 0}];
        $scope.t_toma = 0;
        $scope.canales = [{label: '-- Seleccione --', id: 0}];
        $scope.t_canal = 0;
        $scope.derivaciones = [{label: '-- Seleccione --', id: 0}];
        $scope.t_derivacion = 0;

        $scope.calculate_caudal = '0.00';
        $scope.valor_total = '$ 0.00';

        $scope.t_area = '';
        $scope.t_observacion_riego = '';

        $('#btn-process-riego').prop('disabled', true);

        $('#modalActionRiego').modal('show');
    };

    $scope.actionOtro = function () {
        $scope.getLastIDOtros();

        $scope.t_fecha_otro = $scope.nowDate();
        $scope.h_codigocliente_otro = $scope.objectAction.idcliente;
        $scope.documentoidentidad_cliente_otro = $scope.objectAction.numdocidentific;
        $scope.nom_cliente_otro = $scope.objectAction.razonsocial;
        $scope.direcc_cliente_otro = $scope.objectAction.direccion;
        $scope.telf_cliente_otro = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente_otro = $scope.objectAction.celphone;
        $scope.telf_trab_cliente_otro = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.t_observacion_otro = '';
        $('#btn-process-otro').prop('disabled', true);

        $('#modalActionOtro').modal('show');
    };

    $scope.actionFraccion = function () {
        $scope.getLastIDFraccion();
        $scope.getTerrenosFraccionByCliente();
        $scope.getIdentifyClientesFraccion();

        $scope.t_fecha_fraccion = $scope.nowDate();
        $scope.h_codigocliente_fraccion = $scope.objectAction.codigocliente;
        $scope.documentoidentidad_cliente_fraccion = $scope.objectAction.documentoidentidad;
        $scope.nom_cliente_fraccion = $scope.objectAction.apellido + ' ' + $scope.objectAction.nombre;
        $scope.direcc_cliente_fraccion = $scope.objectAction.direcciondomicilio;
        $scope.telf_cliente_fraccion = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente_fraccion = $scope.objectAction.celular;
        $scope.telf_trab_cliente_fraccion = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.junta_fraccion = '';
        $scope.toma_fraccion = '';
        $scope.canal_fraccion = '';
        $scope.derivacion_fraccion = '';
        $scope.cultivo_fraccion = '';
        $scope.area_fraccion = '';
        $scope.caudal_fraccion = '';
        $scope.valor_fraccion = '';
        $scope.caudal_new_fraccion = '';
        $scope.valor_new_fraccion = '';
        $scope.nom_new_cliente_fraccion = '';

        $scope.t_area_fraccion = '';
        $scope.t_observacion_fraccion = '';

        $('#btn-process-fraccion').prop('disabled', true);
        $('#modalActionFraccion').modal('show');
    };

    $scope.actionSetName = function () {
        $scope.getTerrenosByCliente();
        $scope.getIdentifyClientes();
        $scope.getLastIDSetNombre();

        $scope.t_fecha_setnombre = $scope.nowDate();
        $scope.h_codigocliente_setnombre = $scope.objectAction.codigocliente;
        $scope.documentoidentidad_cliente_setnombre = $scope.objectAction.documentoidentidad;
        $scope.nom_cliente_setnombre = $scope.objectAction.apellido + ' ' + $scope.objectAction.nombre;
        $scope.direcc_cliente_setnombre = $scope.objectAction.direcciondomicilio;
        $scope.telf_cliente_setnombre = $scope.objectAction.telefonoprincipaldomicilio;
        $scope.celular_cliente_setnombre = $scope.objectAction.celular;
        $scope.telf_trab_cliente_setnombre = $scope.objectAction.telefonoprincipaltrabajo;

        $scope.junta_setnombre = '';
        $scope.toma_setnombre = '';
        $scope.canal_setnombre = '';
        $scope.derivacion_setnombre = '';
        $scope.cultivo_setnombre = '';
        $scope.area_setnombre = '';
        $scope.caudal_setnombre = '';
        $scope.nom_new_cliente_setnombre = '';
        $scope.direcc_new_cliente_setnombre = '';
        $scope.telf_new_cliente_setnombre = '';
        $scope.celular_new_cliente_setnombre = '';
        $scope.telf_trab_new_cliente_setnombre = '';

        $scope.t_observacion_setnombre = '';

        $('#btn-process-setnombre').prop('disabled', true);
        $('#btn-save-setnombre').prop('disabled', false);
        $('#modalActionSetNombre').modal('show');
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
            observacion: $scope.t_observacion_riego,
            file: $scope.file

            //idsolicitud: $scope.num_solicitud
        };

        Upload.upload({
            url: API_URL + 'cliente/storeSolicitudRiego',
            method: 'POST',
            data: solicitud
        }).success(function(data, status, headers, config) {

            if (data.success == true) {
                $scope.initLoad();
                $scope.idsolicitud_to_process = data.idsolicitud;
                $('#btn-save-riego').prop('disabled', true);
                $('#btn-process-riego').prop('disabled', false);
                $scope.message = 'Se ha ingresado la solicitud correctamente...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }
            else {

            }
        });




        /*$http.post(API_URL + 'cliente/storeSolicitudRiego', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $scope.idsolicitud_to_process = response.idsolicitud;

                $('#btn-save-riego').prop('disabled', true);
                $('#btn-process-riego').prop('disabled', false);

                $scope.message = 'Se ha ingresado la solicitud correctamente...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }

        });*/

    };

    $scope.saveSolicitudFraccion = function () {

        var solicitud = {
            codigocliente_new: $scope.h_new_codigocliente_fraccion,
            codigocliente_old: $scope.h_codigocliente_fraccion,
            idterreno: $scope.t_terrenos_fraccion,
            observacion: $scope.t_observacion_fraccion,


            area: $scope.t_area_fraccion,
            caudal: $scope.caudal_new_fraccion,
            valoranual: $scope.valor_new_fraccion,
        };

        console.log(solicitud);

        $http.post(API_URL + 'cliente/storeSolicitudFraccion', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();

                $scope.idsolicitud_to_process = response.idsolicitud;

                $('#btn-save-fraccion').prop('disabled', true);
                $('#btn-process-fraccion').prop('disabled', false);

                $scope.message = 'Se ha ingresado la solicitud correctamente...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
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
                //$('#modalActionOtro').modal('hide');

                $scope.idsolicitud_to_process = response.idsolicitud;

                $('#btn-save-otro').prop('disabled', true);
                $('#btn-process-otro').prop('disabled', false);

                $scope.message = 'Se ha ingresado la solicitud correctamente...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }

        });

    };

    $scope.saveSolicitudSetName = function () {

        var solicitud = {
            //fechacreacion: convertDatetoDB($scope.t_fecha_process),
            codigocliente_new: $scope.h_new_codigocliente_setnombre,
            codigocliente_old: $scope.h_codigocliente_setnombre,
            idterreno: $scope.t_terrenos_setnombre,
            observacion: $scope.t_observacion_setnombre
            //idsolicitud: $scope.num_solicitud
        };

        $http.post(API_URL + 'cliente/storeSolicitudSetName', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();


                $scope.idsolicitud_to_process = response.idsolicitud;

                $('#btn-save-setnombre').prop('disabled', true);
                $('#btn-process-setnombre').prop('disabled', false);

                $scope.message = 'Se ha ingresado la solicitud correctamente...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }

        });

    };

    $scope.procesarSolicitud = function (id_btn) {
        var url = '';

        if (id_btn == 'btn-process-setnombre'){
            url = API_URL + 'cliente/processSolicitudSetName/' + $scope.idsolicitud_to_process;
        } else if (id_btn == 'btn-process-fraccion') {
            url = API_URL + 'cliente/processSolicitudFraccion/' + $scope.idsolicitud_to_process;
        } else {
            url = API_URL + 'cliente/processSolicitud/' + $scope.idsolicitud_to_process;
        }

        var data = {
            idsolicitud: $scope.idsolicitud_to_process
        };

        $http.put(url, data ).success(function (response) {
            $scope.idsolicitud_to_process = 0;

            $('#' + id_btn).prop('disabled', true);


            $('#modalActionRiego').modal('hide');
            $('#modalActionOtro').modal('hide');
            $('#modalActionSetNombre').modal('hide');
            $('#modalActionFraccion').modal('hide');

            $('#modalAction').modal('hide');

            $scope.message = 'Se procesó correctamente la solicitud...';
            $('#modalMessage').modal('show');
            $scope.hideModalMessage();

        }).error(function (res) {

        });
    };

    $scope.initLoad();

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };

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

    $scope.onlyNumber = function ($event) {

        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /\d/;
        var n = String.fromCharCode(k);

        if (n == ".") {
            return true;
        } else {

            if(patron.test(n) == false){
                $event.preventDefault();
            }
            else return true;
        }
    };
});

$(function(){

    $('[data-toggle="tooltip"]').tooltip();

    /*$('.selectpicker').selectpicker('refresh');
    $('.selectpicker').selectpicker();*/

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