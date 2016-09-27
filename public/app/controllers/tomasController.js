app.controller('tomasController', function($scope, $http, API_URL) {
    //retrieve tomas listing from API
    $scope.tomas=[];
    document.getElementById("idtoma").disabled = true;
    console.log($scope.idcanal);
    $scope.idtoma="";
    $scope.descripciontoma="";
    $scope.idtoma_del=0;
    $scope.initLoad = function(){
    $http.get(API_URL + "tomas/"+$scope.idcanal)
        .success(function(response) {
                $scope.tomas = response;        

            });
    }
    $scope.initLoad();
    $scope.ordenarColumna = 'estaprocesada';
    //show modal form
    $scope.toggle = function(modalstate, idtoma, descripciontoma) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Nuevo toma";
                $http.get(API_URL + 'tomas/maxid')
                        .success(function(response) {
                            console.log(response);
                            $scope.idtoma = response;
                            $scope.descripciontoma = "";
                        });
                
                break;
            case 'edit':
                $scope.form_title = "Editar toma";
                $scope.idtoma = idtoma;
                $scope.descripciontoma=descripciontoma.trim();  
                break;
            default:
                break;
        }
         $('#myModal').modal('show');
     
    }

    //al mo mento que le den click al ng-click getInfo() ejecutamos la funcion

    //save new record / update existing record
    $scope.save = function(modalstate, idtoma,idcanal) {
        var url = API_URL + "tomas/gestion";    
        $scope.idcanal=idcanal; 
        
        //append toma id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/actualizartoma/" + idtoma;
        }else{
            url += "/guardartoma/"+$scope.idcanal ;
        }
         $scope.toma={
            idtoma: $scope.idtoma,
            descripciontoma: $scope.descripciontoma
        };
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.toma),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            $scope.initLoad();
            $('#myModal').modal('hide');
            console.log(response);
            $scope.message = response;
             $('#modalMessage').modal('show');
             setTimeout("$('#modalMessage').modal('hide')",5000);
        }).error(function(response) {
            console.log($scope.toma);
            console.log(response);
            alert('Ha ocurrido un error');
        });
    }

    //delete record
     $scope.showModalConfirm = function(idtoma,descripciontoma){
        $scope.idtoma_del = idtoma;
        $scope.toma_seleccionado = descripciontoma;
        $('#modalConfirmDelete').modal('show');
    }

    $scope.destroyToma = function(){
        $http.delete(API_URL + 'tomas/gestion/eliminartoma/' + $scope.idtoma_del).success(function(response) {
            $scope.initLoad();
            $('#modalConfirmDelete').modal('hide');
            $scope.idcanton_del = 0;
            $scope.message = response;
            $('#modalMessage').modal('show')
            setTimeout("$('#modalMessage').modal('hide')",5000);
            });
    }
});
