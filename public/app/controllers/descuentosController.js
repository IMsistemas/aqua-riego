    app.controller('descuentosController', function($scope, $http, API_URL) 
    {
    //retrieve descuentos listing from API
        $scope.descuentos=[];
        $scope.ahora = new Date();
        //$scope.anio="2";
        $scope.validar="false";
        $scope.initLoad = function(){
        $http.get(API_URL + "descuentos/gestion/2015")
            .success(function(response) 
            {
                    $scope.descuentos = response;             
                });
            }
        $scope.generar = function()
        {
            $http.get(API_URL + "descuentos/anio")
            .success(function(response) {
                    $scope.anio = response;  
                    if ($scope.anio<$scope.ahora) {
                        $scope.validar="true";
                    }          
                });
        }
        //$scope.generar();
        $scope.initLoad();
        $scope.ordenarColumna = 'estaprocesada';
        //show modal form

        $scope.toggle = function(modalstate, mes, porcentaje) {
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
                $scope.form_title = "Editar Descuento";
                $scope.mes = mes;
                $scope.porcentaje=porcentaje;
                $('#myModalEditar').modal('show');  
                break;
            default:
                break;
        }
         
     
    }

        //al mo mento que le den click al ng-click getInfo() ejecutamos la funcion

        //save new record / update existing record
        $scope.save = function(modalstate,anio,mes,porcentaje) 
        {
            var url = API_URL + "descuentos/gestion";    
            console.log(modalstate); 
            
            //append descuento id to the URL if the form is in edit mode
            if (modalstate === 'edit')
            {
                url += "/actualizardescuento/" + anio;
                $scope.descuento=
                {
                    mes:mes,
                    porcentaje:porcentaje,
                };

            }else
            {
                url += "/guardardescuento" ;
                       $scope.descuento=
                       {
                            anio:anio,
                            enero: $scope.enero,
                            febrero: $scope.febrero,
                            marzo: $scope.marzo,
                            abril: $scope.abril,
                            mayo: $scope.mayo,
                            junio: $scope.junio
                        };
            }
            
            $http({
                method: 'POST',
                url: url,
                data: $.param($scope.descuento),
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
        $scope.confirmDelete = function(codigodescuento) 
        {
            var isConfirmDelete = confirm('¿Seguro que decea guardar el registro?');
            if (isConfirmDelete) 
            {
                $http
                ({
                    method: 'POST',
                    url: API_URL + 'descuentos/gestion/eliminardescuento/' + codigodescuento,
                }).success(function(data) 
                {
                        console.log(data);
                        location.reload();
                }).error(function(data) 
                {
                        console.log(data);
                        alert('Unable to delete');
                });
            } else 
            {
                return false;
            }
        }
    });
