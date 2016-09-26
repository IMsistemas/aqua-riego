    app.controller('clientesController', function($scope, $http, API_URL) {
    //retrieve clientes listing from API
    $scope.clientes=[];
    $scope.telprincipal;
    $scope.telsecundario;
    $scope.celular;
    //$scope.fecha=0;
     $scope.initLoad = function(){
    $http.get(API_URL + "clientes/gestion")
        .success(function(response) {
                $scope.clientes = response;             

            });
    }
    $scope.initLoad();
    $scope.ordenarColumna = 'estaprocesada';
    //show modal form
    $scope.toggle = function(modalstate, codigocliente) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.form_title = "Nuevo Cliente";
                break;
            case 'edit':
                $scope.form_title = "Editar Cliente";
                $scope.codigocliente = codigocliente;
                $http.get(API_URL + 'clientes/gestion/' + codigocliente)
                        .success(function(response) {
                            $scope.cliente = response;
                            $scope.telprincipaldomicilio=$scope.cliente.telefonoprincipaldomicilio.trim();
                            $scope.telsecundariodomicilio=$scope.cliente.telefonosecundariodomicilio.trim();
                            $scope.celular=$scope.cliente.celular.trim();
                            $scope.telprincipaltrabajo=$scope.cliente.telefonoprincipaltrabajo.trim();
                            $scope.telsecundariotrabajo=$scope.cliente.telefonosecundariotrabajo.trim();
                        });
                break;
            default:
                break;
        }
          $('#myModal').modal('show');
     
    } 

    //al mo mento que le den click al ng-click getInfo() ejecutamos la funcion

    //save new record / update existing record
    $scope.save = function(modalstate, codigocliente) {
        var url = API_URL + "clientes/gestion";    
        console.log(modalstate); 
        
        //append cliente id to the URL if the form is in edit mode
        if (modalstate === 'edit'){
            url += "/actualizarcliente/" + codigocliente;
            $scope.cliente.telefonoprincipaldomicilio=$scope.telprincipaldomicilio;
            $scope.cliente.telefonosecundariodomicilio= $scope.telsecundariodomicilio;
            $scope.cliente.celular=$scope.celular;
            $scope.cliente.telefonoprincipaltrabajo=$scope.telprincipaltrabajo;
            $scope.cliente.telefonosecundariotrabajo= $scope.telsecundariotrabajo;
        }else{
            url += "/guardarcliente" ;
        }
        console.log($scope.cliente);
        
        $http({
            method: 'POST',
            url: url,
            data: $.param($scope.cliente),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) {
            $scope.initLoad();
            console.log(response);
             $('#myModal').modal('hide');
                $scope.message = response;
             $('#modalMessage').modal('show');
             //setTimeout("$('#modalMessage').modal('hide')",5000);
            console.log(response);
        }).error(function(response) {
            console.log(response);
            alert('This is embarassing. An error has occured. Please check the log for details');
        });
    }

    //delete record
    $scope.confirmDelete = function(codigocliente) {
        var isConfirmDelete = confirm('¿Seguro que decea guardar el registro?');
        if (isConfirmDelete) {
            $http({
                method: 'POST',
                url: API_URL + 'clientes/gestion/eliminarcliente/' + codigocliente,
            }).success(function(data) {
                    console.log(data);
                    location.reload();
            }).error(function(data) {
                    console.log(data);
                    alert('Unable to delete');
            });
        } else {
            return false;
        }
    }
});
