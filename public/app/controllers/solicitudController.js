
app.filter('formatDate', function(){
    return function(texto){
        return convertDatetoDB(texto, true);
    }
});

app.controller('solicitudController', function($scope, $http, API_URL) {

    $scope.solicitudes = [];

    $scope.estados = [
        { id: 3, name: 'Todos' },
        { id: 2, name: 'En Espera' },
        { id: 1, name: 'Procesado' },
    ];

    $scope.initLoad = function () {
        $http.get(API_URL + 'solicitud/getSolicitudes').success(function(response){
            $scope.solicitudes = response;
        });
    };

    $scope.toggle = function(modalstate, id, numSolicitud) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':

                $scope.t_fecha_ingreso = now();

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

                $('#modalIngSolicitud').modal('show');

                break;
            case 'process':
                $scope.id = id;
                $scope.loadTarifas();
                $scope.loadBarrios();
                $scope.loadCultivos();
                $scope.loadCanales();



                $http.get(API_URL + 'solicitud/getClienteByID/' + id).success(function(response) {
                    $scope.nom_cliente = response.apellido + ' ' + response.nombre;
                    $scope.telf_cliente = response.telefonoprincipaldomicilio;
                    $scope.direcc_cliente = response.direcciondomicilio;
                    $scope.h_codigocliente = id;

                    $scope.num_solicitud = numSolicitud;

                    $scope.t_fecha_process = now();

                    $('#modalProcSolicitud').modal('show');
                });

                break;
            default:
                break;
        }


    };

    $scope.save = function () {

        var url = API_URL + "solicitud";

        var data = {
            fechaingreso: convertDatetoDB($scope.t_fecha_ingreso),
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

        $http.post(url, data ).success(function (response) {
            $scope.initLoad();
            $('#modalIngSolicitud').modal('hide');

        }).error(function (res) {
            console.log(res);
        });

    };

    $scope.searchByFilter = function() {
        var text = null;
        var estado = null;

        if($scope.search != undefined && $scope.search != ''){
            text = $scope.search;
        }

        if ($scope.t_estado != undefined && $scope.t_estado != ''){
            estado = $scope.t_estado;
        }

        var filters = {
            text: text, estado: estado
        };

        $http.get(API_URL + 'solicitud/getByFilter/' + JSON.stringify(filters)).success(function(response){
            $scope.solicitudes = response;
        });
    };

    $scope.loadBarrios = function(){
        $http.get(API_URL + 'solicitud/getBarrios').success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios = array_temp;
        });
    };

    $scope.loadTarifas = function(){
        $http.get(API_URL + 'solicitud/getTarifas').success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombretarifa, id: response[i].idtarifa})
            }
            $scope.tarifas = array_temp;
        });
    };

    $scope.loadCultivos = function(idcultivo){
        $http.get(API_URL + 'solicitud/getCultivos').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: 'Adicionar Nuevo', id: 0}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombrecultivo, id: response[i].idcultivo})
            }
            $scope.cultivos = array_temp;

            if (idcultivo != undefined){
                $scope.t_cultivo = idcultivo;
            }
        });
    };

    $scope.loadCanales = function(){
        $http.get(API_URL + 'solicitud/getCanales').success(function(response){
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

        $http.get(API_URL + 'solicitud/getTomas/' + idcanal).success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripciontoma, id: response[i].idtoma})
            }
            $scope.tomas = array_temp;
        });
    };

    $scope.loadDerivaciones = function(){
        var idtoma = $scope.t_toma;

        $http.get(API_URL + 'solicitud/getDerivaciones/' + idtoma).success(function(response){
            var longitud = response.length;
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].descripcionderivacion, id: response[i].idderivacion})
            }
            $scope.derivaciones = array_temp;
        });
    };

    $scope.showAddCultivo = function(){
        if($scope.t_cultivo == 0) {
            $scope.t_n_cultivo = '';
            $('#modalAddCultivo').modal('show');
        }
    };

    $scope.saveCultivo = function () {
        var cultivo = { name: $scope.t_n_cultivo };

        $http.post(API_URL + 'solicitud/saveCultivo', cultivo).success(function(response){
            $scope.loadCultivos(response.idcultivo);
            $('#modalAddCultivo').modal('hide');
        });
    };

    $scope.calculateCaudal = function () {
        $http.get(API_URL + 'solicitud/getConstante').success(function(response){
            var area = parseInt($scope.t_area);
            var constante = parseFloat(response[0].constante);

            var caudal_result = (area / 10000) * constante;

            $scope.calculate_caudal = caudal_result.toFixed(2);
        });
    };

    $scope.calculateValor = function () {
        var area = $scope.t_area;

        $http.get(API_URL + 'solicitud/calculateValor/' + area).success(function(response){
            $scope.valor_total = parseFloat(response.costo).toFixed(2);
        });
    }

    $scope.processSolicitud = function () {

        var solicitud = {
            fechacreacion: convertDatetoDB($scope.t_fecha_process),
            codigocliente: $scope.h_codigocliente,
            idbarrio: $scope.t_junta,
            idcultivo: $scope.t_cultivo,
            area: $scope.t_area,
            caudal: $scope.calculate_caudal,
            valoranual: $scope.valor_total,
            idtarifa: $scope.t_tarifa,
            idderivacion : $scope.t_derivacion,

            idsolicitud: $scope.num_solicitud
        };

        $http.post(API_URL + 'solicitud/processSolicitud', solicitud).success(function(response){

            if(response.success == true){
                $scope.initLoad();
                $('#modalProcSolicitud').modal('hide');
                $scope.message = 'Se ha procesado la solicitud correctamente...'
                $('#modalMessage').modal('show');
            }

        });

    };

    $scope.info = function (solicitud) {
        $scope.num_solicitud_info = solicitud.idsolicitud;
        $scope.name_cliente = solicitud.apellido + ' ' + solicitud.nombre;
        $scope.fecha_solicitud = convertDatetoDB(solicitud.fechasolicitud, true);
        $scope.address_cliente = solicitud.direcciondomicilio;
        $scope.telf_cliente = solicitud.telefonoprincipaldomicilio;
        $scope.estado_solicitud = 'Procesada';

        $('#modalInfo').modal('show');
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