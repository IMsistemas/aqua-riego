
app.controller('terrenoController', function($scope, $http, API_URL) {

    $scope.terrenos = [];

    $scope.initLoad = function () {

        $scope.loadTarifas();
        //$scope.loadCanales();
        //$scope.loadBarriosSearch();
        $scope.loadBarrios();
        $scope.loadCultivos();

        $scope.tomas_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_toma = 0;

        $scope.canales_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_canales = 0;

        $scope.derivaciones_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_derivacion = 0;

        $http.get(API_URL + 'editTerreno/getTerrenos').success(function(response){
            $scope.terrenos = response;

            $('.datepicker').datetimepicker({
                locale: 'es',
                viewMode: 'years',
                format: 'YYYY'
            });
        });
    };

    $scope.getByFilter = function () {
        var filter = {
            year: $scope.s_anno,
            tarifa: $scope.t_tarifa,
            barrio: $scope.t_barrio_s,
            calle: $scope.t_toma,
            canal: $scope.t_canales,
            derivacion: $scope.t_derivacion
        };

        $http.get(API_URL + 'editTerreno/getByFilter/' + JSON.stringify(filter)).success(function(response){
            console.log(response);
            $scope.terrenos = response;
        });
    };


    $scope.loadInformation = function (terreno) {
        $scope.num_terreno = terreno.idterreno;
        $scope.fecha_ingreso = convertDatetoDB(terreno.fechacreacion, true);
        $scope.cliente = terreno.cliente.apellido + ' ' + terreno.cliente.nombre;
        $scope.cultivo = terreno.cultivo.nombrecultivo;
        $scope.tarifa = terreno.tarifa.nombretarifa;
        $scope.area = terreno.area;
        $scope.caudal = terreno.caudal;
        $scope.valor_anual = terreno.valoranual;
        $scope.barrio = terreno.derivacion.canal.calle.barrio.nombrebarrio;
        $scope.canal = terreno.derivacion.canal.nombrecanal;
        $scope.toma = terreno.derivacion.canal.calle.nombrecalle;
        $scope.derivacion = terreno.derivacion.nombrederivacion;

        $('#modalInfo').modal('show');
    };

    $scope.loadBarrios = function(){
        $http.get(API_URL + 'editTerreno/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios = array_temp;

            $scope.barrios_s = array_temp;
            $scope.t_barrio_s = 0;
        });
    };

    $scope.loadTarifas = function(){
        $http.get(API_URL + 'editTerreno/getTarifas').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
            $scope.t_tarifa = 0;
        });
    };

    $scope.loadCultivos = function(){
        $http.get(API_URL + 'editTerreno/getCultivos').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: 'Adicionar Nuevo', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecultivo, id: response[i].idcultivo})
            }
            $scope.cultivos = array_temp;
        });
    };

    $scope.loadCanales = function(){

        var idcalle = $scope.t_toma;

        $http.get(API_URL + 'editTerreno/getCanales/' + idcalle).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canales_s = array_temp;
        });
    };

    $scope.loadTomas = function(){
        var idbarrio = $scope.t_barrio_s;

        $http.get(API_URL + 'editTerreno/getTomas/' + idbarrio).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.tomas_s = array_temp;
        });
    };

    $scope.loadDerivaciones = function(){
        var idcanal = $scope.t_canales;

        $http.get(API_URL + 'editTerreno/getDerivaciones/' + idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
            }
            $scope.derivaciones_s = array_temp;
        });
    };

    $scope.calculateCaudal = function () {
        $http.get(API_URL + 'editTerreno/getConstante').success(function(response){
            var area = parseInt($scope.t_area);
            var constante = parseFloat(response[0].constante);

            var caudal_result = (area / 10000) * constante;

            $scope.calculate_caudal = caudal_result.toFixed(2);
        });
    };

    $scope.calculateValor = function () {
        var area = $scope.t_area;

        $http.get(API_URL + 'editTerreno/calculateValor/' + area).success(function(response){
            $scope.valor_total = parseFloat(response.costo).toFixed(2);
        });
    }

    $scope.edit = function (terreno) {

        $scope.codigo_cliente = terreno.cliente.documentoidentidad;
        $scope.nom_cliente = terreno.cliente.apellido + ' ' + terreno.cliente.nombre;
        $scope.direcc_cliente = terreno.cliente.direcciondomicilio;
        $scope.telf_cliente = terreno.cliente.telefonoprincipaldomicilio;

        $scope.t_terreno = terreno.idterreno;
        $scope.num_terreno_edit = terreno.idterreno;
        $scope.t_junta = terreno.derivacion.canal.calle.barrio.idbarrio;
        $scope.t_cultivo = terreno.cultivo.idcultivo;
        $scope.t_tarifa = terreno.tarifa.idtarifa;
        $scope.t_canal = terreno.derivacion.canal.idcanal;

        $scope.t_area = terreno.area;
        $scope.calculate_caudal = terreno.caudal;
        $scope.valor_total = terreno.valoranual;

        $http.get(API_URL + 'editTerreno/getTomas/' + terreno.derivacion.canal.calle.barrio.idbarrio).success(function(response){

            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.tomas_edit = array_temp;

            $scope.t_toma = terreno.derivacion.canal.calle.idcalle;


            $http.get(API_URL + 'editTerreno/getCanales/' + terreno.derivacion.canal.calle.idcalle).success(function(response){
                var longitud = response.length;
                var array_temp = [];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
                }
                $scope.canales_edit = array_temp;

                $scope.t_canal = terreno.derivacion.canal.idcanal;

                $http.get(API_URL + 'editTerreno/getDerivaciones/' + terreno.derivacion.canal.idcanal).success(function(response){
                    var longitud = response.length;
                    var array_temp = [];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
                    }
                    $scope.derivaciones_edit = array_temp;

                    $scope.t_derivacion = terreno.derivacion.idderivacion;

                    $('#modalEdit').modal('show');

                });

            });

        });



    };

    $scope.save = function () {

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

            //idsolicitud: $scope.num_solicitud
        };

        $http.put(API_URL + 'editTerreno/' + $scope.num_terreno_edit, solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $('#modalEdit').modal('hide');
                $scope.message = 'Se ha editado correctamente la informacion del Terreno...';
                $('#modalMessage').modal('show');
            }

        });

    };

    $scope.initLoad();
});

$(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $('.datepicker').datetimepicker({
        locale: 'es',
        viewMode: 'years',
        format: 'YYYY'
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
