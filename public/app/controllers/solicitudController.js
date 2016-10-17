

app.filter('formatDate', function(){
    return function(texto){
        return convertDatetoDB(texto, true);
    }
});

app.controller('solicitudController', function($scope, $http, API_URL) {

    $scope.solicitudes = [];
    $scope.idsolicitud = 0;

    $scope.estados = [
        { id: 3, name: '-- Todos --' },
        { id: 2, name: 'En Espera' },
        { id: 1, name: 'Procesado' },
    ];

    $scope.t_estado = 3;

    $scope.tipo = [
        { id: 5, name: '-- Todos --' },
        { id: 4, name: 'Riego' },
        { id: 3, name: 'Cambio de Nombre' },
        { id: 2, name: 'Fraccionamiento' },
        { id: 1, name: 'Otros' },
    ];

    $scope.t_tipo_solicitud = 5;

    $scope.initLoad = function () {
        $http.get(API_URL + 'solicitud/getSolicitudes').success(function(response){

            console.log(response);

            var list = [];

            var riego = response.riego;

            if (riego.length > 0) {

                var length_riego = riego.length;

                for (var i = 0; i < length_riego; i++) {
                    var object_riego = {
                        no_solicitud : riego[i].idsolicitud,
                        fecha: riego[i].fechasolicitud,
                        cliente: riego[i].cliente.apellido + ' ' + riego[i].cliente.nombre,
                        direccion: riego[i].cliente.direcciondomicilio,
                        telefono: riego[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Riego',
                        estado: riego[i].estaprocesada,
                        fechaprocesada: riego[i].fechaprocesada,
                        terreno: riego[i].terreno
                    };

                    list.push(object_riego);
                }

            }

            var otro = response.otro;

            if (riego.length > 0) {

                var length_otro = otro.length;

                for (var i = 0; i < length_otro; i++) {
                    var object_otro = {
                        no_solicitud : otro[i].idsolicitud,
                        fecha: otro[i].fechasolicitud,
                        cliente: otro[i].cliente.apellido + ' ' + otro[i].cliente.nombre,
                        direccion: otro[i].cliente.direcciondomicilio,
                        telefono: otro[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Otra Solicitud',
                        estado: otro[i].estaprocesada,

                        descripcion: otro[i].descripcion,
                        fechaprocesada: otro[i].fechaprocesada
                    };

                    list.push(object_otro);
                }

            }

            var setnombre = response.setname;

            if (setnombre.length > 0) {

                var length_setnombre = setnombre.length;

                for (var i = 0; i < length_setnombre; i++) {
                    var object_setnombre = {
                        no_solicitud : setnombre[i].idsolicitud,
                        fecha: setnombre[i].fechasolicitud,
                        cliente: setnombre[i].cliente.apellido + ' ' + setnombre[i].cliente.nombre,
                        direccion: setnombre[i].cliente.direcciondomicilio,
                        telefono: setnombre[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Cambio de Nombre',
                        estado: setnombre[i].estaprocesada,

                        fechaprocesada: setnombre[i].fechaprocesada,
                        terreno: setnombre[i].terreno
                    };

                    list.push(object_setnombre);
                }

            }

            var reparticion = response.reparticion;

            if (reparticion.length > 0) {

                var length_reparticion = reparticion.length;

                for (var i = 0; i < length_reparticion; i++) {
                    var object_reparticion = {
                        no_solicitud : reparticion[i].idsolicitud,
                        fecha: reparticion[i].fechasolicitud,
                        cliente: reparticion[i].cliente.apellido + ' ' + reparticion[i].cliente.nombre,
                        direccion: reparticion[i].cliente.direcciondomicilio,
                        telefono: reparticion[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Repartición',
                        estado: reparticion[i].estaprocesada,
                        areanueva: reparticion[i].nuevaarea,
                        fechaprocesada: reparticion[i].fechaprocesada

                    };

                    list.push(object_reparticion);
                }

            }

            $scope.solicitudes = list;


        });
    };


    $scope.searchByFilter = function () {
        var filter = {
            tipo: $scope.t_tipo_solicitud,
            estado: $scope.t_estado
        };

        $http.get(API_URL + 'solicitud/getByFilter/' + JSON.stringify(filter)).success(function(response){

            console.log(response);

            var list = [];

            var riego = response.riego;

            if (riego.length > 0) {

                var length_riego = riego.length;

                for (var i = 0; i < length_riego; i++) {
                    var object_riego = {
                        no_solicitud : riego[i].idsolicitud,
                        fecha: riego[i].fechasolicitud,
                        cliente: riego[i].cliente.apellido + ' ' + riego[i].cliente.nombre,
                        direccion: riego[i].cliente.direcciondomicilio,
                        telefono: riego[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Riego',
                        estado: riego[i].estaprocesada,
                        fechaprocesada: riego[i].fechaprocesada,
                        terreno: riego[i].terreno
                    };

                    list.push(object_riego);
                }

            }

            var otro = response.otro;

            if (otro.length > 0) {

                var length_otro = otro.length;

                for (var i = 0; i < length_otro; i++) {
                    var object_otro = {
                        no_solicitud : otro[i].idsolicitud,
                        fecha: otro[i].fechasolicitud,
                        cliente: otro[i].cliente.apellido + ' ' + otro[i].cliente.nombre,
                        direccion: otro[i].cliente.direcciondomicilio,
                        telefono: otro[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Otra Solicitud',
                        estado: otro[i].estaprocesada,

                        descripcion: otro[i].descripcion,
                        fechaprocesada: otro[i].fechaprocesada
                    };

                    list.push(object_otro);
                }

            }

            var setnombre = response.setname;

            if (setnombre.length > 0) {

                var length_setnombre = setnombre.length;

                for (var i = 0; i < length_setnombre; i++) {
                    var object_setnombre = {
                        no_solicitud : setnombre[i].idsolicitud,
                        fecha: setnombre[i].fechasolicitud,
                        cliente: setnombre[i].cliente.apellido + ' ' + setnombre[i].cliente.nombre,
                        direccion: setnombre[i].cliente.direcciondomicilio,
                        telefono: setnombre[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Cambio de Nombre',
                        estado: setnombre[i].estaprocesada,

                        fechaprocesada: setnombre[i].fechaprocesada,
                        terreno: setnombre[i].terreno
                    };

                    list.push(object_setnombre);
                }

            }

            var reparticion = response.reparticion;

            if (reparticion.length > 0) {

                var length_reparticion = reparticion.length;

                for (var i = 0; i < length_reparticion; i++) {
                    var object_reparticion = {
                        no_solicitud : reparticion[i].idsolicitud,
                        fecha: reparticion[i].fechasolicitud,
                        cliente: reparticion[i].cliente.apellido + ' ' + reparticion[i].cliente.nombre,
                        direccion: reparticion[i].cliente.direcciondomicilio,
                        telefono: reparticion[i].cliente.telefonoprincipaldomicilio,
                        tipo: 'Repartición',
                        estado: reparticion[i].estaprocesada,
                        areanueva: reparticion[i].nuevaarea,
                        fechaprocesada: reparticion[i].fechaprocesada

                    };

                    list.push(object_reparticion);
                }

            }

            $scope.solicitudes = list;


        });

    };

    $scope.showModalProcesar = function(solicitud) {
        $scope.num_solicitud_process = solicitud.no_solicitud;
        $scope.cliente_process = solicitud.cliente;
        $scope.tipo_process = solicitud.tipo;

        $scope.idsolicitud = solicitud.no_solicitud;

        $('#modalProcesar').modal('show');
    };

    $scope.procesarSolicitud = function () {
        var url = API_URL + 'solicitud/' + $scope.idsolicitud;

        var data = {
            idsolicitud: $scope.idsolicitud
        };

        $http.put(url, data ).success(function (response) {
            $scope.initLoad();

            $scope.idsolicitud = 0;
            $('#modalProcesar').modal('hide');
            $scope.message = 'Se proceso correctamente la solicitud seleccionada...';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });
    };

    $scope.info = function (solicitud) {
        if(solicitud.tipo == 'Otra Solicitud') {
            $scope.no_info_otro = solicitud.no_solicitud;
            $scope.ingresada_info_otro = convertDatetoDB(solicitud.fecha, true);
            $scope.procesada_info_otro = convertDatetoDB(solicitud.fechaprocesada, true);
            $scope.cliente_info_otro = solicitud.cliente;
            $scope.descripcion_info_otro = solicitud.descripcion;
            $('#modalInfoSolOtros').modal('show');
        }

        if(solicitud.tipo == 'Riego') {
            $scope.no_info_riego = solicitud.no_solicitud;
            $scope.ingresada_info_riego = convertDatetoDB(solicitud.fecha, true);
            $scope.procesada_info_riego = convertDatetoDB(solicitud.fechaprocesada, true);
            $scope.cliente_info_riego = solicitud.cliente;

            $scope.noterreno_info_riego = solicitud.terreno.idterreno;
            $scope.area_info_riego = solicitud.terreno.area;

            $scope.junta_info_riego = solicitud.terreno.derivacion.canal.calle.barrio.nombrebarrio;
            $scope.toma_info_riego = solicitud.terreno.derivacion.canal.calle.nombrecalle;
            $scope.canal_info_riego = solicitud.terreno.derivacion.canal.nombrecanal;
            $scope.derivacion_info_riego = solicitud.terreno.derivacion.nombrederivacion;

            $('#modalInfoSolRiego').modal('show');
        }

        if(solicitud.tipo == 'Repartición') {
            $scope.no_info_fraccion = solicitud.no_solicitud;
            $scope.ingresada_info_fraccion = convertDatetoDB(solicitud.fecha, true);
            $scope.procesada_info_fraccion = convertDatetoDB(solicitud.fechaprocesada, true);
            $scope.cliente_info_fraccion = solicitud.cliente;
            $scope.area_info_fraccion = solicitud.areanueva;
            $('#modalInfoSolFraccion').modal('show');
        }

        if(solicitud.tipo == 'Cambio de Nombre') {
            $scope.no_info_setN = solicitud.no_solicitud;
            $scope.ingresada_info_setN = convertDatetoDB(solicitud.fecha, true);
            $scope.procesada_info_setN = convertDatetoDB(solicitud.fechaprocesada, true);
            $scope.cliente_info_setN = solicitud.cliente;

            $scope.noterreno_info_setN = solicitud.terreno.idterreno;
            $scope.area_info_setN = solicitud.terreno.area;

            $scope.junta_info_setN = solicitud.terreno.derivacion.canal.calle.barrio.nombrebarrio;
            $scope.toma_info_setN = solicitud.terreno.derivacion.canal.calle.nombrecalle;
            $scope.canal_info_setN = solicitud.terreno.derivacion.canal.nombrecanal;
            $scope.derivacion_info_setN = solicitud.terreno.derivacion.nombrederivacion;

            $('#modalInfoSolSetName').modal('show');
        }
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

function now(){
    var now = new Date();
    var dd = now.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = now.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;
    var yyyy = now.getFullYear();
    return dd + "\/" + mm + "\/" + yyyy;
}
