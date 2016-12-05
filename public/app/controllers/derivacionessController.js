app.controller('derivacionessController', function($scope, $http, API_URL) {

    $scope.derivacions = [];
    $scope.idderiv_del = 0;

    $scope.initLoad = function () {
        $http.get(API_URL + 'derivaciones/getDerivaciones').success(function (response) {
           $scope.derivacions = response;

        });
    };

    $scope.FiltroCanal = function () {
        /*$http.get(API_URL + 'derivaciones/getCanaless').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--CANALES--', id: 0}];
            //var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canaless = array_temp;
            $scope.s_canaless = 0;

        });*/

        $scope.canaless = [{label: '--CANALES--', id: 0}];
        $scope.s_canaless = 0;
    };

    $scope.FiltroCalle = function () {
      /*  $http.get(API_URL + 'derivaciones/getCalles').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--TOMAS--', id: 0}];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calless = array_temp;
            $scope.s_calle = 0;
        });*/
        $scope.calless = [{label: '--TOMAS--', id: 0}];
        $scope.s_calle = 0;

    };

    $scope.FiltroBarrio = function () {
        $http.get(API_URL + 'derivaciones/getBarrios').success(function (response) {
            console.log(response);
            var longitud = response.length;
            var array_temp = [{label: '--JUNTAS MODULARES--', id: 0}];

            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrebarrio, id: response[i].idbarrio})
            }
            $scope.barrioss = array_temp;
            $scope.s_barrio = 0;
        });
    };

    $scope.viewModalAdd = function () {

        $http.get(API_URL + 'derivaciones/getCanales').success(function (response) {
            console.log(response);
            var longitud = response.length;
            //var array_temp = [{label: '--Seleccione--', id: 0}];
            var array_temp = [];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canals = array_temp;
        });

        $http.get(API_URL + 'derivaciones/getLastID').success(function(response){
            $scope.codigo = response.id;
            $scope.date_ingreso = now();

            $scope.nombrederi = '';
            $scope.observacionderi = '';

            $('#btn-save').prop('disabled', true);

            $('#modalNueva').modal('show');
        });

    }

    $scope.saveDeri = function () {
        $('#btn-save').prop('disabled', true);
        var data = {
            nombrederivacion: $scope.nombrederi,
            observacion: $scope.observacionderi,
            idcanal: $scope.t_canal
        };
        $http.post(API_URL + 'derivaciones', data ).success(function (response) {

            $scope.initLoad();

            $('#modalNueva').modal('hide');
            $scope.message = 'Se insertó correctamente la Derivación';
            $('#modalMessage').modal('show');
            $scope.hideModalMessage();

        }).error(function (res) {

        });

    };

    /*$scope.editar = function ()  {
        var c = 0;
        for (var i = 0; i <  $scope.derivacions.length; i++)
        {
            if( $scope.derivacions[i].nombrederivacion == ""){
                c ++ ;
            }
        }
        console.log(c);
        if(c > 0 )
        {
            $scope.message_error  = 'Existen Derivaciones con nombres en blanco, por favor llene ese campo... ';
            $('#modalMessageError').modal('show');
        } else {
            var arr_deri = {arr_deri: $scope.derivacions};

            $http.post(API_URL + 'derivaciones/editar_derivaciones', arr_deri).success(function (response) {
                console.log(response);
                $scope.initLoad();
                $scope.message = 'Se editaron correctamente las Derivaciones';
                $('#modalMessage').modal('show');
            });
        }
           /* var arr_deri = { arr_deri: $scope.derivacions };

        $http.post(API_URL + 'derivaciones/editar_derivaciones', arr_deri).success(function(response){
            console.log(response);
            $scope.initLoad();
            $scope.message = 'Se editaron correctamente las Derivaciones';
            $('#modalMessage').modal('show');
        });
    };*/

    $scope.showModalDelete = function (item) {
        $scope.idderiv_del = item.idderivacion;
        $scope.nom_deriv = item.nombrederivacion;
        $('#modalDelete').modal('show');
    };

    $scope.delete = function(){
        $http.delete(API_URL + 'derivaciones/' + $scope.idderiv_del).success(function(response) {
            $scope.initLoad();
            $('#modalDelete').modal('hide');
            $scope.idderiv_del = 0;
            $scope.message = 'Se eliminó correctamente la Derivación seleccionada...';
            $('#modalMessage').modal('show');
            $scope.hideModalMessage();
        });
    };

    $scope.editar = function ()  {
        var c = 0;
        for (var i = 0; i <  $scope.derivacions.length; i++)
        {
            if( $scope.derivacions[i].nombrederivacion == ""){
                c ++ ;
            }
        }
        console.log(c);
        if(c > 0 )
        {
            $scope.message_error  = 'Existen Derivaciones con nombres en blanco, por favor llene ese campo... ';
            $('#modalMessageError').modal('show');
        } else {

            var arr_deriva = {arr_deriva: $scope.derivacions};

            $http.post(API_URL + 'derivaciones/editar_derivaciones', arr_deriva).success(function (response) {
                console.log(response);
                $scope.initLoad();
                $scope.message = 'Se editaron correctamente las Derivaciones';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            });
        }
    };

    $scope.FiltrarPorBarrio = function (){
        $scope.FiltroCanal();
        $http.get(API_URL + 'derivaciones/getCalleByBarrio/'+ $scope.s_barrio).success(function (response) {
            var longitud = response.length;
            var array_temp = [{label: '--TOMAS--', id: 0}];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecalle, id: response[i].idcalle})
            }
            $scope.calless = array_temp;
            $scope.s_calle = 0;
        });
        $scope.aux = $scope.s_barrio;
        if($scope.aux > 0)
        {
            $http.get(API_URL + 'derivaciones/getDerivacionesByBarrio1/'+ $scope.aux).success(function(response) {
                console.log(response);
                //$scope.canals = response;
                var array_temp = [];
                for(var i = 0; i < response.length; i++){

                    for(var j = 0; j < (response[i].canal).length; j++) {

                        for (var k = 0; k < (response[i].canal[j].derivacion).length; k++)
                        {
                            array_temp.push(response[i].canal[j].derivacion[k]);
                        }
                    }
                }
                $scope.derivacions = array_temp;
            });
        }
        else {  $scope.initLoad();
        }
    }

    $scope.FiltrarPorCalle = function (){
        $http.get(API_URL + 'derivaciones/getCanalesByCalle/'+ $scope.s_calle).success(function (response) {
            var longitud = response.length;
            var array_temp = [{label: '--CANALES--', id: 0}];
            for (var i = 0; i < longitud; i++) {
                array_temp.push({label: response[i].nombrecanal, id: response[i].idcanal})
            }
            $scope.canaless = array_temp;
            $scope.s_canaless = 0;
        });

        $scope.aux2 = $scope.s_calle;

        if($scope.aux2 > 0)
        {
            $http.get(API_URL + 'derivaciones/getDerivacionesByCalle/'+ $scope.s_calle).success(function(response) {
                console.log(response);
                var array_temp = [];
                for(var i = 0; i < response.length; i++){
                    for(var j = 0; j < (response[i].derivacion).length; j++){
                        array_temp.push((response[i].derivacion)[j]);
                    }
                }
                $scope.derivacions = array_temp;
            });
        }
        else {  $scope.FiltrarPorBarrio();
        }
    }

    $scope.FiltrarPorCanales = function (){
        $scope.aux2 = $scope.s_canaless;

        if($scope.aux2 > 0)
        {
            $http.get(API_URL + 'derivaciones/getDerivacionesByCanal/'+ $scope.s_canaless).success(function(response) {
                console.log(response);
                $scope.derivacions = response;
            });
        }
        else {  $scope.FiltrarPorCalle();
        }
    }

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };


    $scope.initLoad();
    $scope.FiltroCanal();
    $scope.FiltroCalle();
    $scope.FiltroBarrio();

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