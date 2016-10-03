
app.controller('terrenoController', function($scope, $http, API_URL) {

    $scope.terrenos = [];

    $scope.initLoad = function () {

        $scope.loadTarifas();
        $scope.loadCanales();
        $scope.loadBarrios();
        $scope.loadCultivos();

        $http.get(API_URL + 'editTerreno/getTerrenos').success(function(response){

            console.log(response);

            $scope.terrenos = response;

            $('.datepicker').datetimepicker({
                locale: 'es',
                viewMode: 'years',
                format: 'YYYY'
            });
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
        $scope.barrio = terreno.barrio.nombrebarrio;
        $scope.canal = terreno.derivacion.toma.canal.descripcioncanal;
        $scope.toma = terreno.derivacion.toma.descripciontoma;
        $scope.derivacion = terreno.derivacion.descripcionderivacion;

        $('#modalInfo').modal('show');
    };

    $scope.loadBarrios = function(){
        $http.get(API_URL + 'editTerreno/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios = array_temp;
        });
    };

    $scope.loadTarifas = function(){
        $http.get(API_URL + 'editTerreno/getTarifas').success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
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
        $http.get(API_URL + 'editTerreno/getCanales').success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripcioncanal, id: response[i].idcanal})
            }
            $scope.canales = array_temp;
        });
    };

    $scope.loadTomas = function(){
        var idcanal = $scope.t_canal;

        $http.get(API_URL + 'editTerreno/getTomas/' + idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripciontoma, id: response[i].idtoma})
            }
            $scope.tomas_edit = array_temp;
        });
    };

    $scope.loadDerivaciones = function(){
        var idtoma = $scope.t_toma;

        $http.get(API_URL + 'editTerreno/getDerivaciones/' + idtoma).success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripcionderivacion, id: response[i].idderivacion})
            }
            $scope.derivaciones_edit = array_temp;
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
        $scope.t_junta = terreno.barrio.idbarrio;
        $scope.t_cultivo = terreno.cultivo.idcultivo;
        $scope.t_tarifa = terreno.tarifa.idtarifa;
        $scope.t_canal = terreno.derivacion.toma.canal.idcanal;

        $scope.t_area = terreno.area;
        $scope.calculate_caudal = terreno.caudal;
        $scope.valor_total = terreno.valoranual;

        $http.get(API_URL + 'editTerreno/getTomas/' + terreno.derivacion.toma.canal.idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripciontoma, id: response[i].idtoma})
            }
            $scope.tomas_edit = array_temp;

            $scope.t_toma = terreno.derivacion.toma.idtoma;

            $http.get(API_URL + 'editTerreno/getDerivaciones/' + terreno.derivacion.toma.idtoma).success(function(response){
                var longitud = response.length;
                var array_temp = [];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].descripcionderivacion, id: response[i].idderivacion})
                }
                $scope.derivaciones_edit = array_temp;

                $scope.t_derivacion = terreno.derivacion.idderivacion;

                $('#modalEdit').modal('show');

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
