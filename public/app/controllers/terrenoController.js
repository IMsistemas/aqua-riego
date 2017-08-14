
app.controller('terrenoController', function($scope, $http, API_URL, Upload) {

    $scope.terrenos = [];

    $scope.pageChanged = function(newPage) {
        $scope.initLoad(newPage);
    };

    $scope.initLoad = function (pageNumber) {

        $('.datepicker_year').datetimepicker({
            locale: 'es',
            viewMode: 'years',
            format: 'YYYY'

        });

        $scope.loadTarifas();
        $scope.loadBarrios();

        $scope.tomas_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_toma0 = 0;

        $scope.canales_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_canales = 0;

        $scope.derivaciones_s = [{label: '-- Seleccione --', id: 0}];
        $scope.t_derivacion0 = 0;


        if ($scope.search === undefined) {
            var search = null;
        } else var search = $scope.search;

        if ($scope.s_year === undefined) {
            var s_year = null;
        } else var s_year = $scope.s_year;


        var filtros = {
            search: search,
            s_year: s_year,
            t_tarifa0: $scope.t_tarifa0,
            t_barrio_s: $scope.t_barrio_s,
            t_toma0: $scope.t_toma0,
            t_canales: $scope.t_canales,
            t_derivacion0: $scope.t_derivacion0
        };

        $http.get(API_URL + 'editTerreno/getTerrenos?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.terrenos = response.data;
            $scope.totalItems = response.total;

            console.log(response);

        });
    };

    $scope.getByFilter = function () {

        $scope.s_year = $('#s_year').val();

        var filter = {
            year: $scope.s_year,
            tarifa: $scope.t_tarifa0,
            barrio: $scope.t_barrio_s,
            calle: $scope.t_toma0,
            canal: $scope.t_canales,
            derivacion: $scope.t_derivacion0
        };

        $http.get(API_URL + 'editTerreno/getByFilter/' + JSON.stringify(filter)).success(function(response){
            console.log(response);

            var longitud = response.length;

            var temp = [];

            for (var i = 0; i < longitud; i++) {
               if(response[i].derivacion != null) {
                   if(response[i].derivacion.canal != null) {
                       if(response[i].derivacion.canal.calle != null) {
                           if(response[i].derivacion.canal.calle.barrio != null) {
                               temp.push(response[i]);
                           }
                       }
                   }
               }
            }

            var longitud0 = temp.length;
            for (var i = 0; i < longitud0; i++) {
                var complete_name = {
                    value: temp[i].cliente.apellido + ', ' + temp[i].cliente.nombre,
                    writable: true,
                    enumerable: true,
                    configurable: true
                };
                Object.defineProperty(temp[i].cliente, 'complete_name', complete_name);
            }

            $scope.terrenos = temp;
        });
    };

    $scope.loadInformation = function (terreno) {
        /*$scope.num_terreno = terreno.idterreno;
        $scope.fecha_ingreso = convertDatetoDB(terreno.fechacreacion, true);
        $scope.cliente = terreno.cliente.persona.razonsocial;
        $scope.cultivo = terreno.cultivo.nombrecultivo;
        $scope.tarifa = terreno.tarifa.nombretarifa;
        $scope.area = terreno.area;
        $scope.caudal = terreno.caudal;
        $scope.valor_anual = terreno.valoranual;
        $scope.barrio = terreno.derivacion.canal.calle.barrio.namebarrio;
        $scope.canal = terreno.derivacion.canal.nombrecanal;
        $scope.toma = terreno.derivacion.canal.calle.namecalle;
        $scope.derivacion = terreno.derivacion.nombrederivacion;*/

        $scope.num_terreno = terreno.idterreno;
        $scope.fecha_ingreso = convertDatetoDB(terreno.fechacreacion, true);
        $scope.cliente = terreno.razonsocial;
        $scope.cultivo = terreno.nombrecultivo;
        $scope.tarifa = terreno.nombretarifa;
        $scope.area = terreno.area;
        $scope.caudal = terreno.caudal;
        $scope.valor_anual = terreno.valoranual;
        $scope.barrio = terreno.namebarrio;
        $scope.canal = terreno.nombrecanal;
        $scope.toma = terreno.namecalle;
        $scope.derivacion = terreno.nombrederivacion;

        $('#modalInfo').modal('show');
    };

    $scope.loadBarrios = function(){
        $http.get(API_URL + 'editTerreno/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namebarrio, id: response[i].idbarrio})
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
            $scope.t_tarifa0 = 0;
        });
    };

    $scope.loadCultivos = function(idcultivo){
        var array_temp = [];
        if ($scope.t_tarifa != 0) {
            var tarifa = $scope.t_tarifa;
            $http.get(API_URL + 'editTerreno/getCultivos/' + tarifa).success(function(response){
                var longitud = response.length;
                array_temp = [{label: '-- Seleccione --', id: 0}];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nombrecultivo, id: response[i].idcultivo})
                }
                $scope.cultivos = array_temp;

                if (idcultivo != undefined) {
                    $scope.t_cultivo = idcultivo;
                } else $scope.t_cultivo = 0;

            });
        } else {
            array_temp = [{label: '-- Seleccione --', id: 0}];
            $scope.cultivos = array_temp;
            $scope.t_cultivo = 0;
        }

    };

    $scope.loadCanales = function(){

        var idcalle = $scope.t_toma0;

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
            console.log(array_temp);
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

    $scope.loadTomasEdit = function(){
        var idbarrio = $scope.t_junta;

        $http.get(API_URL + 'editTerreno/getTomas/' + idbarrio).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }

            $scope.tomas_edit = array_temp;
            $scope.t_toma = 0;

            $scope.canales_edit = [{label: '-- Seleccione --', id: 0}];
            $scope.t_canal = 0;

            $scope.derivaciones_edit = [{label: '-- Seleccione --', id: 0}];
            $scope.t_derivacion = 0;
        });
    };

    $scope.loadCanalesEdit = function(){

        var idcalle = $scope.t_toma;

        $http.get(API_URL + 'editTerreno/getCanales/' + idcalle).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }

            $scope.canales_edit = array_temp;
            $scope.t_canal = 0;

            $scope.derivaciones_edit = [{label: '-- Seleccione --', id: 0}];
            $scope.t_derivacion = 0;
        });
    };

    $scope.loadDerivacionesEdit = function(){
        var idcanal = $scope.t_canal;

        $http.get(API_URL + 'editTerreno/getDerivaciones/' + idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
            }
            $scope.derivaciones_edit = array_temp;
            $scope.t_derivacion = 0;
        });
    };

    $scope.calculate = function () {
        $scope.calculateCaudal();
        $scope.calculateValor();
    };

    $scope.calculateCaudal = function () {
        /*$http.get(API_URL + 'cliente/getConstante').success(function(response){
            var area = parseInt($scope.t_area);
            var constante = parseFloat(response[0].optionvalue);

            var caudal_result = (area / 10000) * constante;

            $scope.calculate_caudal = caudal_result.toFixed(2);
        });*/

        var area = $scope.t_area.trim();

        if (area !== undefined && area !== '') {
            $http.get(API_URL + 'cliente/getConstante').success(function(response){

                var area = parseFloat($scope.t_area);
                var constante = parseFloat(response[0].optionvalue);

                console.log(response);
                console.log(area);

                var caudal_result = 0;

                if (area !== undefined && area !== ''){
                    caudal_result = (area / 10000) * constante;

                    console.log(caudal_result);

                    $scope.calculate_caudal = caudal_result.toFixed(2);
                }

            });
        }

    };

    $scope.calculateValor = function () {
        var area = $scope.t_area.trim();

        if (area !== undefined && area !== '') {
            $http.get(API_URL + 'cliente/calculateValor/' + area).success(function(response){

                if (response.success === true) {
                    $scope.valor_total = parseFloat(response.costo).toFixed(2);
                } else {
                    $scope.message_info = 'No existe valor en la tarifa que cubra esta area...';
                    $('#modalMessageInfo').modal('show');
                }

            });
        }
    };

    /*$scope.edit = function (terreno) {

        $scope.t_fecha_process = terreno.fechacreacion;

        $scope.h_codigocliente = terreno.cliente.idcliente;

        $scope.codigo_cliente = terreno.cliente.persona.numdocidentific;
        $scope.documentoidentidad_cliente = terreno.cliente.persona.numdocidentific;
        $scope.nom_cliente = terreno.cliente.persona.razonsocial;
        $scope.direcc_cliente = terreno.cliente.persona.direccion;
        $scope.telf_cliente = terreno.cliente.telefonoprincipaldomicilio;
        $scope.telf_trab_cliente = terreno.cliente.telefonoprincipaltrabajo;
        $scope.celular_cliente = terreno.cliente.persona.celphone;

        $scope.t_terreno = terreno.idterreno;
        $scope.nro_terreno = terreno.idterreno;
        $scope.num_solicitud_riego = terreno.idterreno;
        $scope.t_junta = terreno.derivacion.canal.calle.barrio.idbarrio;
        //$scope.t_cultivo = terreno.cultivo.idcultivo;
        $scope.t_tarifa = terreno.tarifa.idtarifa;

        $scope.loadCultivos(terreno.cultivo.idcultivo);

        $scope.t_canal = terreno.derivacion.canal.idcanal;

        $scope.t_area = terreno.area;
        $scope.calculate_caudal = terreno.caudal;
        $scope.valor_total = terreno.valoranual;

        $scope.t_observacion_riego = terreno.observacion;

        $http.get(API_URL + 'editTerreno/getTomas/' + terreno.derivacion.canal.calle.barrio.idbarrio).success(function(response){

            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namecalle, id: response[i].idcalle})
            }
            $scope.tomas = array_temp;

            $scope.t_toma = terreno.derivacion.canal.calle.idcalle;

            $http.get(API_URL + 'editTerreno/getCanales/' + terreno.derivacion.canal.calle.idcalle).success(function(response){
                var longitud = response.length;
                var array_temp = [];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
                }
                $scope.canales = array_temp;

                $scope.t_canal = terreno.derivacion.canal.idcanal;

                $http.get(API_URL + 'editTerreno/getDerivaciones/' + terreno.derivacion.canal.idcanal).success(function(response){
                    var longitud = response.length;
                    var array_temp = [];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
                    }
                    $scope.derivaciones = array_temp;

                    $scope.t_derivacion = terreno.derivacion.idderivacion;

                    $('#modalActionRiego').modal('show');

                });

            });

        });

    };*/


    $scope.edit = function (terreno) {

        $scope.t_fecha_process = terreno.fechacreacion;

        $scope.h_codigocliente = terreno.idcliente;

        $scope.codigo_cliente = terreno.numdocidentific;
        $scope.documentoidentidad_cliente = terreno.numdocidentific;
        $scope.nom_cliente = terreno.razonsocial;
        $scope.direcc_cliente = terreno.direccion;
        $scope.telf_cliente = terreno.telefonoprincipaldomicilio;
        $scope.telf_trab_cliente = terreno.telefonoprincipaltrabajo;
        $scope.celular_cliente = terreno.celphone;

        $scope.t_terreno = terreno.idterreno;
        $scope.nro_terreno = terreno.idterreno;
        $scope.num_solicitud_riego = terreno.idterreno;
        $scope.t_junta = terreno.idbarrio;
        //$scope.t_cultivo = terreno.cultivo.idcultivo;
        $scope.t_tarifa = terreno.idtarifa;

        $scope.loadCultivos(terreno.idcultivo);

        $scope.t_canal = terreno.idcanal;

        $scope.t_area = terreno.area;
        $scope.calculate_caudal = terreno.caudal;
        $scope.valor_total = terreno.valoranual;

        $scope.t_observacion_riego = terreno.observacion;

        $http.get(API_URL + 'editTerreno/getTomas/' + terreno.idbarrio).success(function(response){

            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namecalle, id: response[i].idcalle})
            }
            $scope.tomas = array_temp;

            $scope.t_toma = terreno.idcalle;

            $http.get(API_URL + 'editTerreno/getCanales/' + terreno.idcalle).success(function(response){
                var longitud = response.length;
                var array_temp = [];
                for(var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
                }
                $scope.canales = array_temp;

                $scope.t_canal = terreno.idcanal;

                $http.get(API_URL + 'editTerreno/getDerivaciones/' + terreno.idcanal).success(function(response){
                    var longitud = response.length;
                    var array_temp = [];
                    for(var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].nombrederivacion, id: response[i].idderivacion})
                    }
                    $scope.derivaciones = array_temp;

                    $scope.t_derivacion = terreno.idderivacion;

                    $('#modalActionRiego').modal('show');

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
            file: $scope.file

            //idsolicitud: $scope.num_solicitud
        };

        console.log(solicitud);
        console.log($scope.nro_terreno);

        Upload.upload({
            url: API_URL + 'editTerreno/update/' + $scope.nro_terreno,
            method: 'POST',
            data: solicitud
        }).success(function(data, status, headers, config) {
            console.log(data);
            console.log(status);
            console.log(headers);
            console.log(config);
            if (data.success == true) {
                $scope.initLoad(1);
                $('#modalActionRiego').modal('hide');
                $scope.message = 'Se ha editado correctamente la informacion del Terreno...';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }
            else {
            }
        });

        /*$http.put(API_URL + 'editTerreno/' + $scope.num_terreno_edit, solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $('#modalEdit').modal('hide');
                $scope.message = 'Se ha editado correctamente la informacion del Terreno...';
                $('#modalMessage').modal('show');
            }

        });*/

    };

    $scope.openEscrituras = function (url) {
        window.open(url);
    };

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };

    $scope.initLoad(1);

    $('.datepicker').datetimepicker({
        locale: 'es',
        viewMode: 'years',
        format: 'YYYY'
    }).on('dp.change', function (e) {
        $scope.getByFilter();
    });
});

$(function(){

    $('[data-toggle="tooltip"]').tooltip();



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
