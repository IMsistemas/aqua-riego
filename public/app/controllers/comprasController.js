
    app.controller('comprasController',  function($scope, $http, API_URL) {

        $scope.compras = [];
        $scope.items=[];
        $scope.list_item = [];
        $scope.listado = true;

        $scope.select_cuenta = null;

        $scope.compra_anular = 0;

        $scope.proveedor = '';

        $scope.estados = [
            {id: 1, nombre: 'ANULADO'},
            {id: 0, nombre: 'NO ANULADO'}
        ];

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

        $scope.Bodegas=[];
        $scope.Configuracion=[];

        $scope.itemEditAnular = {};

        $scope.isBodega = false;


        $scope.pageChanged = function(newPage) {
            $scope.initLoad(newPage);
        };

        $scope.aux_cuenta={};
        $scope.showPlanCuenta = function (item) {
            $scope.aux_cuenta=item;
            $http.get(API_URL + 'empleado/getPlanCuenta').success(function(response){
                console.log(response);
                $scope.cuentas = response;
                $('#modalPlanCuenta').modal('show');
            });

        };

        $scope.selectCuenta = function () {
            var selected = $scope.select_cuenta;

            $scope.cuenta_employee = selected.concepto;

            $scope.aux_cuenta.productoObj.idplancuenta=selected.idplancuenta;
            $scope.aux_cuenta.productoObj.concepto=selected.concepto;
            $scope.aux_cuenta.productoObj.codigosri=selected.codigosri;
            $scope.aux_cuenta.productoObj.tipoestadofinanz=selected.tipoestadofinanz;
            $scope.aux_cuenta.productoObj.estado=selected.estado;
            $scope.aux_cuenta.productoObj.controlhaber=selected.controlhaber;
            $scope.aux_cuenta.productoObj.tipocuenta=selected.tipocuenta;
            $scope.aux_cuenta.productoObj.jerarquia=selected.jerarquia;
            $scope.aux_cuenta.productoObj.madreohija=selected.madreohija;


            $('#modalPlanCuenta').modal('hide');
        };

        $scope.click_radio = function (item) {
            $scope.select_cuenta = item;
        };

        $scope.getProveedorByFilter = function () {
            $http.get(API_URL + 'DocumentoCompras/getProveedorByFilter').success(function(response){

                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione Proveedor --', id: ''}];

                for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].persona.razonsocial, id: response[i].idproveedor})
                }

                $scope.proveedor0 = array_temp;
                $scope.proveedorFiltro0 = '';

            });
        };

        $scope.getBodegas = function (idbodega) {
            /*$http.get(API_URL + 'DocumentoCompras/getBodegas').success(function(response){

                var longitud = response.length;
                var array_temp = [];
                for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].namebodega, id: response[i].idbodega})
                }

                $scope.listbodegas = array_temp;
                $scope.bodega = array_temp[0].id

            });*/

            $http.get(API_URL + 'DocumentoVenta/AllBodegas').success(function(response){
                $scope.Bodegas=response;

                if (idbodega != undefined){
                    $scope.Bodega = idbodega
                }
            });
        };

        $scope.getTipoPagoComprobante = function () {

             $http.get(API_URL + 'DocumentoCompras/getTipoPagoComprobante').success(function(response){

                 var longitud = response.length;
                 var array_temp = [{label: '-- Seleccione --', id: ''}];

                 for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].tipopagoresidente, id: response[i].idpagoresidente})
                 }

                 $scope.listtipopago = array_temp;
                 $scope.tipopago = array_temp[0].id

             });

        };

        $scope.valueFecha = function () {

            $scope.fechaemisioncomprobante = $('#fechaemisioncomprobante').val();

        };

        $scope.getCentrosCostos = function () {

            $http.get(API_URL + 'DocumentoCompras/getCentrosCostos').success(function(response){

                console.log(response);

                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: null}];

                for (var i = 0; i < longitud; i++) {
                    array_temp.push({label: response[i].namecentrocosto, id: response[i].idcentrocosto});
                }

                $scope.listcentrocostos = array_temp;

                //$scope.paispago = array_temp[0].id

                //$scope.listcentrocostos = response;

            });

        };

        $scope.select_iva=function (item) {
            console.log(item);
            $scope.list_iva.forEach(function (i) {
                if(i.idtipoimpuestoiva== parseInt(item.productoObj.originalObject.idtipoimpuestoiva)){
                    item.iva=i.porcentaje;
                }
            });
            $scope.CalculaValores();
        };
        $scope.getivas = function () {

            $http.get(API_URL + 'proveedor/getImpuestoIVA').success(function(response){


/*
                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: null}];

                for (var i = 0; i < longitud; i++) {
                    array_temp.push({label: response[i].namedepartamento, id: response[i].iddepartamento});
                }*/

                $scope.list_iva = response;


            });

        };
        $scope.getivas();

        $scope.getPaisPagoComprobante = function () {

            $http.get(API_URL + 'DocumentoCompras/getPaisPagoComprobante').success(function(response){

                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: ''}];

                for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].pais, id: response[i].idpagopais})
                }

                $scope.listpaispago = array_temp;
                $scope.paispago = array_temp[0].id

            });

        };

        $scope.getLastIDCompra = function () {

            $http.get(API_URL + 'DocumentoCompras/getLastIDCompra').success(function(response){

                if (response != null && response != 0) {
                    $scope.numcompra = parseInt(response) + 1;
                } else {
                    $scope.numcompra = 1;
                }

            });
        };

        $scope.getSustentoTributario = function () {
            $http.get(API_URL + 'DocumentoCompras/getSustentoTributario').success(function(response){

                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: ''}];
                for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].namesustento, id: response[i].idsustentotributario})
                }

                $scope.listsustentotributario = array_temp;
                $scope.sustentotributario = array_temp[0].id;

                $scope.listtipocomprobante = [{label: '-- Seleccione --', id: ''}];
                $scope.tipocomprobante = array_temp[0].id;

            });
        };

        $scope.getTipoComprobante = function (idtipocomprobante) {

            var idsustento = $scope.sustentotributario;

            var array_temp = [{label: '-- Seleccione --', id: ''}];
            $scope.listtipocomprobante = array_temp;
            $scope.tipocomprobante = array_temp[0].id;

            if (idsustento != '' && idsustento != undefined) {
                $http.get(API_URL + 'DocumentoCompras/getTipoComprobante/' + idsustento).success(function(response){

                    var longitud = response.length;

                    for (var i = 0; i < longitud; i++){
                        array_temp.push({label: response[i].namecomprobante, id: response[i].idtipocomprobante})
                    }

                    $scope.listtipocomprobante = array_temp;

                    if (idtipocomprobante != undefined){
                        $scope.tipocomprobante = idtipocomprobante;
                    }

                });
            }

        };

        $scope.getFormaPago = function () {
            $http.get(API_URL + 'DocumentoCompras/getFormaPago').success(function(response){

                var longitud = response.length;
                var array_temp = [{label: '-- Seleccione --', id: ''}];
                for (var i = 0; i < longitud; i++){
                    array_temp.push({label: response[i].nameformapago, id: response[i].idformapago})
                }

                $scope.listformapago = array_temp;
                $scope.formapago = array_temp[0].id;

            });
        };

        $scope.showDataProveedor = function (object) {

            if (object != undefined && object.originalObject != undefined) {

                console.log(object);

                $scope.razon = object.originalObject.razonsocial;
                $scope.direccion = object.originalObject.direccion;
                $scope.telefono = object.originalObject.proveedor[0].telefonoprincipal;
                $scope.iva = object.originalObject.proveedor[0].sri_tipoimpuestoiva.nametipoimpuestoiva;

                $scope.proveedor = object;

            }

        };

        $scope.createRow = function () {

            var item = {
                productoObj:{
                    idplancuenta:null,
                    concepto:null,
                    codigosri:null,
                    tipoestadofinanz:null,
                    estado:null,
                    controlhaber:null,
                    tipocuenta:null,
                    jerarquia:null,
                    madreohija:null,
                    originalObject:{
                        idtipoimpuestoiva:'0'
                    }
                },
                idcentrocosto: null,
                cantidad:0,
                precioU:0,
                descuento:0,
                iva :0,
                ice:0,
                total:0
            };
            $scope.items.push(item);


            //item.productoObj.originalObject.idtipoimpuestoiva=

        };


        /*
             -------------------------------------------------------------------------------------------       NEW
         */

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

        $scope.AsignarData=function(object, item){

            console.log(object);

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

        $scope.ConfigContable=function(){
            $http.get(API_URL + 'DocumentoCompras/porcentajeivaiceotro')
                .success(function(response){
                    $scope.Configuracion=response;
                    //console.log(response);
                    for(x=0;x<$scope.Configuracion.length;x++){
                        if($scope.Configuracion[x].Descripcion=="CONT_COSTO_VENTA"){
                            if($scope.Configuracion[x].IdContable==null){
                                $scope.Valida="1";
                                QuitarClasesMensaje();
                                $("#titulomsm").addClass("btn-danger");
                                $("#msm").modal("show");
                                $scope.Mensaje="La venta necesita la cuenta contable de COSTO DE VENTA";
                            }
                        }
                        if($scope.Configuracion[x].Descripcion=="CONT_IVA_VENTA"){
                            if($scope.Configuracion[x].IdContable==null){
                                $scope.Valida="1";
                                QuitarClasesMensaje();
                                $("#titulomsm").addClass("btn-danger");
                                $("#msm").modal("show");
                                $scope.Mensaje="La venta necesita la cuenta contable de IVA DE VENTA";
                            }
                        }
                    }
                    if(String($scope.Configuracion[0].IdContable)==""){
                        QuitarClasesMensaje();
                        $("#titulomsm").addClass("btn-danger");
                        $("#msm").modal("show");
                        $scope.Mensaje="La venta necesita que llene los campos de configuracion esten llenos para poder realizar esta transaccion";
                    }
                }).error(function(res){
                QuitarClasesMensaje();
                $("#titulomsm").addClass("btn-danger");
                $("#msm").modal("show");
                $scope.Mensaje="La venta necesita que llene los campos de configuracion esten llenos para poder realizar esta transaccion";
            });
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
                        case "1": // 0%
                            aux_subtoto_cero+=parseFloat($scope.items[x].total);
                            break;
                        case "4": // no objeto iva
                            aux_no_objeto_iva+=parseFloat($scope.items[x].total);
                            break;
                        case "5": // excento iva
                            aux_excento_iva+=parseFloat($scope.items[x].total);
                            break;
                    }
                }else{
                    if($scope.items[x].productoObj.originalObject.idtipoimpuestoiva!==1 & $scope.items[x].productoObj.originalObject.idtipoimpuestoiva!==4 & $scope.items[x].productoObj.originalObject.idtipoimpuestoiva!==5){
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
                    if($scope.Configuracion[x].Descripcion=="CONT_ICE_VENTA"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La venta necesita la cuenta contable de ICE";
                        }else{
                            $scope.ValidacionCueContExt="0";
                        }
                    }
                }
            }
            if(parseFloat($scope.ValIRBPNR)>0){
                for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_IRBPNR_VENTA"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La venta necesita la cuenta contable de IRBPNR";
                        }else{
                            $scope.ValidacionCueContExt="0";
                        }
                    }
                }
            }

            if(parseFloat($scope.ValPropina)>0){
                for(x=0;x<$scope.Configuracion.length;x++){
                    if($scope.Configuracion[x].Descripcion=="CONT_PROPINA_VENTA"){
                        if($scope.Configuracion[x].IdContable==null){
                            $scope.ValidacionCueContExt="1";
                            QuitarClasesMensaje();
                            $("#titulomsm").addClass("btn-danger");
                            $("#msm").modal("show");
                            $scope.Mensaje="La venta necesita la cuenta contable de PROPINA";
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

            //$scope.ValIVA=(parseFloat((($scope.Subtotalconimpuestos*parseInt($scope.Cliente.porcentaje))/100)) + (parseFloat(con_iva)) ).toFixed(4);

            $scope.ValIVA=(($scope.Subtotalconimpuestos*parseInt($scope.proveedor.originalObject.proveedor[0].sri_tipoimpuestoiva.porcentaje))/100).toFixed(4);

            $scope.ValIVA=(isNaN($scope.ValIVA))? 0:$scope.ValIVA;
            $scope.ValIRBPNR=(isNaN($scope.ValIRBPNR))? 0:$scope.ValIRBPNR;
            $scope.ValPropina=(isNaN($scope.ValPropina))? 0:$scope.ValPropina;

            //var totalFC = parseFloat($scope.Subtotalconimpuestos) + parseFloat($scope.Subtotalcero);
            //totalFC += parseFloat($scope.Subtotalnobjetoiva) + parseFloat($scope.Subototalexentoiva);
            //totalFC += parseFloat($scope.ValIVA) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina);
            //totalFC -= parseFloat($scope.Totaldescuento);
            var totalFC = subtotalsinimp + parseFloat($scope.ValIVA) + parseFloat($scope.ValIRBPNR) + parseFloat($scope.ValPropina);
            $scope.ValorTotal = totalFC.toFixed(4);

        };

        $scope.QuitarItem=function (item) {
            var posicion= $scope.items.indexOf(item);
            $scope.items.splice(posicion,1);
            $scope.CalculaValores();
        };


        $scope.temp = function (a) {
            console.log(a);
        };

        $scope.save = function(){

            $('#btn-save0').prop('disabled', true);

            var Transaccion={
                fecha:$("#fechaemisioncompra").val(),
                idtipotransaccion: 7,
                numcomprobante:1,
                descripcion: $scope.observacion
            };

            //Asiento contable Partida doble
            var RegistroC=[];

            //Asiento contable cliente -- el cliente por lo genearal es un activo entonces el cliente aumenta una deuda por el debe
            /*var aux_bodegaseleccionada={};
            for(var i=0;i<$scope.Bodegas.length;i++){
                if(parseInt($scope.Bodegas[i].idbodega) == parseInt($scope.Bodega)){
                    aux_bodegaseleccionada=$scope.Bodegas[i];
                }
            }*/

            var cliente = {
                idplancuenta: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.idplancuenta,
                concepto: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.concepto,
                controlhaber: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.controlhaber,
                tipocuenta: $scope.proveedor.originalObject.proveedor[0].cont_plancuenta.tipocuenta,
                Debe: 0,
                Haber: $scope.ValorTotal,
                Descipcion: $scope.observacion
            };

            RegistroC.push(cliente);

            //--Sacar producto de bodega -- el producto es un activo pero como se lo vente disminuye por el haber

            //--Sacar producto de bodega -- el producto es un activo pero como se lo vente disminuye por el haber


            //--Ingreso del item producto o servicio
            for(x=0;x<$scope.items.length;x++){
                var itemproductoservicio={
                    idplancuenta: $scope.items[x].productoObj.idplancuenta,
                    concepto: $scope.items[x].productoObj.concepto,
                    controlhaber: $scope.items[x].productoObj.controlhaber,
                    tipocuenta: $scope.items[x].productoObj.tipocuenta,
                    Debe: (parseFloat($scope.items[x].total)).toFixed(4),
                    Haber: 0,
                    Descipcion: $scope.observacion
                };
                RegistroC.push(itemproductoservicio);
            }
            //--Ingreso del item producto o servicio

            //-- ICE venta
            if(parseFloat($scope.ValICE)>0){
                var iceventa={};
                for(i=0;i<$scope.Configuracion.length;i++){
                    if($scope.Configuracion[i].Descripcion=="CONT_ICE_COMPRA"){
                        var auxcosto=$scope.Configuracion[i].Contabilidad;
                        iceventa=auxcosto[0];
                    }
                }
                var ice={
                    idplancuenta: iceventa.idplancuenta,
                    concepto: iceventa.concepto,
                    controlhaber: iceventa.controlhaber,
                    tipocuenta: iceventa.tipocuenta,
                    Debe: parseFloat($scope.ValICE),
                    Haber: 0,
                    Descipcion:$scope.observacion
                };
                RegistroC.push(ice);
            }
            //-- ICE venta

            //-- IRBPNR venta
            if(parseFloat($scope.ValIRBPNR)>0){
                var irbpnrventa={};
                for(i=0;i<$scope.Configuracion.length;i++){
                    if($scope.Configuracion[i].Descripcion=="CONT_IRBPNR_COMPRA"){
                        var auxcosto=$scope.Configuracion[i].Contabilidad;
                        irbpnrventa=auxcosto[0];
                    }
                }
                var irbpnr={
                    idplancuenta: irbpnrventa.idplancuenta,
                    concepto: irbpnrventa.concepto,
                    controlhaber: irbpnrventa.controlhaber,
                    tipocuenta: irbpnrventa.tipocuenta,
                    Debe: parseFloat($scope.ValIRBPNR),
                    Haber: 0,
                    Descipcion: $scope.observacion
                };
                RegistroC.push(irbpnr);
            }
            //-- IRBPNR venta

            //-- PROPINTA venta
            if(parseFloat($scope.ValPropina)>0){
                var propinaventa={};
                for(i=0;i<$scope.Configuracion.length;i++){
                    if($scope.Configuracion[i].Descripcion=="CONT_PROPINA_COMPRA"){
                        var auxcosto=$scope.Configuracion[i].Contabilidad;
                        propinaventa=auxcosto[0];
                    }
                }
                var propinav={
                    idplancuenta: propinaventa.idplancuenta,
                    concepto: propinaventa.concepto,
                    controlhaber: propinaventa.controlhaber,
                    tipocuenta: propinaventa.tipocuenta,
                    Debe: parseFloat($scope.ValPropina),
                    Haber: 0,
                    Descipcion: $scope.observacion
                };
                RegistroC.push(propinav);
            }
            //-- PROPINTA venta


            //--Iva venta
            if (parseFloat($scope.ValIVA) > 0) {
                var ivaventa={};
                for(i=0;i<$scope.Configuracion.length;i++){
                    if($scope.Configuracion[i].Descripcion=="CONT_IVA_COMPRA"){
                        var auxcosto=$scope.Configuracion[i].Contabilidad;
                        ivaventa=auxcosto[0];
                    }
                }
                var iva={
                    idplancuenta: ivaventa.idplancuenta,
                    concepto: ivaventa.concepto,
                    controlhaber: ivaventa.controlhaber,
                    tipocuenta: ivaventa.tipocuenta,
                    Debe: parseFloat($scope.ValIVA),
                    Haber: 0,
                    Descipcion: $scope.observacion
                };
                RegistroC.push(iva);
            }
            //--Iva venta


            var Contabilidad={
                transaccion: Transaccion,
                registro: RegistroC
            };

            //--proceso kardex

            //--proceso kardex

            //--Documento de venta
            var DocVenta={
                //idpuntoventa: $scope.PuntoVentaSeleccionado.idpuntoventa,
                idproveedor: $scope.proveedor.originalObject.proveedor[0].idproveedor,
                idtipoimpuestoiva:$scope.proveedor.originalObject.proveedor[0].idtipoimpuestoiva,

                numdocumentocompra: $('#t_establ').val() + '-' + $('#t_pto').val() + '-' + $('#t_secuencial').val(),

                fecharegistrocompra:$("#fecharegistrocompra").val(),
                fechaemisioncompra:$("#fechaemisioncompra").val(),

                nroautorizacioncompra:$scope.nroautorizacioncompra,
                //nroguiaremision:$("#t_establ_guia").val()+"-"+$("#t_pto_guia").val()+"-"+$("#t_secuencial_guia").val(),

                idsustentotributario: $scope.sustentotributario,
                idtipocomprobante: $scope.tipocomprobante,

                //idcomprobanteretencion: null,

                subtotalconimpuestocompra:$scope.Subtotalconimpuestos,
                subtotalcerocompra:$scope.Subtotalcero,
                subtotalnoobjivacompra:$scope.Subtotalnobjetoiva,
                subtotalexentivacompra:$scope.Subototalexentoiva,
                subtotalsinimpuestocompra:$scope.Subtotalsinimpuestos,
                totaldescuento:$scope.Totaldescuento,
                icecompra:$scope.ValICE,
                ivacompra:$scope.ValIVA,
                irbpnrcompra:$scope.ValIRBPNR,
                propinacompra:$scope.ValPropina,
                otroscompra:0,
                valortotalcompra:$scope.ValorTotal,
                estadoanulado:'false',
                idtransaccion:'',
                datajson:JSON.stringify($scope.items)
            };
            //--Documento de venta

            //--Items venta

            //--Items venta

            /*var dataComprobante = null;

            if ($scope.tipopago != '' && $scope.tipopago != undefined) {

                var pais = null;

                if ($scope.paispago != null && $scope.paispago != undefined && $scope.paispago != '') {
                    pais = $scope.paispago;
                }

                dataComprobante = {
                    tipopago: $scope.tipopago,
                    paispago: pais,
                    regimenfiscal: $scope.regimenfiscal,
                    convenio: $scope.convenio,
                    normalegal: $scope.normalegal,
                    fechaemisioncomprobante: $('#fechaemisioncomprobante').val(),
                    nocomprobante: $('#t_establ_c').val() + '-' + $('#t_pto_c').val() + '-' + $('#t_secuencial_c').val(),
                    noauthcomprobante: $scope.noauthcomprobante
                }
            }*/



            var transaccion_venta_full={
                DataContabilidad: Contabilidad,
              //  Datakardex: kardex,
                DataCompra: DocVenta,
                Idformapagocompra: $scope.formapago,
               // DataItemsCompra: ItemsVenta,
                //dataComprobante: dataComprobante
            };

            console.log(transaccion_venta_full);

            var transaccionfactura={
                datos:JSON.stringify(transaccion_venta_full)
                //datos: transaccion_venta_full
            };

            $http.post(API_URL+'DocumentoCompras',transaccionfactura).success(function (response) {

                    console.log(response);

                if (response.success == true) {
                    $('#btn-save').prop('disabled', true);
                    $('#modalConfirmSave').modal('hide');
                    $scope.message = 'Se insertó correctamente la Compra...';
                    $('#modalMessage1').modal('show');

                }
                else {
                    $('#modalConfirmSave').modal('hide');

                    if (response.document_exist == true) {
                        $scope.message_error = 'Ya existe un documento de compra con dicho numero de factura insertado con mismo proveedor...';
                    } else {
                        $scope.message_error = 'Ha ocurrido un error al intentar guardar la Compra...';
                    }

                    $('#modalMessageError').modal('show');
                }

            })
            .error(function(err){
                console.log(err);
            });
        };

        $scope.confirmSave = function() {
            $('#btn-save0').prop('disabled', false);
            $('#modalConfirmSave').modal('show');
        };

        $scope.anularCompra = function(){

            var object = {
                iddocumentocompra: $scope.compra_anular
            };

            $http.post(API_URL + 'DocumentoCompras/anularCompra', object).success(function(response) {

                $('#modalConfirmAnular').modal('hide');

                if(response.success == true){
                    $scope.initLoad(1);
                    $scope.compra_anular = 0;
                    $scope.message = 'Se ha anulado la compra seleccionada...';
                    $('#modalMessage1').modal('show');

                    $('#btn-anular').prop('disabled', true);

                } else {
                    $scope.message_error = 'Ha ocurrido un error al intentar anular la Compra seleccionada...';
                    $('#modalMessageError').modal('show');
                }

            });
        };

        $scope.viewInfoCompra = function (idcompra) {

            $scope.activeForm(0);

            $http.get(API_URL + 'DocumentoCompras/' + idcompra).success(function (response) {

                console.log(response);

                var Items = response.Items;
                var aux_transaccion = response.Contabilidad[0];

                response = response.Compra[0];

                $scope.itemEditAnular = {
                    iddocumentocompra: response.iddocumentocompra,
                    numdocumentocompra: response.numdocumentocompra
                };

                if (response.estadoanulado == true) {
                    $('#btn-anular').prop('disabled', true);
                } else {
                    $('#btn-anular').prop('disabled', false);
                }

                var numdocumentocompra = (response.numdocumentocompra).split('-');

                $scope.t_establ = numdocumentocompra[0];
                $scope.t_pto = numdocumentocompra[1];
                $scope.t_secuencial = numdocumentocompra[2];
                $scope.nroautorizacioncompra = response.nroautorizacioncompra;
                $scope.sustentotributario = response.idsustentotributario;

                $scope.getTipoComprobante(response.idtipocomprobante);

                $scope.$broadcast('angucomplete-alt:changeInput', 'idproveedor', response.proveedor.persona.numdocidentific);

                $scope.numcompra = response.iddocumentocompra;
                $scope.razon = response.proveedor.persona.razonsocial;
                $scope.direccion =response.proveedor.persona.direccion;
                $scope.telefono = response.proveedor.telefonoprincipal;
                $scope.iva = response.proveedor.sri_tipoimpuestoiva.nametipoimpuestoiva;

                $scope.Subtotalconimpuestos = response.subtotalconimpuestocompra;
                $scope.Subtotalcero = response.subtotalcerocompra;
                $scope.Subtotalnobjetoiva = response.subtotalnoobjivacompra;
                $scope.Subototalexentoiva = response.subtotalexentivacompra;
                $scope.Subtotalsinimpuestos = response.subtotalsinimpuestocompra;
                $scope.Totaldescuento = response.totaldescuento;
                $scope.ValICE = response.icecompra;
                $scope.ValIVA = response.ivacompra;
                $scope.ValIRBPNR = response.irbpnrcompra;
                $scope.ValPropina = response.propinacompra;
                $scope.ValorTotal = response.valortotalcompra;

                $scope.fecharegistrocompra = response.fecharegistrocompra;
                $scope.fechaemisioncompra = response.fechaemisioncompra;

                $scope.observacion = aux_transaccion.descripcion;

                var longitud_item = Items.length;

                $scope.items = [];
                console.log(JSON.parse(response.datajson));
                $scope.items=JSON.parse(response.datajson);
                /*for (var i = 0; i < longitud_item; i++) {

                    if (Items[i].idbodega !== null) {
                        $scope.Bodega = (Items[0].idbodega).toString();
                    }

                    var idcentrocosto = null;

                    if (Items[i].iddepartamento !== null) {
                        idcentrocosto = (Items[i].iddepartamento).toString();
                    }

                    var item = {

                        productoObj:{
                            title: Items[i].codigoproducto,
                            originalObject: Items[i]
                        },

                        cantidad: Items[i].cantidad,
                        precioU: Items[i].preciounitario,
                        descuento: Items[i].descuento,
                        iva : Items[i].porcentiva,
                        ice: Items[i].porcentice,
                        total:Items[i].preciototal,

                        idcentrocosto: idcentrocosto,

                        producto: Items[i].codigoproducto
                    };
                    $scope.items.push(item);

                }*/



                if (response.cont_formapago_documentocompra.length > 0) {
                    $scope.formapago = response.cont_formapago_documentocompra[0].idformapago;
                }

                //$scope.CalculaValores();

                // Campos de Comprobante-------

                if (response.sri_comprobanteretencion != null) {
                    if(response.sri_comprobanteretencion.conveniotributacion == 1) {
                        $scope.regimenfiscal = 1;
                    } else {
                        $scope.regimenfiscal = 2;
                    }

                    if(response.sri_comprobanteretencion.conveniotributacion == 1) {
                        $scope.convenio = 1;
                    } else {
                        $scope.convenio = 2;
                    }

                    if(response.sri_comprobanteretencion.normalegal == 1) {
                        $scope.normalegal = 1;
                    } else {
                        $scope.normalegal = 2;
                    }

                    if(response.sri_comprobanteretencion.idpagopais != null) {
                        $scope.paispago = response.sri_comprobanteretencion.idpagopais;
                    } else {
                        $scope.paispago = '';
                    }

                    $('#fechaemisioncomprobante').val(response.sri_comprobanteretencion.fechaemisioncomprob);

                    var nocomprobante = (response.sri_comprobanteretencion.nocomprobante).split('-');

                    $('#t_establ_c').val(nocomprobante[0]);
                    $('#t_pto_c').val(nocomprobante[1]);
                    $('#t_secuencial_c').val(nocomprobante[2]);
                    $scope.noauthcomprobante = response.sri_comprobanteretencion.noauthcomprobante;

                    $scope.calculateValor();
                }

                $('#btn-save').prop('disabled', true);
                $('#btn-save').hide();


            })
            .error(function(err){
                console.log(err);
            });

        };

        /*
            ------------------------------------------------------------------------------------------        NEW
         */

        $scope.searchByFilter = function(pageNumber){

            var t_search = null;
            var t_proveedorId = null;
            var t_estado = null;

            if($scope.search != undefined && $scope.search != ''){
                t_search = $scope.search;
                var last = t_search.substring(t_search.length -1);
                if (last === "."){
                    t_search = t_search.substring(0,t_search.length -1);
                }
            }

            if($scope.proveedorFiltro0 != undefined && $scope.proveedorFiltro0 != ''){
                t_proveedorId = $scope.proveedorFiltro0;
            }

            if($scope.estadoFiltro != undefined && $scope.estadoFiltro != ''){
                t_estado = $scope.estadoFiltro;
            }

            var filter = {
                text: t_search,
                proveedorId: t_proveedorId,
                estado: t_estado
            };

            $http.get(API_URL + 'DocumentoCompras/getCompras?page=' + pageNumber + '&filter=' + JSON.stringify(filter)).success(function(response){
                $scope.compras = response.data;
                $scope.totalItems = response.total;
            });
        };

        $scope.pageChanged = function(newPage) {
            $scope.searchByFilter(newPage);
        };

        $scope.initLoad = function () {
            $scope.ConfigContable();
            $scope.getProveedorByFilter();
            $scope.searchByFilter(1);
            $scope.getCentrosCostos();
        };

        $scope.sumar = function(v1,v2){
            return $scope.roundToTwo(parseFloat(v1) + parseFloat(v2)).toFixed(2);
        };

        $scope.formatoFecha = function(fecha){
            if(typeof fecha != 'undefined'){
                var t = fecha.split('-');
                var meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
                return t[2] + '-' + meses[t[1]-1] + '-' + t[0];
            } else {
                return '';
            }

        };

        $scope.roundToTwo = function (num) {
            return +(Math.round(num + "e+2")  + "e-2");
        };

        $scope.InicioList=function() {
            $scope.listado =  true;
            $scope.initLoad(1);
        };

        $scope.initLoad();

        $scope.newRow = function(){
            $scope.read =  false;
            return {
                cantidad:0,
                descuento:0,
                idcentrocosto: 0,
                precioUnitario:0,
                iva: $scope.ivaPro,
                ice:0,
                total:0,
                productoObj:null,
                testObj:null
            }

            /*var item = {
                productoObj:null,
                idcentrocosto: 0,
                cantidad:0,
                precioU:0,
                descuento:0,
                iva :0,
                ice:0,
                total:0
            };
            $scope.items.push(item);*/
        };

        $scope.showModalConfirm = function(item){
            $scope.compra_anular = item.iddocumentocompra;
            $scope.numseriecompra = item.numdocumentocompra;
            $('#modalConfirmAnular').modal('show');
        };

        $scope.anular = function () {
            $scope.compra_anular = $scope.itemEditAnular.iddocumentocompra;
            $scope.numseriecompra = $scope.itemEditAnular.numdocumentocompra;

            console.log($scope.compra_anular);

            $('#modalConfirmAnular').modal('show');
        };

        $scope.activeForm = function (action) {

            if (action == 0) {

                $scope.listado = false;

                $scope.itemEditAnular = {};

                $scope.items = [];

                $scope.idproveedor = '';
                $scope.$broadcast('angucomplete-alt:clearInput', 'idproveedor', '');

                $scope.numcompra = '';
                $scope.razon = '';
                $scope.direccion = '';
                $scope.telefono = '';
                $scope.iva = '';
                $scope.nroautorizacioncompra = '';
                $scope.Bodega = '';

                $scope.t_establ = '000';
                $scope.t_pto = '000';
                $scope.t_secuencial = '000000000';

                $scope.sustentotributario = '';
                $scope.tipocomprobante = '';

                $scope.getLastIDCompra();
                $scope.getBodegas();
                $scope.getSustentoTributario();
                $scope.getFormaPago();
                $scope.getTipoPagoComprobante();
                //$scope.getPaisPagoComprobante();

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

                $scope.observacion = '';

                $scope.fecharegistrocompra = $scope.fecha();
                $scope.fechaemisioncompra = $scope.fecha();

                // Campos de Comprobante-------

                /*$scope.estados = [
                    { id: 1, name: 'SI' },
                    { id: 2, name: 'NO' }
                ];

                $scope.regimenfiscal = 1;
                $scope.convenio = 1;
                $scope.normalegal = 1;

                $('#fechaemisioncomprobante').val('');

                $('#t_establ_c').val('000');
                $('#t_pto_c').val('000');
                $('#t_secuencial_c').val('000000000');
                $scope.noauthcomprobante = '';*/

                $scope.createRow();

                $('#btn-anular').prop('disabled', true);
                $('#btn-save').show();

            } else {

                $scope.listado = true;

            }

        };

        $('.datepicker').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            ignoreReadonly: true
        });

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

        $scope.fecha = function(){

            var f = new Date();

            var dd = f.getDate();
            if (dd < 10) dd = '0' + dd;
            var mm = f.getMonth() + 1;
            if (mm < 10) mm = '0' + mm;
            var yyyy = f.getFullYear();
            //var fecha_actual = dd + "\/" + mm + "\/" + yyyy;

            return yyyy + '-' + mm + '-' + dd;

        };

        $scope.typeResident = function () {

            $scope.paispago = '';

            if ($scope.tipopago == '1') {

                $('#paispago').prop('disabled', true);

            } else {

                $('#paispago').prop('disabled', false);

            }
        };
    });


    function QuitarClasesMensaje() {
        $("#titulomsm").removeClass("btn-primary");
        $("#titulomsm").removeClass("btn-warning");
        $("#titulomsm").removeClass("btn-success");
        $("#titulomsm").removeClass("btn-info");
        $("#titulomsm").removeClass("btn-danger");
    }