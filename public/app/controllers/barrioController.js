
app.controller('barrioController', function($scope, $http, API_URL) {

    $scope.barrios = [];
    $scope.idbarrio_del = 0;
    $scope.idcalle_delete=0;
    $scope.canales_calle = 0;
    $scope.aux_calles = [];
    $scope.barrio_actual = 0 ;
    $scope.aux1 = 0 ;
    $scope.calle_actual = 0;
    $scope.calless = [];
    $scope.barrio = [];
    $scope.aux_canales = [];
    $scope.canal_actual = 0;
    $scope.aux_derivaciones = [];
    $scope.idcanal_delete=0;


    $scope.initLoad = function () {
        $http.get(API_URL + 'barrio/getBarrios').success(function(response){
           // console.log(response);
            $scope.barrios = response;
        });
    };

    $scope.viewModalAdd = function () {

        $http.get(API_URL + 'barrio/getParroquias').success(function(response){
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nombreparroquia, id: response[i].idparroquia})
            }
            $scope.parroquias = array_temp;
        });


        $http.get(API_URL + 'barrio/getLastID').success(function(response){
            console.log(response);

            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrebarrio = '';
            $scope.observacionBarrio = '';

            $('#modalNueva').modal('show');
        });


    };

    $scope.saveBarrio = function () {
        var data = {
            nombrebarrio: $scope.nombrebarrio,
            idparroquia: $scope.t_parroquias,
            observacion: $scope.observacionBarrio
        };

        $http.post(API_URL + 'barrio', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente la Junta Modular';
            $('#modalMessage').modal('show');

        }).error(function (res) {

        });

    };

    $scope.showModalInfo = function (item) {
        $scope.name_junta = item.nombrebarrio;
        $scope.fecha_ingreso = item.fechaingreso;

        var array_tomas = item.calle;
        var text = '';
        var calles = [];

        for (var e = 0; e < array_tomas.length; e++){
            calles.push(array_tomas[e].idcalle);
            text += array_tomas[e].nombrecalle + ','
        }
        var data = {
            idcalles: calles
        };

        $http.get(API_URL + 'barrio/getCanals/' + JSON.stringify(data)).success(function(response) {
            var aux='';
            var arr_canales = [];

            //console.log(response);
            for(var i  = 0; i < response.length; i++) {
                for(var a  = 0; a < response[i].length; a++){
                    arr_canales.push(response[i][a].idcanal);
                    aux += response[i][a].nombrecanal + ',';
                }
            }
            $scope.getderivaciones(arr_canales);
           // console.log(aux);
            $scope.junta_canales = aux;
            $scope.junta_tomas = text;
        });

        $('#modalInfo').modal('show');
    };

    $scope.getderivaciones = function (arr_canales) {
        //console.log(arr_canales);
        var data = {
            idcanales: arr_canales
        };
       // console.log(data);
        $http.get(API_URL + 'barrio/getderivaciones/' + JSON.stringify(data)).success(function(response) {
            var aux='';
           // console.log(response);
            for(var i  = 0; i < response.length; i++) {
                for(var a  = 0; a < response[i].length; a++){
                    aux += response[i][a].nombrederivacion + ',';
                }
            }
            $scope.junta_derivacion = aux;
        });

    };

    $scope.showModalDelete = function (item) {
        $scope.idbarrio_del = item.idbarrio;
        $scope.nom_junta_modular = item.nombrebarrio;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){

        $http.delete(API_URL + 'barrio/' + $scope.idbarrio_del).success(function(response) {
            $('#modalDelete').modal('hide');
            if(response.success == true){
                console.log(response);
                $scope.initLoad();
                $scope.idbarrio_del = 0;
                $scope.message = 'Se elimino correctamente la Junta Modular seleccionada...';
                $('#modalMessage').modal('show');
            } else if(response.success == false && response.msg == 'exist_calle') {
                $scope.message_error = 'La Junta no puede ser eliminada porque contiene Tomas...';
                $('#modalMessageError').modal('show');
            }
        });
    };

    $scope.saveCalle = function () {
        var data = {
            nombrecalle: $scope.nombrecalle,
            idbarrio: $scope.id_barrio,
            observacion: $scope.observacionCalle
        };
        $http.post(API_URL + 'calle', data ).success(function (response) {
            $scope.initLoad();
           // $('#modalNuevaToma2').modal('hide');
            $('#modalNuevaToma').modal('hide');
            $scope.message = 'Se insertó correctamente la Toma';
            $('#modalMessage').modal('show');
            if( $scope.aux1==1) {
                /*setTimeout(function () {
                    $('#modalMessage').modal('hide');
                }, 500);*/
                $scope.showModalAction($scope.barrio);
            }

        }).error(function (res) {
        });
    };

    $scope.show_toma = function (idbarrio,aux0, barrio)   {
        if(barrio !== undefined && barrio !== null){
            $scope.barrio = barrio;}

        $http.get(API_URL + 'barrio/getBarrio').success(function (response) {
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrios2 = array_temp;
            $scope.id_barrio = idbarrio;
        });
        $http.get(API_URL + 'calle/getLastID').success(function(response){
           // console.log(response);

            $scope.codigo_toma = response.id;
            $scope.date_ingreso_toma = now();

            $scope.nombrecalle = '';
            $scope.observacionCalle = '';
            $scope.aux1 = aux0 ;
            $('#modalTomas').modal('hide');
            $('#modalNuevaToma').modal('show');
        });
    };

    $scope.editar = function ()  {
        var arr_barrio = { arr_barrio: $scope.barrios };
        console.log(arr_barrio);
        $http.post(API_URL + 'barrio/editar_Barrio', arr_barrio).success(function(response){
          //  console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Juntas Modulares';
            $('#modalMessage').modal('show');
        });
    };

    $scope.showModalAction = function (item) {
        //console.log(item);
        $scope.junta_n = item.nombrebarrio;
        $scope.calless = item.calle ;
        $scope.barrio_actual = item.idbarrio;
        $scope.barrio = item;

        var data = {
            calles: item.calle
        };
       // console.log(data);

       $http.get(API_URL + 'barrio/calles/' + item.idbarrio).success(function(response) {
           $scope.aux_calles = response;

       });
        $scope.initLoad();
        $('#modalTomas').modal('show');

    };

    $scope.showModalDeleteCalle = function (item) {
        console.log(item);
        $scope.idcalle_delete = item.idcalle;
        $scope.nom_calle_delete = item.nombrecalle;
        $('#modalDeleteCalle').modal('show');
    };

    $scope.deleteCalleEnBarrio = function(){
        $http.delete(API_URL + 'calle/' + $scope.idcalle_delete).success(function(response) {
            $('#modalDeleteCalle').modal('hide');
            if(response.success == true){
                $scope.initLoad();
                $scope.idcalle_delete = 0;
                $scope.message = 'Se elimino correctamente la Toma seleccionada...';
                $('#modalMessage').modal('show');
                /*setTimeout(function(){
                    $('#modalMessage').modal('hide');
                }, 500);*/
                $scope.showModalAction($scope.barrio);

            } else if(response.success == false && response.msg == 'exist_canales') {
                $scope.message_error = 'La Toma no puede ser eliminada porque contiene Canales...';
                $('#modalMessageError').modal('show');
            }
        });
    };

    $scope.editarCalles = function() {
        var arr_calle = { arr_calle: $scope.aux_calles };
        console.log(arr_calle);
        $http.post(API_URL + 'barrio/editar_calle', arr_calle).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Tomas';
            $('#modalMessage').modal('show');

            /*setTimeout(function(){
                $('#modalMessage').modal('hide');
            }, 500);*/
            $scope.showModalAction($scope.barrio);
        });
    }

    $scope.showModalActionCanal = function (item){
        console.log(item);
        $('#modalTomas').modal('hide');
       // console.log(item);
        $scope.toma_n = item.nombrecalle;
        $scope.aux_canales = item.canales ;
        $scope.calle_actual = item.idcalle;
        $scope.canales = item;

        var data = {
            canales: item.canales
        };
        //console.log(data);

        $http.get(API_URL + 'barrio/canales/' + item.idcalle).success(function(response) {
            $scope.aux_canales = response;
        });
        $scope.initLoad();
        $('#modalCanales').modal('show');
    }

    $scope.show_canal = function () {
        $http.get(API_URL + 'barrio/getCalle').success(function (response) {
           //console.log(response);
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calles2 = array_temp;
            $scope.id_toma =  $scope.calle_actual;
        });
        $http.get(API_URL + 'barrio/getLastIDCanal').success(function(response){
            // console.log(response);

            $scope.codigo_canal = response.id;
            $scope.date_ingreso_canal = now();

            $scope.nombrecanal = '';
            $scope.observacionCanal = '';

            $('#modalTomas').modal('hide');
            $('#modalNuevoCanal').modal('show');
        });
    };

    $scope.saveCanal = function () {
        var data = {
            nombrecanal: $scope.nombrecanal,
            idcalle: $scope.id_toma,
            observacion: $scope.observacionCanal
        };
        $http.post(API_URL + 'canal', data ).success(function (response) {
            $scope.initLoad();
            // $('#modalNuevaToma2').modal('hide');
            $('#modalNuevoCanal').modal('hide');
            $scope.message = 'Se insertó correctamente el Canal';
            $('#modalMessage').modal('show');
                /*setTimeout(function () {
                    $('#modalMessage').modal('hide');
                }, 500);*/
            console.log($scope.aux_calles);
                $scope.showModalActionCanal($scope.canales);


        }).error(function (res) {
        });
    };

    $scope.editarCanal = function() {
        var arr_canales = {
            arr_canales: $scope.aux_canales };
            console.log(arr_canales);

        $http.post(API_URL + 'barrio/editar_canales', arr_canales).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente los Canales';
            $('#modalMessage').modal('show');

            /*setTimeout(function(){
                $('#modalMessage').modal('hide');
            }, 500);*/
            $scope.showModalActionCanal($scope.canales);
        });
    }

    $scope.showModalDeleteCanal = function (item) {
        console.log(item);
        $scope.idcanal_delete = item.idcanal;
        $scope.nom_canal_delete = item.nombrecanal;
        $('#modalDeleteCanal').modal('show');
    };

    $scope.deleteCanal = function(){
        $http.delete(API_URL + 'canal/' + $scope.idcanal_delete).success(function(response) {
            $('#modalDeleteCanal').modal('hide');
            if(response.success == true){
                $scope.initLoad();
                $scope.idcanal_delete = 0;
                $scope.message = 'Se elimino correctamente el Canal seleccionado...';
                $('#modalMessage').modal('show');
                /*setTimeout(function(){
                    $('#modalMessage').modal('hide');
                }, 500);*/
                $scope.showModalActionCanal($scope.canales);

            } else if(response.success == false && response.msg == 'exist_derivacion') {
                $scope.message_error = 'El Canal no puede ser eliminado porque contiene derivaciones...';
                $('#modalMessageError').modal('show');
            }
        });
    };

    $scope.showModalActionDerivaciones = function (item){
        console.log(item);
        $('#modalCanales').modal('hide');
        $scope.canal_n = item.nombrecanal;
        $scope.aux_derivaciones = item.derivacion ;
        $scope.canal_actual = item.idcanal;
        $scope.derivaciones = item;
        $scope.initLoad();
        $('#modalDerivaciones').modal('show');
    }

    $scope.show_derivacion = function ()   {
        $http.get(API_URL + 'barrio/getCanal').success(function (response) {
            //console.log(response);
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canal2 = array_temp;
            $scope.id_canal =  $scope.canal_actual;
        });
        $http.get(API_URL + 'barrio/getLastIDDerivaciones').success(function(response){
            // console.log(response);

            $scope.codigo_deri = response.id;
            $scope.date_ingreso_deri = now();

            $scope.nombrederi = '';
            $scope.observacionDeri = '';

            $('#modalCanal').modal('hide');
            $('#modalNuevaDerivacion').modal('show');
        });
    };

    $scope.saveDeri = function () {
        var data = {
            nombrederivacion: $scope.nombrederi,
            idcanal: $scope.id_canal,
            observacion: $scope.observacionDeri
        };
        $http.post(API_URL + 'derivaciones', data ).success(function (response) {
            $scope.initLoad();
            // $('#modalNuevaToma2').modal('hide');
            $('#modalNuevaDerivacion').modal('hide');
            $scope.message = 'Se insertó correctamente la Derivacion';
            $('#modalMessage').modal('show');
            /*setTimeout(function () {
                $('#modalMessage').modal('hide');
            }, 500);*/
            console.log($scope.aux_calles);
            $scope.showModalActionDerivaciones($scope.derivaciones);


        }).error(function (res) {
        });
    };


    $scope.initLoad();
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