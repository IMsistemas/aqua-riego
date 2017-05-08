(function(){

app.controller('mainController',['$scope','$route', function($scope, $http, API_URL,$route) {

	$scope.titulo = "Inicio";
	$scope.toModulo = "";

	$scope.username = 'Secretaría';

	$scope.list_breadcrumb = [];

    $scope.logoutSystem = function () {

        $http.get(API_URL + '/logout' ).success(function (response) {

            location.reload(true);

        }).error(function (res) {

        });

    };


    $scope.toLogout = function () {
        $('#modalConfirmLogout').modal('show');
    };

    $scope.toModuloRol = function(){
        $scope.titulo = "Rol";
        $scope.toModulo = "rol";
    };

    $scope.toModuloEmpleado = function(){
        $scope.titulo = "Colaboradores";
        $scope.toModulo = "empleado";

        var list = [
            '<li>Personal</li>',
            '<li>Colaboradores</li>'
        ];

        $scope.prepareListBreadcrumb(list);
    }

    $scope.toModuloCliente = function(){
        $scope.titulo = "Clientes";
        $scope.toModulo = "cliente";

        var list = [
            '<li>Clientes</li>',
            '<li>Clientes</li>'
        ];

        $scope.prepareListBreadcrumb(list);
    }

	$scope.toModuloProvincia = function(){		
		$scope.titulo = "Provincias";
		$scope.toModulo = "provincias";
	}

	$scope.toModuloDescuento = function(){		
		$scope.titulo = "Descuentos";
		$scope.toModulo = "descuentos";
	}

	$scope.toModuloCanton = function(idprovincia){		
		$scope.idprovincia = idprovincia;	
		$scope.titulo = "Cantones";
		$scope.toModulo = "cantones";
	}

    $scope.toModuloConfiguracion = function(){
        $scope.titulo = "Configuración";
        $scope.toModulo = "configuracion";
    }

	$scope.toModuloPlanCuentas = function(){			
		$scope.titulo = "Plan de Cuentas";
		$scope.toModulo = "Contabilidad";
	}

    $scope.toModuloGuiaRemision = function(){
        $scope.titulo = "Ventas";
        $scope.toModulo = "guiaremision";
    }

	$scope.toModuloParroquia = function(idcanton){
		$scope.idcanton = idcanton;		
		$scope.titulo = "Parroquias";
		$scope.toModulo = "parroquias";
	}

	$scope.toModuloBarrio = function(){			
		$scope.titulo = "Juntas Modulares";
		$scope.toModulo = "barrio";

	}

	$scope.toModuloCanal = function(){
		$scope.titulo = "Canales";
		$scope.toModulo = "canal";
	}

	$scope.toModuloToma = function(idcanal,descripcioncanal){
		$scope.idcanal = idcanal;						
		$scope.titulo = "Toma :".concat(descripcioncanal);
		$scope.toModulo = "tomas";
	}

	$scope.toModuloDerivacion = function(){				
		$scope.titulo = "Derivación";
		$scope.toModulo = "derivaciones";
	}

	$scope.toModuloCalle = function(){			
		$scope.titulo = "Tomas";
		$scope.toModulo = "calle";
	}

	$scope.toModuloCargo = function(){
		$scope.titulo = "Cargos";
		$scope.toModulo = "cargo";

		var list = [
			'<li>Personal</li>',
			'<li>Cargos</li>'
		];

		$scope.prepareListBreadcrumb(list);
	}

    $scope.toModuloDepartamento = function(){
        $scope.titulo = "Departamento";
        $scope.toModulo = "departamento";
    }


	$scope.toModuloRecaudacion = function(){		
		$scope.titulo = "Recaudación";
		$scope.toModulo = "recaudacion";
	}

	$scope.toModuloSolicitud = function(){	
		$scope.titulo = "Solicitudes";
		$scope.toModulo = "solicitud";
	}
	$scope.toModuloSolicitudEspera = function(){	
		$scope.titulo = "Solicitudes";
		$scope.toModulo = "suministros/espera";
	}

	$scope.toModuloSuministro = function(){		
		$scope.titulo = "Terrenos";
		$scope.toModulo = "editTerreno";
	}
	
	$scope.toModuloTarifa = function(){		
		$scope.titulo = "Tarifas";
		$scope.toModulo = "tarifa";
	}

    $scope.toModuloCultivo = function(){
        $scope.titulo = "Cultivo";
        $scope.toModulo = "cultivo";
    }

	$scope.toModuloProveedores = function(){		
		$scope.titulo = "Proveedores";
		$scope.toModulo = "proveedor";
	}

    $scope.toModuloTransportistas = function(){
        $scope.titulo = "Crear Transportistas";
        $scope.toModulo = "transportista";
    }

    $scope.toModuloInventario = function(){
        $scope.titulo = "Inventario";
        $scope.toModulo = "Inventario";
    }

    $scope.toModuloCompras = function(){
        $scope.titulo = "Compras Inventario";
        $scope.toModulo = "DocumentoCompras";
    }

	$scope.toModuloVentas = function(){		
		$scope.titulo = "Ventas: Registro Ventas";
		$scope.toModulo = "DocumentoVenta";
	}

	$scope.toModuloComprobantesVentas = function(){		
		$scope.titulo = "Comprobantes Ventas";
		$scope.toModulo = "cuentascobrarcliente";
	}

	$scope.toModuloComprobantesCompras = function(){		
		$scope.titulo = "Comprobantes Compras";
		$scope.toModulo = "cuentascobrarcliente";
	}

	$scope.toModuloRetencionesVentas = function(){		
		$scope.titulo = "Retenciones Ventas";
		$scope.toModulo = "retencionVentas";
	}

	$scope.toModuloRetencionesCompras = function(){		
		$scope.titulo = "Retenciones Compras";
		$scope.toModulo = "retencionCompras";
	}

    $scope.toModuloPuntoVenta = function(){
        $scope.titulo = "Crear Transportistas";
        $scope.toModulo = "puntoventa";
    }

	$scope.toModuloPortafolioProductos = function(){		
		$scope.titulo = "Portafolio de Productos";
		$scope.toModulo = "categoria";
	}

	$scope.toModuloCatalogoProductos = function(){		
		$scope.titulo = "Catálogo de Prodructos";
		$scope.toModulo = "catalogoproducto";
	}

	$scope.toModuloCrearBodegas = function(){		
		$scope.titulo = "Crear Bodegas";
		$scope.toModulo = "bodega";
	}

    $scope.toModuloNomenclador = function(){
        $scope.titulo = "Crear Transportistas";
        $scope.toModulo = "Nomenclador";
    }

	$scope.prepareListBreadcrumb = function (list_module) {
		$scope.list_breadcrumb = [
			"<li><img src='img/ico-aqua.png'></li>",
			"<li>Inicio</li>"
		];

		var breadcrumb = ($scope.list_breadcrumb).concat(list_module);

		$('#list_breadcrumb').html(breadcrumb);

	}
	
	$scope.toModuloCompras = function(){		
		$scope.titulo = "Compras Inventario";
		$scope.toModulo = "compras";
	}

	$scope.prepareListBreadcrumb();
	
}]);
})();

