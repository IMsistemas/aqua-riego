

app.filter('formatDate', function(){
    return function(texto){
        return convertDatetoDB(texto, true);
    }
});

app.controller('solicitudController', function($scope, $http, API_URL) {

    $scope.solicitudes = [];
    $scope.idsolicitud = 0;

    $scope.estados = [
        { id: 3, name: 'Todos' },
        { id: 2, name: 'En Espera' },
        { id: 1, name: 'Procesado' },
    ];

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

                        fechaprocesada: setnombre[i].fechaprocesada
                    };

                    list.push(object_setnombre);
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
