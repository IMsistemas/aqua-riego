

app.controller('NC', function($scope, $http, API_URL) {


$scope.FechaRegistro=now();
$scope.FechaEmision=now();
$scope.VerFactura=2;
$scope.DICliente="";
$scope.Cliente={};
$scope.Bodegas=[];
$scope.Formapago=[];
$scope.PuntoVenta=[];
$scope.PuntoVentaSeleccionado={};
$scope.Configuracion=[];
$scope.mensaje="";
$scope.AgenteVenta="";
$scope.t_establ="";
$scope.t_pto="";
$scope.Bodega="";
$scope.observacion="";
$scope.Allventas=[];
$scope.cmbFormapago="";
$scope.busquedaventa="";

$scope.IdDocumentoVentaedit="0";
$scope.Valida="0";

$scope.Validabodegaprodct="0";
$scope.ValidacionCueContExt="0";

$scope.cmb_estado_fact="A";

    $scope.verifySuministroFactura = function () {
        $http.get(API_URL + 'DocumentoNC/getSuministroByFactura').success(function(response){
            console.log(response);

            $scope.DICliente = response[0].cliente.persona.numdocidentific;
            $scope.BuscarCliente();


            //$http.get(API_URL + 'DocumentoNC/getProductoPorSuministro/' + response[0].cont_catalogitem.codigoproducto).success(function(response0){
            $http.get(API_URL + 'DocumentoNC/getProductoPorSuministro').success(function(response0){
                console.log(response0);

                var longitud = response0.length;

                for (var i = 0; i < longitud; i++) {

                    var precioventa = 0;

                    if (response0[i].idcatalogitem == 7) {
                        precioventa = response[0].valoraguapotable;
                    } else if (response0[i].idcatalogitem == 2) {
                        precioventa = response[0].valoralcantarillado;
                    } else {
                        precioventa = response0[i].precioventa;
                    }

                    var item = {
                        productoObj:{
                            title:response0[i].codigoproducto,
                            originalObject:response0[i]
                        },
                        cantidad: 1,
                        precioU: precioventa,
                        descuento: 0,
                        iva: 0,
                        ice: 0,
                        total: precioventa,
                        producto: response0[i].codigoproducto
                    };


                    $scope.items.push(item);
                }

                $scope.CalculaValores();

            });



        });
    };

    ///---
    $scope.pageChanged = function(newPage) {
        $scope.initLoad(newPage);
    };
    $scope.initLoad = function(pageNumber){

    	if($('#otherFactura').val() == 'true') {
            $scope.VerFactura = 1;
            $scope.verifySuministroFactura();
        } else {
            $scope.VerFactura = 2;
        }

        var filtros = {
            search: $scope.busquedaventa,
            estado: $scope.cmb_estado_fact
        };
        $http.get(API_URL + 'DocumentoNC/getAllFitros?page=' + pageNumber + '&filter=' + JSON.stringify(filtros))
            .success(function(response){
                /*$scope.Allventas=response;
                console.log(response);*/
                $scope.Allventas = response.data;
                $scope.totalItems = response.total;
                console.log(response);
         });
    };
    $scope.initLoad(1);
    ///---
	$scope.NumeroRegistroVenta=function() {
        $http.get(API_URL + 'DocumentoNC/NumRegistroVenta')
        .success(function(response){
        	console.log(response)

        /*NoVenta iddocumentoventa*/
            if(response.iddocumentoventa!=null ){
                $scope.NoVenta=parseInt(response.iddocumentoventa)+1;
                $("#t_secuencial").val(String(parseInt(response.iddocumentoventa)+1));
                $scope.calculateLength("t_secuencial",9);
                $scope.t_secuencial=$("#t_secuencial").val();
            }else{
            	$scope.NoVenta=1;
            	$("#t_secuencial").val("1")
            	$scope.calculateLength("t_secuencial",9);
            	$scope.t_secuencial=$("#t_secuencial").val();
            	
            }
        });
    };
	///---All Facturas
	$scope.AllDocVenta=function (pageNumber) {
        
		$http.get(API_URL + 'DocumentoNC/getAllFitros')
	        .success(function(response){
	            $scope.Allventas=response;
	            console.log(response);
	     });
	};
	///---Cliente
	$scope.BuscarCliente=function () {
		if($scope.DICliente!=""){
			$http.get(API_URL + 'DocumentoNC/getInfoClienteXCIRuc/'+$scope.DICliente)
		        .success(function(response){
		            $scope.Cliente=response[0];
		            console.log($scope.Cliente);
		     });
		}else{
			QuitarClasesMensaje();
	        $("#titulomsm").addClass("btn-warning");
	        $("#msm").modal("show");
	        $scope.Mensaje="Ingrese un número de identificación";
		}
	};
	///---
	$scope.ConfigContable=function(){
		$http.get(API_URL + 'DocumentoNC/porcentajeivaiceotro')
	        .success(function(response){
	            $scope.Configuracion=response;
	            console.log(response);
                for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_COSTO_VENTA"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.Valida="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La Nota de Crédito necesita la cuenta contable de COSTO DE VENTA";
                        }
                    }
                    if($scope.Configuracion[x].Descripcion=="CONT_IVA_NC"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.Valida="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La Nota de Crédito necesita la cuenta contable de IVA DE NC";
                        }
                    }
                }
	            if(String($scope.Configuracion[0].IdContable)==""){
	            	QuitarClasesMensaje();
			        $("#titulomsm").addClass("btn-danger");
			        $("#msm").modal("show");
			        $scope.Mensaje="La Nota de Crédito necesita que llene los campos de configuracion esten llenos para poder realizar esta transaccion";
	            }
	     }).error(function(res){
	     	QuitarClasesMensaje();
	        $("#titulomsm").addClass("btn-danger");
	        $("#msm").modal("show");
	        $scope.Mensaje="La Nota de Crédito necesita que llene los campos de configuracion esten llenos para poder realizar esta transaccion";
	     });
	};
	///---
	$scope.GetBodegas=function () {
		$http.get(API_URL + 'DocumentoNC/AllBodegas')
	        .success(function(response){
	            $scope.Bodegas=response;
	            console.log(response);
	     });
	};
    ///---
    $scope.GetTipoComprobanteV=function () {
        $http.get(API_URL + 'DocumentoNC/getTipoComprobante').success(function(response){

            var longitud = response.length;
            var array_temp = [{label: '-- Seleccione --', id: ''}];
            for (var i = 0; i < longitud; i++){
                array_temp.push({label: response[i].namecomprobante, id: response[i].idtipocomprobante})
            }

            $scope.listtipocomprobante = array_temp;
            $scope.tipocomprobante = '';

            $http.get(API_URL + '/configuracion/getTipoComprobanteNCDefault').success(function(response){

                if(response.length > 0){

                    $scope.comprobante_venta_h = response[0].idconfiguracionsystem;

                    if (response[0].optionvalue !== null && response[0].optionvalue !== '') {
                        $scope.tipocomprobante = parseInt(response[0].optionvalue);
                    }
                }
            });
        });
    };
	///---
	$scope.GetFormaPago=function () {
		$http.get(API_URL + 'DocumentoNC/formapago')
	        .success(function(response){
	            $scope.Formapago=response;
                if($scope.Formapago.length==0){
                    $("#titulomsm").addClass("btn-danger");
                    $("#msm").modal("show");
                    $scope.Mensaje="La Nota de Crédito necesita que llene las formas de pago";
                }
	            console.log(response);
	     });
	};
	///---
	$scope.GetPuntodeVenta=function(){
		$http.get(API_URL + 'DocumentoNC/getheaddocumentoventa')
	        .success(function(response){
	            $scope.PuntoVenta=response;
                console.log($scope.PuntoVenta);
                if($scope.Formapago.PuntoVenta==0){
                    $("#titulomsm").addClass("btn-danger");
                    $("#msm").modal("show");
                    $scope.Mensaje="La Nota de Crédito necesita puntos de venta y agente de venta";
                }
	            console.log(response);
	    });
	};
	///---

	$scope.DataNoDocumento=function() {
		$scope.PuntoVenta
		if($scope.AgenteVenta!=""){
			for(x=0;x<$scope.PuntoVenta.length;x++){
				if($scope.PuntoVenta[x].idpuntoventa==$scope.AgenteVenta){
					$scope.PuntoVentaSeleccionado=$scope.PuntoVenta[x];
					var aux_establecimiento=$scope.PuntoVenta[x].ruc.split("-");
					$scope.t_establ=aux_establecimiento[0];
					$scope.t_pto=$scope.PuntoVenta[x].codigoptoemision;
				}
			}
		}
	};
	///---
	$scope.items=[];
	$scope.Agregarfila=function(){
		console.log($scope.Cliente.numdocidentific);
		if($scope.Cliente.numdocidentific!=undefined){
			var item={
				productoObj:null,
				cantidad:0,
				precioU:0,
				descuento:0,
				iva :0,
				ice:0,
				total:0
			};
			$scope.items.push(item);
		}else{
			QuitarClasesMensaje();
	        $("#titulomsm").addClass("btn-warning");
	        $("#msm").modal("show");
	        $scope.Mensaje="Seleccione un cliente";
		}
	};
	///---
    $scope.QuitarItem=function (item) {
        var posicion= $scope.items.indexOf(item);
         $scope.items.splice(posicion,1);
         $scope.CalculaValores();
    };
    ///---
    $scope.Subtotalconimpuestos = '0.00';
    $scope.Subtotalcero = '0.00';
    $scope.Subtotalnobjetoiva = '0.00';
    $scope.Subototalexentoiva = '0.00';
    $scope.Subtotalsinimpuestos = '0.00';
    $scope.Totaldescuento = '0.00';
    $scope.ValICE = '0.00';
    $scope.ValIVA = '0.00';
    $scope.ValIRBPNR = '0.00';
    $scope.ValPropina = '0.00';
    $scope.ValorTotal = '0.00';
    $scope.AsignarData=function(object, item){

        item.productoObj = object;

        if(item!=undefined){
            if(item.productoObj!=undefined){
                if(item.productoObj.originalObject.precioventa!=undefined){
                    item.precioU=item.productoObj.originalObject.precioventa;
                }
                if(item.productoObj.originalObject.porcentiva!=undefined){
                    item.iva=item.productoObj.originalObject.porcentiva;
                }
                if(item.productoObj.originalObject.porcentice!=undefined){
                    item.ice=item.productoObj.originalObject.porcentice;
                }
            }
        }
    };
    $scope.ValidaProducto=function(){
        for(x=0;x<$scope.items.length;x++){
            if($scope.items[x].productoObj!=undefined){
                if( parseInt($scope.items[x].productoObj.originalObject.idclaseitem)==1){ //producto
                    if($scope.Bodega==""){
                        QuitarClasesMensaje();
                        $("#titulomsm").addClass("btn-danger");
                        $("#msm").modal("show");
                        $scope.Mensaje="Seleccione una bodega para el producto";
                        $scope.Validabodegaprodct="1";
                    }else{
                        $scope.Validabodegaprodct="0";
                    }
                }    
            }
        }
    };
    $scope.CalculaValores=function(){

        $scope.Subtotalconimpuestos = 0;


    	var aux_subtotalconimpuestos=0;
        var aux_totaldescuento=0;
        var aux_totalIce=0;
        console.log($scope.items);
    	for(x=0;x<$scope.items.length;x++){
    		//console.log($scope.items[x]);
    		//if(parseInt($scope.items[x].iva)==0 ){
    			if($scope.items[x].cantidad!=undefined && $scope.items[x].precioU!=undefined ){
    				if(parseFloat($scope.items[x].descuento)>0){
    					var aux_descuento=(((parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU))*(parseFloat($scope.items[x].descuento)))/100);
                        aux_totaldescuento+=aux_descuento;
    					var preciouxcantida=(parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU));
    					$scope.items[x].total=(preciouxcantida-aux_descuento).toFixed(4);
    				}else{
    					$scope.items[x].total=(parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU));
    				}
                    if(parseFloat($scope.items[x].ice)>0){
                        var aux_totalaplicaice=((parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU))*((parseFloat($scope.items[x].ice)))/100);
                        aux_totalIce+=aux_totalaplicaice;
                    }
    			}
    		//}
            
    	}

        var con_iva=0;
        var aux_subtoto_cero=0;
        var aux_no_objeto_iva=0;
        var aux_excento_iva=0;
    	for(x=0;x<$scope.items.length;x++){
    		//console.log($scope.items[x]);
            console.log(parseInt($scope.items[x].iva));

            if(parseInt($scope.items[x].iva)==0){ // 0% no objeto , excento
                switch($scope.items[x].productoObj.originalObject.idtipoimpuestoiva){
                    case 1: // 0%
                        aux_subtoto_cero+=parseFloat($scope.items[x].total);
                    break;
                    case 4: // no objeto iva
                        aux_no_objeto_iva+=parseFloat($scope.items[x].total);
                    break;
                    case 5: // excento iva
                        aux_excento_iva+=parseFloat($scope.items[x].total);
                    break;
                }
            }else{
                if($scope.items[x].productoObj.originalObject.idtipoimpuestoiva!=1 & $scope.items[x].productoObj.originalObject.idtipoimpuestoiva!=4 & $scope.items[x].productoObj.originalObject.idtipoimpuestoiva!=5){
                    if($scope.items[x].cantidad!=undefined && $scope.items[x].precioU!=undefined ){
                        //aux_subtotalconimpuestos+=(parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU));
                        aux_subtotalconimpuestos+=parseFloat($scope.items[x].total);
                        con_iva+=((parseFloat($scope.items[x].total)) * (parseInt($scope.items[x].iva))/100);
                    }
                }
            }
    		/*if(parseInt($scope.items[x].iva)==0 ){
    			if($scope.items[x].cantidad!=undefined && $scope.items[x].precioU!=undefined ){
    				aux_subtotalconimpuestos+=(parseFloat($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU));
    			}
    		}*/
    	}

    	
        $scope.Totaldescuento=aux_totaldescuento.toFixed(4);
        $scope.ValICE=aux_totalIce.toFixed(4);

        if(parseFloat($scope.ValICE)>0){
            for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_ICE_NC"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La Nota de Crédito necesita la cuenta contable de ICE";
                        }else{
                            $scope.ValidacionCueContExt="0";
                        }
                    }
            }
        }
        if(parseFloat($scope.ValIRBPNR)>0){
            for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_IRBPNR_NC"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La Nota de Crédito necesita la cuenta contable de IRBPNR";
                        }else{
                            $scope.ValidacionCueContExt="0";
                        }
                    }
            }
        }

        if(parseFloat($scope.ValPropina)>0){
            for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_PROPINA_NC"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La Nota de Crédito necesita la cuenta contable de PROPINA";
                        }else{
                            $scope.ValidacionCueContExt="0";
                        }
                    }
            }
        }

        $scope.Subtotalcero=aux_subtoto_cero.toFixed(4);
        $scope.Subtotalnobjetoiva = aux_no_objeto_iva.toFixed(4);
        $scope.Subototalexentoiva = aux_excento_iva.toFixed(4);
        $scope.Subtotalconimpuestos= (aux_subtotalconimpuestos ).toFixed(4);

        $scope.Subtotalconimpuestos=(isNaN($scope.Subtotalconimpuestos))? 0:$scope.Subtotalconimpuestos;
        $scope.Subtotalcero=(isNaN($scope.Subtotalcero))? 0:$scope.Subtotalcero;
        $scope.Subtotalnobjetoiva=(isNaN($scope.Subtotalnobjetoiva))? 0:$scope.Subtotalnobjetoiva;
        $scope.Subototalexentoiva=(isNaN($scope.Subototalexentoiva))? 0:$scope.Subototalexentoiva;
        $scope.ValICE=(isNaN($scope.ValICE))? 0:$scope.ValICE;

        var subtotalsinimp = parseFloat($scope.Subtotalconimpuestos) + parseFloat($scope.Subtotalcero);
        subtotalsinimp += parseFloat($scope.Subtotalnobjetoiva) + parseFloat($scope.Subototalexentoiva);

        subtotalsinimp -= parseFloat($scope.ValICE);

        

        $scope.Subtotalsinimpuestos = subtotalsinimp.toFixed(4);

        //$scope.Subtotalconimpuestos= (aux_subtotalconimpuestos - parseFloat($scope.Totaldescuento)).toFixed(4);
        //$scope.Subtotalconimpuestos= (aux_subtotalconimpuestos ).toFixed(4); // cambio

        $scope.ValIVA=(parseFloat((($scope.Subtotalconimpuestos*parseInt($scope.Cliente.porcentaje))/100)) + (parseFloat(con_iva)) ).toFixed(4);

        $scope.ValIVA=(isNaN($scope.ValIVA))? 0:$scope.ValIVA;
        $scope.ValIRBPNR=(isNaN($scope.ValIRBPNR))? 0:$scope.ValIRBPNR;
        $scope.ValPropina=(isNaN($scope.ValPropina))? 0:$scope.ValPropina;

        //var totalFC = parseFloat($scope.Subtotalconimpuestos) + parseFloat($scope.Subtotalcero);
        //totalFC += parseFloat($scope.Subtotalnobjetoiva) + parseFloat($scope.Subototalexentoiva);
        //totalFC += parseFloat($scope.ValIVA) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina);
        //totalFC -= parseFloat($scope.Totaldescuento);
        var totalFC = subtotalsinimp + parseFloat($scope.ValIVA) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina);
        $scope.ValorTotal = totalFC.toFixed(4);

        //$scope.ValorTotal=((parseFloat($scope.Subtotalconimpuestos)+parseFloat($scope.ValIVA) + parseFloat($scope.ValICE) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina) )   - ($scope.Totaldescuento)).toFixed(4);

    	//$scope.Subtotalconimpuestos= aux_subtotalconimpuestos.toFixed(4);
    	//$scope.ValIVA=(($scope.Subtotalconimpuestos*parseInt($scope.Cliente.porcentaje))/100).toFixed(4);

    	//$scope.ValorTotal=((parseFloat($scope.Subtotalconimpuestos)+parseFloat($scope.ValIVA) + parseFloat($scope.ValICE) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina) )   - ($scope.Totaldescuento)).toFixed(4);
    };
    ///---
    $scope.IniGuardarFactura=function(){
    	$("#ConfirmarVenta").modal("show");
    };
    $scope.EnviarDatosGuardarVenta=function(){
    	var Transaccion={
    		fecha:convertDatetoDB($("#FechaEmision").val()),
    		idtipotransaccion: 8,
    		numcomprobante:1,
    		descripcion: $scope.observacion
    	};
    	//Asiento contable Partida doble 	ay123
    	var RegistroC=[];
    	//Asiento contable cliente -- el cliente por lo genearal es un activo entonces el cliente aumenta una deuda por el debe 
    	var aux_bodegaseleccionada={};
    	for(i=0;i<$scope.Bodegas.length;i++){
    		if(parseInt($scope.Bodegas[i].idbodega)==parseInt($scope.Bodega)){
    			aux_bodegaseleccionada=$scope.Bodegas[i];
    		}
    	}
    	var cliente={
    		idplancuenta: $scope.Cliente.idplancuenta,
    		concepto: $scope.Cliente.concepto,
    		controlhaber: $scope.Cliente.controlhaber,
    		tipocuenta: $scope.Cliente.tipocuenta,
            Haber: $scope.ValorTotal,
    		Debe: 0,
    		Descipcion:''
    	};

    	RegistroC.push(cliente);
    	//--Sacar producto de bodega -- el producto es un activo pero como se lo vente disminuye por el haber
    	for(x=0;x<$scope.items.length;x++){
    		if($scope.items[x].productoObj.originalObject.idclaseitem==1){
    			var producto={
		    		//idplancuenta: $scope.items[x].productoObj.originalObject.idplancuenta,
		    		idplancuenta: aux_bodegaseleccionada.idplancuenta,
		    		concepto: aux_bodegaseleccionada.concepto,
		    		controlhaber: aux_bodegaseleccionada.controlhaber,
		    		tipocuenta: aux_bodegaseleccionada.tipocuenta,
                    Haber: 0,
		    		Debe: (parseFloat($scope.items[x].productoObj.originalObject.costopromedio)*parseInt($scope.items[x].cantidad)).toFixed(4),
		    		Descipcion:''
		    	};
		    	RegistroC.push(producto);
    		}	
    	}
    	//--Sacar producto de bodega -- el producto es un activo pero como se lo vente disminuye por el haber
    	//--Costo venta producto
    	//---obtener costo venta

        var costoventa={};
    	for(i=0;i<$scope.Configuracion.length;i++){
    		if($scope.Configuracion[i].Descripcion=="CONT_COSTO_VENTA"){
    			var auxcosto=$scope.Configuracion[i].Contabilidad;
    			costoventa=auxcosto[0];
    		}
    	}
    	//---obtener costo venta
    	for(x=0;x<$scope.items.length;x++){
    		if($scope.items[x].productoObj.originalObject.idclaseitem==1){
    			var productocosto={
		    		idplancuenta: costoventa.idplancuenta,
		    		concepto: costoventa.concepto,
		    		controlhaber: costoventa.controlhaber,
		    		tipocuenta: costoventa.tipocuenta,
		    		Debe: (parseFloat($scope.items[x].productoObj.originalObject.costopromedio)*parseInt($scope.items[x].cantidad)).toFixed(4),
		    		Haber: 0,
		    		Descipcion:''
		    	};
		    	RegistroC.push(productocosto);
    		}	
    	}
    	//--Costo venta producto

    	//--Ingreso del item producto o servicio
    	for(x=0;x<$scope.items.length;x++){
    		if($scope.items[x].productoObj.originalObject.idclaseitem==1 || $scope.items[x].productoObj.originalObject.idclaseitem==2){
    			var itemproductoservicio={
		    		idplancuenta: $scope.items[x].productoObj.originalObject.idplancuenta_ingreso,
		    		concepto: $scope.items[x].productoObj.originalObject.conceptoingreso,
		    		controlhaber: $scope.items[x].productoObj.originalObject.controlhaberingreso,
		    		tipocuenta: $scope.items[x].productoObj.originalObject.tipocuentaingreso,
                    Haber: 0,
		    		Debe: (parseInt($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU)).toFixed(4),
		    		Descipcion:''
		    	};
		    	RegistroC.push(itemproductoservicio);
    		}	
    	}
    	//--Ingreso del item producto o servicio

        //-- ICE venta
        if(parseFloat($scope.ValICE)>0){
            var iceventa={};
            for(i=0;i<$scope.Configuracion.length;i++){
                if($scope.Configuracion[i].Descripcion=="CONT_ICE_NC"){
                    var auxcosto=$scope.Configuracion[i].Contabilidad;
                    iceventa=auxcosto[0];
                }
            }
            var ice={
                    idplancuenta: iceventa.idplancuenta,
                    concepto: iceventa.concepto,
                    controlhaber: iceventa.controlhaber,
                    tipocuenta: iceventa.tipocuenta,
                    Haber: 0,
                    Debe: parseFloat($scope.ValICE),
                    Descipcion:''
                };
            RegistroC.push(ice);
        }
        //-- ICE venta

        //-- IRBPNR venta
        if(parseFloat($scope.ValIRBPNR)>0){
            var irbpnrventa={};
            for(i=0;i<$scope.Configuracion.length;i++){
                if($scope.Configuracion[i].Descripcion=="CONT_IRBPNR_NC"){
                    var auxcosto=$scope.Configuracion[i].Contabilidad;
                    irbpnrventa=auxcosto[0];
                }
            }
            var irbpnr={
                    idplancuenta: irbpnrventa.idplancuenta,
                    concepto: irbpnrventa.concepto,
                    controlhaber: irbpnrventa.controlhaber,
                    tipocuenta: irbpnrventa.tipocuenta,
                    Haber: 0,
                    Debe: parseFloat($scope.ValIRBPNR),
                    Descipcion:''
                };
            RegistroC.push(irbpnr);
        }
        //-- IRBPNR venta

        //-- PROPINTA venta
        if(parseFloat($scope.ValPropina)>0){
            var propinaventa={};
            for(i=0;i<$scope.Configuracion.length;i++){
                if($scope.Configuracion[i].Descripcion=="CONT_PROPINA_NC"){
                    var auxcosto=$scope.Configuracion[i].Contabilidad;
                    propinaventa=auxcosto[0];
                }
            }
            var propinav={
                    idplancuenta: propinaventa.idplancuenta,
                    concepto: propinaventa.concepto,
                    controlhaber: propinaventa.controlhaber,
                    tipocuenta: propinaventa.tipocuenta,
                    Haber: 0,
                    Debe: parseFloat($scope.ValPropina),
                    Descipcion:''
                };
            RegistroC.push(propinav);
        }
        //-- PROPINTA venta


    	//--Iva venta
    	var ivaventa={};
    	for(i=0;i<$scope.Configuracion.length;i++){
    		if($scope.Configuracion[i].Descripcion=="CONT_IVA_NC"){
    			var auxcosto=$scope.Configuracion[i].Contabilidad;
    			ivaventa=auxcosto[0];
    		}
    	}
		var iva={
	    		idplancuenta: ivaventa.idplancuenta,
	    		concepto: ivaventa.concepto,
	    		controlhaber: ivaventa.controlhaber,
	    		tipocuenta: ivaventa.tipocuenta,
	    		Haber: 0,
	    		Debe: parseFloat($scope.ValIVA),
	    		Descipcion:''
	    	};
	    RegistroC.push(iva);
    	//--Iva venta
    	var Contabilidad={
    		transaccion: Transaccion,
    		registro: RegistroC
    	};

    	//--proceso kardex
    	var kardex=[];
		for(x=0;x<$scope.items.length;x++){
    		if($scope.items[x].productoObj.originalObject.idclaseitem==1){
    			var producto={
		    		idtransaccion: 0,
		    		idcatalogitem: $scope.items[x].productoObj.originalObject.idcatalogitem,
		    		idbodega: $scope.Bodega,
		    		fecharegistro:convertDatetoDB($("#FechaEmision").val()),
		    		cantidad:parseInt($scope.items[x].cantidad),
		    		costounitario: parseFloat($scope.items[x].productoObj.originalObject.costopromedio),
		    		costototal:(parseInt($scope.items[x].cantidad)*parseFloat($scope.items[x].productoObj.originalObject.costopromedio)).toFixed(4),
		    		tipoentradasalida:1,
		    		estadoanulado:true,
		    		descripcion:$scope.observacion
		    	};
		    	kardex.push(producto);
    		}	
    	}
    	//--proceso kardex

    	//--Documento de venta
    	var DocVenta={
    		//idpuntoventa: $scope.PuntoVentaSeleccionado.idpuntoventa,
    		idcliente: $scope.Cliente.idcliente,
    		idtipoimpuestoiva:$scope.Cliente.idtipoimpuestoiva,
    		//numdocumentoventa:'1',
            numdocumentonotacredit:$("#t_establ").val()+"-"+$("#t_pto").val()+"-"+$("#t_secuencial").val(),
            fecharegistroncf:convertDatetoDB($("#FechaRegistro").val()),
            fechaemisionncf:convertDatetoDB($("#FechaEmision").val()),
    		//nroautorizacionventa:$scope.NoAutorizacion,
            nroautorizacionncf:null,
    		//nroguiaremision:$("#t_establ_guia").val()+"-"+$("#t_pto_guia").val()+"-"+$("#t_secuencial_guia").val(),
            subtotalconimpuestoncf:$scope.Subtotalconimpuestos,
            subtotalceroncf:$scope.Subtotalcero,
            subtotalnoobjivancf:$scope.Subtotalnobjetoiva,
            subtotalexentivancf:$scope.Subototalexentoiva,
            subtotalsinimpuestoncf:$scope.Subtotalsinimpuestos,
    		totaldescuento:$scope.Totaldescuento,
            icencf:$scope.ValICE,
            ivancf:$scope.ValIVA,
            irbpnrncf:$scope.ValIRBPNR,
            propinancf:$scope.ValPropina,
            otrosncf:0,
            valortotalncf:$scope.ValorTotal,
    		estadoanulado:'false',
            motivoncf: $scope.observacion,
    		idtransaccion:'',
            idtipocomprobante: $scope.tipocomprobante
    	};
    	//--Documento de venta
    	//--Items venta
    	var ItemsVenta=[];
    	for(x=0;x<$scope.items.length;x++){

            var bodega = null;

            console.log($scope.Bodega);

            if ($scope.Bodega !== '0' || $scope.Bodega !== undefined || $scope.Bodega.trim() !== '') {
                console.log($scope.Bodega);
                bodega = $scope.Bodega;
            }

            if (bodega == '') {
                bodega = null;
            }

    		var itemsdocventa={
	    		idcatalogitem: $scope.items[x].productoObj.originalObject.idcatalogitem,
                iddocumentonotacreditfactura:0,
	    		idbodega: bodega,
	    		idtipoimpuestoiva:$scope.items[x].productoObj.originalObject.idtipoimpuestoiva,
	    		idtipoimpuestoice:$scope.items[x].productoObj.originalObject.idtipoimpuestoice,
	    		cantidad:parseInt($scope.items[x].cantidad),
	    		preciounitario: parseFloat($scope.items[x].precioU),
	    		descuento: $scope.items[x].descuento,
	    		preciototal:(parseInt($scope.items[x].cantidad)*parseFloat($scope.items[x].precioU)).toFixed(4)
	    	};
	    	ItemsVenta.push(itemsdocventa);
    	}
    	//--Items venta
    	//console.log(Contabilidad);
    	/*console.log(kardex);
    	console.log(DocVenta);
    	console.log(ItemsVenta);*/
    	var transaccion_venta_full={
    		DataContabilidad:Contabilidad,
    		Datakardex:kardex,
    		DataVenta:DocVenta,
    		Idformapagoventa: $scope.cmbFormapago, 
    		DataItemsVenta:ItemsVenta
    	};
        //console.log(transaccion_venta_full);
    	//$http.get(API_URL+'DocumentoNC/getVentas/'+JSON.stringify(transaccion_venta_full))
        //$http.get(API_URL+'DocumentoNC/getVentas/'+JSON.stringify(2))
        var transaccionfactura={
            datos:JSON.stringify(transaccion_venta_full)
        }
        $http.post(API_URL+'DocumentoNC',transaccionfactura)
                .success(function (response) {
                    if(parseInt(response)>0){
                    	QuitarClasesMensaje();
				        $("#titulomsm").addClass("btn-success");
				        $("#msm").modal("show");
				        $scope.Mensaje="La Nota de Crédito se guardo correctamente";
				        $scope.LimiarDataVenta();
				        $scope.NumeroRegistroVenta();
                    }else{
                    	QuitarClasesMensaje();
				        $("#titulomsm").addClass("btn-danger");
				        $("#msm").modal("show");
				        $scope.Mensaje="Error al guardar la Nota de Crédito";
				        $scope.LimiarDataVenta();
                    }
        })
        .error(function(err){
            console.log(err);
        });
    };
    $scope.LimiarDataVenta=function(){
    	$scope.Subtotalconimpuestos=0;
	    $scope.Subtotalcero=0;
	    $scope.Subtotalnobjetoiva=0;
	    $scope.Subototalexentoiva=0;
	    $scope.Subtotalsinimpuestos=0;
	    $scope.Totaldescuento=0;
	    $scope.ValICE=0;
	    $scope.ValIVA=0;
	    $scope.ValIRBPNR=0;
	    $scope.ValPropina=0;
	    $scope.ValorTotal=0;

	    $scope.DICliente="";
		$scope.Cliente={};
		$scope.items=[];
		$scope.Bodega="";
		$scope.cmbFormapago="";
		$scope.AgenteVenta="";
		$scope.PuntoVentaSeleccionado={};
		//$scope.Configuracion=[];
		$scope.mensaje="";
		$scope.AgenteVenta="";
		$scope.t_establ="";
		$scope.t_pto="";
		$scope.Bodega="";
		$scope.observacion="";
		$scope.NoVenta="";
		$scope.t_establ_guia="";
		$scope.t_pto_guia="";
		$scope.t_secuencial_guia="";
		$scope.NoAutorizacion="";
		$scope.t_secuencial="";

        $scope.IdDocumentoVentaedit="0";
    };
    ///---
    $scope.ViewVenta=function(venta){
    	$http.get(API_URL + 'DocumentoNC/loadEditVenta/'+venta.iddocumentonotacreditfactura)
	        .success(function(response){
	            console.log(response);
                $scope.VerFactura=1;
                $scope.Cliente=response.Cliente[0];
                var aux_ventadata=response.Venta[0];
                var aux_transaccion=response.Contabilidad[0];

                //$scope.AgenteVenta=String(aux_ventadata.idpuntoventa);
                $scope.DataNoDocumento();
                $scope.NoAutorizacion=aux_ventadata.nroautorizacionncf;
                //var aux_guiar=aux_ventadata.nroguiaremision.split("-");

                //$scope.t_establ_guia=aux_guiar[0];
                //$scope.t_pto_guia=aux_guiar[1];
                //$scope.t_secuencial_guia=aux_guiar[2];

                $scope.IdDocumentoVentaedit=String(aux_ventadata.iddocumentonotacreditfactura);
                $scope.NoVenta=String(aux_ventadata.iddocumentonotacreditfactura);

                $("#t_secuencial").val(aux_ventadata.iddocumentoventa);
                $scope.calculateLength('t_secuencial', 9);
                $scope.t_secuencial=$("#t_secuencial").val();

                $scope.FechaRegistro=convertDatetoDB(aux_ventadata.fecharegistroncf,true);
                $scope.FechaEmision=convertDatetoDB(aux_ventadata.fechaemisionncf,true);

                $scope.observacion=aux_transaccion.descripcion;
                //$scope.cmbFormapago=String(aux_ventadata.cont_formapago_documentoventa[0].idformapago);

                $scope.ValIRBPNR=parseFloat(aux_ventadata.irbpnrncf);
                $scope.ValPropina=parseFloat(aux_ventadata.propinancf);

                var aux_itemsventa=response.Items;
                $scope.DICliente=$scope.Cliente.numdocidentific;
                var aux_bodegacont=1;
                for(x=0;x<aux_itemsventa.length;x++){
                    if(aux_itemsventa[x].idbodega!="") $scope.Bodega=String(aux_itemsventa[x].idbodega);
                    var item={
                        productoObj:{
                            /*title:aux_itemsventa[x].cont_catalogoitem.codigoproducto,
                            originalObject:aux_itemsventa[x].cont_catalogoitem*/
                            title:aux_itemsventa[x].codigoproducto,
                            originalObject:aux_itemsventa[x]
                        },
                        cantidad:aux_itemsventa[x].cantidad,
                        precioU:aux_itemsventa[x].preciounitario,
                        descuento:aux_itemsventa[x].descuento,
                        iva : aux_itemsventa[x].porcentiva,
                        ice: aux_itemsventa[x].porcentice,
                        //iva : 0,
                        //ice:0,
                        total:aux_itemsventa[x].preciototal,
                      //  producto: aux_itemsventa[x].cont_catalogoitem.codigoproducto
                        producto: aux_itemsventa[x].codigoproducto
                    };
                    $scope.items.push(item);
                    aux_bodegacont++;
                }
                $scope.items.forEach(function(){
                    $scope.CalculaValores();
                });
                
	    });
    };
    ///---
    $scope.AnularVenta=function(){
        $("#ConfirmarAnulacion").modal("show");
    };
    ///---
    $scope.ConfirmarAnularventa=function(){
        $("#ConfirmarAnulacion").modal("hide");
        $http.get(API_URL+'DocumentoNC/anularVenta/'+$scope.IdDocumentoVentaedit)
        .success(function (response) {
            if(parseInt(response)>0){
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-success");
                $("#msm").modal("show");
                $scope.Mensaje="La Nota de Crédito se anulo correctamente";
                $scope.LimiarDataVenta();
                $scope.NumeroRegistroVenta();
                $scope.pageChanged();
                $scope.VerFactura=2;
                $scope.IdDocumentoVentaedit="0";
            }else{
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-danger");
                $("#msm").modal("show");
                $scope.Mensaje="Error al anular la Nota de Crédito";
                $scope.LimiarDataVenta();
            }
        });
    };
    ///---
    $scope.AnularVentaDirecto=function(id){
      $("#ConfirmarAnulacion").modal("show"); 
      $scope.IdDocumentoVentaedit=String(id); 
    };



    $scope.numFactura = function (v) {
        var establecimiento = (v.cont_puntoventa.sri_establecimiento.ruc).split('-')[0];
        var ptoemision = v.cont_puntoventa.codigoptoemision;
        var secuencial = v.iddocumentoventa;

        var num_factura = establecimiento + '-' + ptoemision + '-' + $scope.calculateLength2(String(secuencial), 9);

        return num_factura;
    };

    $scope.calculateLength2 = function(text, length) {

        var longitud = text.length;
        var diferencia = parseInt(length) - parseInt(longitud);
        var relleno = '';
        if (diferencia == 1) {
            relleno = '0';
        } else {
            var i = 0;
            while (i < diferencia) {
                relleno += '0';
                i++;
            }
        }
        return relleno + text;
    };



    $scope.onlyDecimal = function ($event) {
        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /\d/;
        var n = String.fromCharCode(k);
        if (n == ".") {
            return true;
        } else {
            if(patron.test(n) == false){
                $event.preventDefault();
            }
            else return true;
        }
    };

    $scope.onlyCharasterAndSpace = function ($event) {

        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /^([a-zA-Záéíóúñ\s]+)$/;
        var n = String.fromCharCode(k);

        if(patron.test(n) == false){
            $event.preventDefault();
            return false;
        }
        else return true;

    };

    $scope.onlyNumber = function ($event, length, field) {

        if (length != undefined) {
            var valor = $('#' + field).val();
            if (valor.length == length) $event.preventDefault();
        }

        var k = $event.keyCode;
        if (k == 8 || k == 0) return true;
        var patron = /\d/;
        var n = String.fromCharCode(k);

        if (n == ".") {
            return true;
        } else {

            if(patron.test(n) == false){
                $event.preventDefault();
            }
            else return true;
        }
    };

    $scope.calculateLength = function(field, length) {
        var text = $("#" + field).val();
        var longitud = text.length;
        if (longitud == length) {
            $("#" + field).val(text);
        } else {
            var diferencia = parseInt(length) - parseInt(longitud);
            var relleno = '';
            if (diferencia == 1) {
                relleno = '0';
            } else {
                var i = 0;
                while (i < diferencia) {
                    relleno += '0';
                    i++;
                }
            }
            $("#" + field).val(relleno + text);
        }
    };    
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
function first(){
    var now = new Date();
    var yyyy = now.getFullYear();
    return "01/01/"+ yyyy;
}

function completarNumer(valor){
    if(valor.toString().length>0){
        var i=5;
        var completa="0";
        var aux_com=i-valor.toString().length;
        for(x=0;x<aux_com;x++){
            completa+="0";
        }
    }
    return completa+valor.toString();
}

function QuitarClasesMensaje() {
    $("#titulomsm").removeClass("btn-primary");
    $("#titulomsm").removeClass("btn-warning");
    $("#titulomsm").removeClass("btn-success");
    $("#titulomsm").removeClass("btn-info");
    $("#titulomsm").removeClass("btn-danger");
}
$(document).ready(function(){
    $('.datepicker').datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        ignoreReadonly: true
    });

    $(".disabled_enter").keypress(function(e) {
        alert('b');
        if (e.which == 13) {
            return false;
        }
    });
});