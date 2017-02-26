
app.controller('configuracionSystemController', function($scope, $http, $parse, API_URL, Upload) {

    $scope.idestablecimiento = 0;

    $scope.fieldconcepto = '';
    $scope.fieldid = '';

    $scope.initLoad = function () {

        var array_temp = [{label: 'SI', id: '1'}, {label: 'NO', id: '0'}];
        $scope.obligadocont = array_temp;
        $scope.s_obligado = '1';

        $http.get(API_URL + '/configuracion/getDataEmpresa/').success(function(response){
            console.log(response);

            if(response.length != 0){
                $scope.t_razonsocial = response[0].razonsocial;
                $scope.t_nombrecomercial = response[0].nombrecomercial;
                $scope.t_direccion = response[0].direccionestablecimiento;

                var temp_ruc = (response[0].ruc).split('-');

                $scope.t_establ = temp_ruc[0];
                $scope.t_pto = temp_ruc[1];
                $scope.t_secuencial = temp_ruc[2];

                $scope.t_contribuyente = response[0].contribuyenteespecial;

                if (response[0].obligadocontabilidad == true) {
                    $scope.s_obligado = '1';
                } else $scope.s_obligado = '0';

                $scope.idestablecimiento = response[0].idestablecimiento;
                $scope.f_logoempresa = response[0].rutalogo;

            }
        });


        $http.get(API_URL + 'configuracion/getImpuestoIVA').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nametipoimpuestoiva, id: response[i].idtipoimpuestoiva})
            }
            $scope.imp_iva = array_temp;
            $scope.iva = '';

            $http.get(API_URL + '/configuracion/getIVADefault').success(function(response){
                console.log(response);

                if(response.length != 0){
                    if (response[0].optionvalue != null && response[0].optionvalue != '') {
                        $scope.idconfiguracionsystem = response[0].idconfiguracionsystem;
                        $scope.iva = parseInt(response[0].optionvalue);
                    }

                }
            });

        });

        $http.get(API_URL + 'configuracion/getImpuestoIVA').success(function(response){
            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for(var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].nametipoimpuestoiva, id: response[i].idtipoimpuestoiva})
            }
            $scope.imp_iva = array_temp;
            $scope.iva = '';

            $http.get(API_URL + '/configuracion/getIVADefault').success(function(response){
                console.log(response);

                if(response.length != 0){
                    if (response[0].optionvalue != null && response[0].optionvalue != '') {
                        $scope.idconfiguracionsystem = response[0].idconfiguracionsystem;
                        $scope.iva = parseInt(response[0].optionvalue);
                    }

                }
            });

        });


    };

    $scope.saveEstablecimiento = function () {

        var ruc = $scope.t_establ + '-' + $scope.t_pto + '-' + $scope.t_secuencial;

        var data = {
            razonsocial: $scope.t_razonsocial,
            nombrecomercial: $scope.t_nombrecomercial,
            direccionestablecimiento: $scope.t_direccion,
            contribuyenteespecial: $scope.t_contribuyente,
            ruc: ruc,
            obligadocontabilidad: $scope.s_obligado,
            rutalogo: $scope.f_logoempresa
        };
        console.log(data);

        var url = API_URL + "/configuracion";

        if ($scope.idestablecimiento != 0){
            url += "/updateEstablecimiento/" + $scope.idestablecimiento;
        }


        Upload.upload({
            url: url,
            method: 'POST',
            data: data
        }).success(function(data, status, headers, config) {
            if (data.success == true) {
                $scope.initLoad();
                $('#modalActionCargo').modal('hide');
                $scope.message = 'Se editó correctamente los datos de la Empresa';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            }
            else {
                $('#modalAction').modal('hide');
                $scope.message_error = 'Error...';
                $('#modalMessageError').modal('show');
            }
        });


        /*$http.put(API_URL + '/configuracion/'+ $scope.idestablecimiento, data ).success(function (response) {

            console.log(response);

            if (response.success == true) {
                $scope.initLoad();
                $('#modalActionCargo').modal('hide');
                $scope.message = 'Se editó correctamente los datos de la Empresa';
                $('#modalMessage').modal('show');
                $scope.hideModalMessage();
            } else {

            }

        }).error(function (res) {

        });*/
    }

    $scope.hideModalMessage = function () {
        setTimeout("$('#modalMessage').modal('hide')", 3000);
    };



    $scope.showPlanCuenta = function (field_concepto, field_id) {

        $scope.fieldconcepto = field_concepto;
        $scope.fieldid = field_id;

        $http.get(API_URL + 'configuracion/getPlanCuenta').success(function(response){
            $scope.cuentas = response;
            $('#modalPlanCuenta').modal('show');
        });

    };

    $scope.selectCuenta = function () {

        var selected = $scope.select_cuenta;

        var fieldconcepto = $parse($scope.fieldconcepto);
        fieldconcepto.assign($scope, selected.concepto);

        var fieldid = $parse($scope.fieldid);
        fieldid.assign($scope, selected.idplancuenta);

        $('#modalPlanCuenta').modal('hide');

    };

    $scope.click_radio = function (item) {
        $scope.select_cuenta = item;
    };

    $scope.updateIvaDefault = function () {

        var data = {
            optionvalue: $scope.iva
        };
        console.log(data);

        $http.put(API_URL + '/configuracion/updateIvaDefault/'+ $scope.idconfiguracionsystem, data ).success(function (response) {

         console.log(response);

         if (response.success == true) {
         $scope.initLoad();
         $('#modalActionCargo').modal('hide');
         $scope.message = 'Se editó correctamente los datos de la Empresa';
         $('#modalMessage').modal('show');
         $scope.hideModalMessage();
         } else {

         }

         }).error(function (res) {

         });
    }


    $scope.initLoad();


});




$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function fecha(){
    var f = new Date();
    var fecha = "";
    var dd = f.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = f.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;
    var yyyy = f.getFullYear();
    fecha = dd + "\/" + mm + "\/" + yyyy;

    return fecha;
}

function convertDatetoDB(now, revert){
    if (revert == undefined){
        var t = now.split('/');
        return t[2] + '-' + t[1] + '-' + t[0];
    } else {
        var t = now.split('-');
        return t[2] + '/' + t[1] + '/' + t[0];
    }
}

