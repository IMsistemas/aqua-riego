app.controller('derivacionesController', function($scope, $http, API_URL) {
    //retrieve derivaciones listing from API
    $scope.derivaciones=[];
    //document.getElementById("idderivacion").disabled = true;
    console.log($scope.idtoma);
    $scope.idderivacion="";
    $scope.descripcionderivacion="";
    $scope.idderivacion_del=0;
    $scope.initLoad = function(){
    $http.get(API_URL + "derivaciones/"+$scope.idtoma)
        .success(function(response) {
                $scope.derivaciones = response;        

            });
    }
    $scope.initLoad();
    $scope.ordenarColumna = 'estaprocesada';
    //show modal form
    $scope.toggle = function(modalstate, idderivacion, descripcionderivacion) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Nueva derivacion";
                $http.get(API_URL + 'derivaciones/maxid')
                        .success(function(response) {
                            console.log(response);
                            $scope.idderivacion = response;
                            $scope.descripcionderivacion = "";
                        });
                
                break;
            case 'edit':
                $scope.form_title = "Editar derivacion";
                $scope.idderivacion = idderivacion;
                $scope.descripcionderivacion=descripcionderivacion.trim();  
                break;
            default:
                break;
        }
         $('#myModal').modal('show');
     
    }

    //al mo mento que le den click al ng-click getInfo() ejecutamos la funcion

    //save new record / update existing record
    $scope.save = function(modalstate, idderivacion) {
        var url = API_URL + "derivaciones/gestion";     
        
        //append derivacion id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/actualizarderivacion/" + idderivacion;
        }else{
            url += "/guardarderivacion/"+$scope.idtoma ;
        }
         $scope.derivacion={
            idderivacion: $scope.idderivacion,
            descripcionderivacion: $scope.descripcionderivacion
        };
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.derivacion),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            $scope.initLoad();
            $('#myModal').modal('hide');
            console.log(response);
            $scope.message = response;
             $('#modalMessage').modal('show');
             setTimeout("$('#modalMessage').modal('hide')",5000);
        }).error(function(response) {
            console.log($scope.derivacion);
            console.log(response);
            alert('Ha ocurrido un error');
        });
    }

    //delete record
     $scope.showModalConfirm = function(idderivacion,descripcionderivacion){
        $scope.idderivacion_del = idderivacion;
        $scope.derivacion_seleccionado = descripcionderivacion;
        $('#modalConfirmDelete').modal('show');
    }

    $scope.destroyDerivacion = function(){
        $http.delete(API_URL + 'derivaciones/gestion/eliminarderivacion/' + $scope.idderivacion_del).success(function(response) {
            $scope.initLoad();
            $('#modalConfirmDelete').modal('hide');
            $scope.idcanton_del = 0;
            $scope.message = response;
            $('#modalMessage').modal('show')
            setTimeout("$('#modalMessage').modal('hide')",5000);
            });
    }
});
