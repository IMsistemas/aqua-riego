app.controller('canalesController', function($scope, $http, API_URL) {
    //retrieve canals listing from API
    $scope.canales=[];
    document.getElementById("idcanal").disabled = true;
    $scope.idcanal="";
    $scope.descripcioncanal="";
    $scope.idcanal_del=0;
    $scope.initLoad = function(){
    $http.get(API_URL + "canales/gestion/")
        .success(function(response) {
                console.log(response);
                $scope.canales = response;        

            });
    }
    $scope.initLoad();
    $scope.ordenarColumna = 'estaprocesada';
    //show modal form
    $scope.toggle = function(modalstate, idcanal, descripcioncanal) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Nuevo canal";
                $http.get(API_URL + 'canales/maxid')
                        .success(function(response) {
                            console.log(response);
                            $scope.idcanal = response;
                            $scope.descripcioncanal = "";
                        });
                
                break;
            case 'edit':
                $scope.form_title = "Editar canal";
                $scope.idcanal = idcanal;
                $scope.descripcioncanal=descripcioncanal.trim();  
                break;
            default:
                break;
        }
         $('#myModal').modal('show');
     
    }

    //al mo mento que le den click al ng-click getInfo() ejecutamos la funcion

    //save new record / update existing record
    $scope.save = function(modalstate, idcanal) {
        var url = API_URL + "canales/gestion";            
        //append canal id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/actualizarcanal/" + idcanal;
        }else{
            url += "/guardarcanal/"+$scope.idparroquia ;
        }
         $scope.canal={
            idcanal: $scope.idcanal,
            descripcioncanal: $scope.descripcioncanal
        };
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.canal),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            $scope.initLoad();
            $('#myModal').modal('hide');
            console.log(response);
            $scope.message = response;
             $('#modalMessage').modal('show');
             setTimeout("$('#modalMessage').modal('hide')",5000);
        }).error(function(response) {
            console.log($scope.canal);
            console.log(response);
            alert('Ha ocurrido un error');
        });
    }

    //delete record
     $scope.showModalConfirm = function(idcanal,descripcioncanal){
        $scope.idcanal_del = idcanal;
        $scope.canal_seleccionado = descripcioncanal;
        $('#modalConfirmDelete').modal('show');
    }

    $scope.destroyCanal = function(){
        $http.delete(API_URL + 'canales/gestion/eliminarcanal/' + $scope.idcanal_del).success(function(response) {
            $scope.initLoad();
            $('#modalConfirmDelete').modal('hide');
            $scope.idcanton_del = 0;
            $scope.message = response;
            $('#modalMessage').modal('show')
            setTimeout("$('#modalMessage').modal('hide')",5000);
            });
    }
});
