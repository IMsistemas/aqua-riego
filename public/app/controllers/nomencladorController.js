/**
 * Created by Rafael on 20/02/2017.
 */




app.controller('NomencladorController', function($scope, $http, API_URL, Upload) {

    $scope.sri_tipodocumento = [];
    $scope.idtipodocumento_del = 0;
    $scope.modalstate = '';

    $scope.sri_tipoidentificacion = [];
    $scope.tipoidentificacion_del = 0;

    $scope.sri_tipoimpuesto = [];
    $scope.tipoimpuesto_del = 0;

    $scope.sri_tipoimpuestoIVA = [];
    $scope.tipoimpuestoIVA_del = 0;

    $scope.sri_tipoimpuestoICE = [];
    $scope.tipoimpuestoICE_del = 0;


    $scope.sri_tipoimpuestoRten = [];
    $scope.tipoimpuestoRten_del = 0;


    $scope.sri_ImpuestoIVARENTA = [];
    $scope.ImpuestoIVARENTA_del = 0;


    $scope.sri_SustentoTributario = [];
    $scope.SustentoTributario_del = 0;


    $scope.sri_Comprobante = [];
    $scope.Comprobante_del = 0;

    $scope.sri_pagopais = [];
    $scope.pagopais_del = 0;

    $scope.Con_FormaPago = [];
    $scope.FormaPago_del = 0;

    $scope.Provincias = [];
    $scope.Provincias_del = 0;

    //sri_pagopais



    $scope.pageChanged = function(newPage) {
        $scope.initLoad(newPage);
    };

    /*$scope.initLoad = function(pageNumber){

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };


       $http.get(API_URL + 'Nomenclador/getTipoDocumento?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){



            $scope.sri_tipodocumento = response.data;
            $scope.totalItems = response.total;
        });

    };*/


        $scope.CargadataTPdoc = function (pageNumber){


            //$scope.initLoad = function(pageNumber) {

                if ($scope.busqueda == undefined) {
                    var search = null;
                } else var search = $scope.busqueda;

                var filtros = {
                    search: search
                };


                $http.get(API_URL + 'Nomenclador/getTipoDocumento?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

                    $scope.sri_tipodocumento = response.data;
                    $scope.totalItems = response.total;
                });




            //};

            //console.log("tipodoc");

        };

        //$scope.initLoad(1);

        $scope.CargadataTPident = function (pageNumber) {

            if ($scope.busqueda == undefined) {
                var search = null;
            } else var search = $scope.busqueda;

            var filtros = {
                search: search
            };


            $http.get(API_URL + 'Nomenclador/gettipoidentificacion?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

                $scope.sri_tipoidentificacion = response.data;
                $scope.totalItems = response.total;
                //console.log($scope.sri_tipoidentificacion);
            });

            //console.log($scope.sri_tipoidentificacion);
            //console.log("identificacion");

        };

    $scope.CargadataTPimp = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };


        $http.get(API_URL + 'Nomenclador/getTipoImpuesto?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.sri_tipoimpuesto = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_tipoidentificacion);
        });
    };

    $scope.CargadataImpIVA = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getImpuestoIVA?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.sri_tipoimpuestoIVA = response.data;
            $scope.totalItems = response.total;

            //console.log(response);
        });
    };


    $scope.CargadataImpICE = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getImpuestoICE?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.sri_tipoimpuestoICE = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_tipoidentificacion);
        });
    };


    $scope.CargadataTipoImpRetenc = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };


        $http.get(API_URL + 'Nomenclador/getTipoImpuestoRetenc?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.sri_tipoimpuestoRten = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_tipoidentificacion);
        });
    };

    $scope.CargadataImpIVARENTA = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getImpuestoIVARENTA?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){

            $scope.sri_ImpuestoIVARENTA = response.data;
            $scope.totalItems = response.total;


            //console.log($scope.sri_ImpuestoIVARENTA);
            //console.log(response.total);
        });
    };

    $scope.CargadataSustentoTrib = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getSustentoTributario?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            //console.log(response);
            $scope.sri_SustentoTributario = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };


    $scope.CargadataComprobante = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getTipoComprobante?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            console.log(response);
            $scope.sri_Comprobante = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };

    $scope.CargadataPagoResidente = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getPagoResidente?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            //console.log(response);
            $scope.sri_PagoResidente = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };

    $scope.CargadataPagoPais = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getPagoPais?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            //console.log(response);
            $scope.sri_pagopais = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };

    $scope.CargadataFormaPago = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getContFormaPago?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            //console.log(response);
            $scope.Con_FormaPago = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };

    /*$scope.CargadataProvicias = function (pageNumber) {

        if ($scope.busqueda == undefined) {
            var search = null;
        } else var search = $scope.busqueda;

        var filtros = {
            search: search
        };
        //console.log("aqui estoy");

        $http.get(API_URL + 'Nomenclador/getProvincias?page=' + pageNumber + '&filter=' + JSON.stringify(filtros)).success(function(response){


            //console.log(response);
            $scope.Con_FormaPago = response.data;
            $scope.totalItems = response.total;

            //console.log($scope.sri_SustentoTributario);
        });
    };*/





        $scope.toggle = function(modalstate, id, obafect) {
            $scope.modalstate = modalstate;

            switch (modalstate) {
                case 'add':
                    if (obafect == "tpdocsri") {
                        $scope.form_title = "Nuevo Tipo Documento";
                        $scope.nametipodocumento = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionTipoDoc').modal('show');
                    }
                    if (obafect == "tpidentsri") {
                        $scope.form_title = "Nuevo Tipo Identificacion";
                        $scope.nametipoident = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionTipoIdent').modal('show');
                    }

                    if (obafect == "timpsri") {
                        $scope.form_title = "Nuevo Tipo Impuesto";
                        $scope.nametipoimpuest = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionTipoImp').modal('show');
                    }

                    if (obafect == "tpimpivasri") {
                        $scope.form_title = "Nuevo Tipo Impuesto Iva ";
                        $scope.nameimpuestoiva = '';
                        $scope.porcentaje = '0.00';
                        $scope.codigosri = '';
                        $scope.TipoImpuesto = '1'; // iva
                        $scope.estado = 'true';
                        //CargadataTPimp();
                        $('#modalActionImpuestoIva').modal('show');
                    }

                    if (obafect == "tpimpicesri") {
                        $scope.form_title = "Nuevo Tipo Impuesto Ice ";
                        $scope.nameimpuestoiva = '';
                        $scope.porcentaje = '0.00';
                        $scope.codigosri = '';
                        $scope.TipoImpuesto = '2'; // ice
                        $scope.estado = 'true';
                        //CargadataTPimp();
                        $('#modalActionImpuestoIce').modal('show');
                    }

                    if (obafect == "tpimpretsri") {
                        $scope.form_title = "Nuevo Tipo Impuesto Retencion Renta";
                        $scope.nametipoimpuestoret = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionTipoImpRetRenta').modal('show');
                    }

                    if (obafect == "tpimpivaretsri") {
                        $scope.form_title = "Nuevo Tipo Impuesto Retencion";
                        $scope.TipoImpuesto = '1';
                        $scope.nametipoimpuestoivaret = '';
                        $scope.porcentaje = '0.00';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionTipoImpIvaRetRenta').modal('show');
                    }

                    if (obafect == "sustrib") {
                        $scope.form_title = "Nuevo Sustento Tributario";
                        $scope.nameSustentoTributario = '';
                        $scope.codigosrisustento = '';
                        $scope.estado = 'true';
                        $('#modalActionSustentoTributario').modal('show');
                    }

                    if (obafect == "compsust") {
                        $scope.form_title = "Nuevo Comprobante Sustento Tributario";
                        $scope.TipoSustento = '1';
                        $scope.namecomprobante = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionCompSustentoTributario').modal('show');
                    }

                    if (obafect == "tppagores") {
                        $scope.form_title = "Nuevo Tipo Pago Residente";
                        $scope.tipopagoresidente = '';
                        $('#modalActionPagoResidente').modal('show');
                    }

                    if (obafect == "pagopais") {
                        $scope.form_title = "Nuevo Pais ";
                        $scope.pais = '';
                        $scope.codigosri = '';
                        $('#modalActionPaisPago').modal('show');
                    }

                    if (obafect == "formapago") {
                        $scope.form_title = "Nueva Forma Pago ";
                        $scope.nameformapago = '';
                        $scope.codigosri = '';
                        $scope.estado = 'true';
                        $('#modalActionFormapago').modal('show');
                    }

                    break;
                case 'edit':
                    $scope.idc = id;
                    if (obafect == "tpdocsri") {
                        $scope.form_title = "Editar Tipo Documento";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getTipoDocByID/' + id).success(function(response) {
                            //console.log(response);
                            $scope.nametipodocumento = response[0].nametipodocumento.trim();
                            $scope.codigosri = response[0].codigosri.trim();
                            //console.log(response[0].estado);
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            //console.log($scope.estado);
                            //$scope.estado = response[0].estado;
                            $('#modalActionTipoDoc').modal('show');
                        });
                    }
                    if (obafect == "tpidentsri") {
                        $scope.form_title = "Editar Tipo identificacion";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getTipoIdentByID/' + id).success(function(response) {
                            $scope.nametipoident = response[0].nameidentificacion.trim();
                            $scope.codigosri = response[0].codigosri.trim();
                            //$scope.estado = response[0].estado;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            $('#modalActionTipoIdent').modal('show');
                        });
                    }
                    if (obafect == "timpsri") {
                        $scope.form_title = "Editar Tipo Impuesto";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getTipoImpuestoByID/' + id).success(function(response) {
                            $scope.nametipoimpuest = response[0].nameimpuesto.trim();
                            $scope.codigosri = response[0].codigosri.trim();
                            //$scope.estado = response[0].estado;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            $('#modalActionTipoImp').modal('show');
                        });
                    }

                    if (obafect == "tpimpivasri") {
                        $scope.form_title = "Editar Impuesto Iva";
                        $scope.idtipodocumento = id;

                        $http.get(API_URL + 'Nomenclador/getTipoImpuestoIvaByID/' + id).success(function(response) {
                            //console.log(response);
                            $scope.nameimpuestoiva = response[0].nametipoimpuestoiva.trim();
                            $scope.porcentaje = response[0].porcentaje;
                            $scope.codigosri = response[0].codigosri;
                            $scope.TipoImpuesto = response[0].idtipoimpuesto.toString();
                            //$scope.estado = response[0].estado;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            $('#modalActionImpuestoIva').modal('show');
                        });
                    }

                    if (obafect == "tpimpicesri") {
                        $scope.form_title = "Editar Impuesto Ice";
                        $scope.idtipodocumento = id;
                        //console.log(id);
                        $http.get(API_URL + 'Nomenclador/getTipoImpuestoIceByID/' + id).success(function(response) {
                            //console.log(response);
                            $scope.nameimpuestoice = response[0].nametipoimpuestoice.trim();
                            $scope.porcentaje = response[0].porcentaje;
                            $scope.codigosri = response[0].codigosri;
                            $scope.TipoImpuesto = response[0].idtipoimpuesto.toString();
                            //$scope.estado = response[0].estado;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            $('#modalActionImpuestoIce').modal('show');
                        });
                    }

                    if (obafect == "tpimpretsri") {

                        $scope.form_title = "Editar Tipo Impuesto Retencion Renta";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getTipoImpuestoRetencionRetByID/' + id).success(function(response) {
                            //console.log(response);
                            $scope.nametipoimpuestoret = response[0].nametipoimpuestoretencion.trim();
                            $scope.codigosri = response[0].codigosri.trim();
                            //$scope.estado = response[0].estado;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }
                            $('#modalActionTipoImpRetRenta').modal('show');
                        });
                    }

                    if (obafect == "tpimpivaretsri") {
                    //console.log('aqui')
                    //console.log(id)
                    $scope.form_title = "Editar Tipo Impuesto Retencion ";
                    $scope.idtipodocumento = id;
                    $http.get(API_URL + 'Nomenclador/getTipoImpuestoRetencionIvaRetByID/' + id).success(function(response) {
                        //console.log(response);
                        $scope.nametipoimpuestoivaret = response[0].namedetalleimpuestoretencion.trim();
                        $scope.TipoImpuesto = response[0].idtipoimpuestoretencion.toString();
                        $scope.porcentaje = response[0].porcentaje;
                        $scope.codigosri = response[0].codigosri;
                        //$scope.estado = response[0].estado;
                        if(response[0].estado){
                            $scope.estado = 'true' ;
                        }
                        else
                        {
                            $scope.estado = 'false'
                        }
                        //console.log('aqui');
                        $('#modalActionTipoImpIvaRetRenta').modal('show');
                    });
                }

                    if (obafect == "sustrib") {
                    //console.log('aqui')
                    //console.log(id)
                    $scope.form_title = "Editar Sustento Tributario ";
                    $scope.idtipodocumento = id;
                    $http.get(API_URL + 'Nomenclador/getSustentoTributarioByID/' + id).success(function(response) {
                        //console.log(response);
                        $scope.nameSustentoTributario = response[0].namesustento.trim();
                        $scope.codigosrisustento = response[0].codigosrisustento;
                        //$scope.estado = response[0].estado;
                        if(response[0].estado){
                            $scope.estado = 'true' ;
                        }
                        else
                        {
                            $scope.estado = 'false'
                        }
                        //console.log('aqui');
                        $('#modalActionSustentoTributario').modal('show');
                    });
                }

                    if (obafect == "compsust") {
                        //console.log('aqui')
                        //console.log(id)
                        $scope.form_title = "Editar Comprobante Sustento Tributario ";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getComprobanteTributarioByID/' + id).success(function(response) {
                            console.log(response);
                            $scope.namecomprobante =  response[0].namecomprobante;
                            $scope.codigosri = response[0].codigosri;

                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }

                            $http.get(API_URL + 'Nomenclador/getSustentoComprobanteByID/' + id).success(function(response) {

                                $scope.TipoSustento = response[0].idsustentotributario.toString();

                            });

                            //console.log('aqui');
                            $('#modalActionCompSustentoTributario').modal('show');
                        });
                    }

                    if (obafect == "tppagores") {
                        //console.log('aqui')
                        //console.log(id)
                        $scope.form_title = "Editar Tipo de Pago Residente ";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getPagoResidenteByID/' + id).success(function(response) {
                            //console.log(response);
                            $scope.tipopagoresidente =  response[0].tipopagoresidente;

                            $('#modalActionPagoResidente').modal('show');
                        });
                    }

                    if (obafect == "pagopais") {
                        //console.log('aqui')
                        //console.log(id)
                        $scope.form_title = "Editar Pais ";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getPaisPagoByID/' + id).success(function(response) {
                            $scope.pais =  response[0].pais;
                            $scope.codigosri = response[0].codigosri;

                            $('#modalActionPaisPago').modal('show');
                        });
                    }

                    if (obafect == "formapago") {
                        //console.log('aqui')
                        //console.log(id)
                        $scope.form_title = "Editar Forma Pago ";
                        $scope.idtipodocumento = id;
                        $http.get(API_URL + 'Nomenclador/getFormaPagoByID/' + id).success(function(response) {
                            $scope.nameformapago =  response[0].nameformapago;
                            $scope.codigosri = response[0].codigosri;
                            if(response[0].estado){
                                $scope.estado = 'true' ;
                            }
                            else
                            {
                                $scope.estado = 'false'
                            }

                            $('#modalActionFormapago').modal('show');
                        });
                    }

                    break;
                default:
                    break;
            }
        };

        $scope.Save = function (tbafect){

            var url = API_URL + "Nomenclador";
            var method = 'POST';

            //console.log(tbafect);

            if (tbafect == "tpdocsri"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nametipodocumento: $scope.nametipodocumento.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };
            }

            //console.log(data);

            if (tbafect == "tpidentsri"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nameidentificacion: $scope.nametipoident.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };

            }

            if (tbafect == "timpsri"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nameimpuesto: $scope.nametipoimpuest.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };

            }

            if (tbafect == "tpimpiva"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nameimpuestoiva: $scope.nameimpuestoiva.toUpperCase(),
                    porcentaje: $scope.porcentaje,
                    codigosri: $scope.codigosri,
                    TipoImpuesto: $scope.TipoImpuesto,
                    //TipoImpuesto: 1,
                    estado: $scope.estado
                };
            }


            if (tbafect == "tpimpice"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nameimpuestoice: $scope.nameimpuestoice.toUpperCase(),
                    porcentaje: $scope.porcentaje,
                    codigosri: $scope.codigosri,
                    TipoImpuesto: $scope.TipoImpuesto,
                    //TipoImpuesto: 1,
                    estado: $scope.estado
                };
            }

            if (tbafect == "tpimpretsri"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nametipoimpuestoretencion: $scope.nametipoimpuestoret.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };
            }

            if (tbafect == "tpimpivaretsri"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    namedetalleimpuestoretencion: $scope.nametipoimpuestoivaret.toUpperCase(),
                    porcentaje: $scope.porcentaje,
                    idtipoimpuestoretencion:$scope.TipoImpuesto,
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };
            }

            if (tbafect == "sustrib"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    namesustentotributario: $scope.nameSustentoTributario.toUpperCase(),
                    codigosrisustento: $scope.codigosrisustento,
                    estado: $scope.estado
                };

            }

            if (tbafect == "compsust"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    idtSustento: $scope.TipoSustento,
                    namecomprobante: $scope.namecomprobante.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };


            }

            if (tbafect == "tppagores"){
                var data = {
                    tipopagoresidente: $scope.tipopagoresidente.toUpperCase()
                };

            }

            if (tbafect == "pagopais"){
                var data = {
                    pais: $scope.pais.toUpperCase(),
                    codigosri: $scope.codigosri
                };

            }

            if (tbafect == "formapago"){

                if ($scope.estado==undefined) {
                    $scope.estado = 'true';
                }

                var data = {
                    nameformapago: $scope.nameformapago.toUpperCase(),
                    codigosri: $scope.codigosri,
                    estado: $scope.estado
                };

            }

            //console.log(data);
            //console.log(data);

            switch ( $scope.modalstate) {
                case 'add':

                    if (tbafect == "tpdocsri"){

                        $http.post(API_URL + 'Nomenclador', data ).success(function (response) {
                            if (response.success == true) {
                                $scope.CargadataTPdoc();
                                $('#modalActionTipoDoc').modal('hide');
                                $scope.message = 'Se insertó correctamente el Tipo Documento...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {
                                $('#modalActionTipoDoc').modal('hide');
                                $scope.message_error = 'Ya existe ese Tipo Documento...';
                                $('#modalMessageError').modal('show');
                            }
                        });
                        break;
                    }


                    if (tbafect == "tpidentsri"){
                        $http.post(API_URL + 'Nomenclador/storeTipoIdent', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataTPident ();
                                $('#modalActionTipoIdent').modal('hide');
                                $scope.message = 'Se insertó correctamente el Tipo Identificacion...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionTipoIdent').modal('hide');
                                $scope.message_error = 'Ya existe ese Tipo Identificacion...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });
                        break;
                    }

                    if (tbafect == "timpsri"){

                        $http.post(API_URL + 'Nomenclador/storeTipoImpuesto', data ).success(function (response) {
                            if (response.success == true) {
                                $scope.CargadataTPimp ();
                                $('#modalActionTipoImp').modal('hide');
                                $scope.message = 'Se insertó correctamente el Tipo Impuesto...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionTipoImp').modal('hide');
                                $scope.message_error = 'Ya existe ese Tipo Impuesto...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });
                        break;
                    }

                    if (tbafect == "tpimpiva"){
                        //console.log('AQUI')
                        $http.post(API_URL + 'Nomenclador/storeTipoImpuestoiva', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataImpIVA();
                                $('#modalActionImpuestoIva').modal('hide');
                                $scope.message = 'Se insertó correctamente el Impuesto Iva...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionImpuestoIva').modal('hide');
                                $scope.message_error = 'Ya existe ese Impuesto Iva...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });
                        break;
                    }

                    if (tbafect == "tpimpice"){
                        //console.log('AQUI')
                        $http.post(API_URL + 'Nomenclador/storeTipoImpuestoice', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataImpICE();
                                $('#modalActionImpuestoIce').modal('hide');
                                $scope.message = 'Se insertó correctamente el Impuesto Ice...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionImpuestoIce').modal('hide');
                                $scope.message_error = 'Ya existe ese Impuesto Ice...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }


                    if (tbafect == "tppagores"){
                        //console.log('AQUI')
                        $http.post(API_URL + 'Nomenclador/storeTipoPagoResidente', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataPagoResidente();
                                $('#modalActionPagoResidente').modal('hide');
                                $scope.message = 'Se insertó correctamente el Impuesto Ice...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionPagoResidente').modal('hide');
                                $scope.message_error = 'Ya existe ese Impuesto Ice...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }

                    if (tbafect == "tpimpretsri"){
                        $http.post(API_URL + 'Nomenclador/storeTipoImpuestoReten', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataTipoImpRetenc();
                                $('#modalActionTipoImpRetRenta').modal('hide');
                                $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionTipoImpRetRenta').modal('hide');
                                $scope.message_error = 'Ya existe ese  Registro...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }


                    if (tbafect == "tpimpivaretsri"){
                        //console.log(data);
                        $http.post(API_URL + 'Nomenclador/storeTipoImpuestoIvaReten', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataImpIVARENTA();
                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message_error = 'Ya existe ese  Registro...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }


                    if (tbafect == "sustrib"){
                    //console.log(data);
                    $http.post(API_URL + 'Nomenclador/storeSustentoTrib', data ).success(function (response) {
                        if (response.success == true) {

                            $scope.CargadataSustentoTrib();
                            $('#modalActionSustentoTributario').modal('hide');
                            $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                            $('#modalMessage').modal('show');
                            $scope.hideModalMessage();
                            //console.log("true");
                        }
                        else {

                            $('#modalActionSustentoTributario').modal('hide');
                            $scope.message_error = 'Ya existe ese  Registro...';
                            $('#modalMessageError').modal('show');
                            //console.log("false");
                        }
                    });

                    break;
                }

                    if (tbafect == "compsust"){
                        //console.log(data);
                        $http.post(API_URL + 'Nomenclador/storeTipoPagoResidente', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataComprobante();
                                $('#modalActionCompSustentoTributario').modal('hide');
                                $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionCompSustentoTributario').modal('hide');
                                $scope.message_error = 'Ya existe ese  Registro...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }

                    if (tbafect == "pagopais"){
                        //console.log(data);
                        $http.post(API_URL + 'Nomenclador/storepagopais', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataPagoPais();
                                $('#modalActionPaisPago').modal('hide');
                                $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionPaisPago').modal('hide');
                                $scope.message_error = 'Ya existe ese  Registro...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }

                    if (tbafect == "formapago"){
                        //console.log(data);
                        $http.post(API_URL + 'Nomenclador/storeformapago', data ).success(function (response) {
                            if (response.success == true) {

                                $scope.CargadataFormaPago();
                                $('#modalActionFormapago').modal('hide');
                                $scope.message = 'Se insertó correctamente el Registro Correctamente...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                                //console.log("true");
                            }
                            else {

                                $('#modalActionFormapago').modal('hide');
                                $scope.message_error = 'Ya existe ese  Registro...';
                                $('#modalMessageError').modal('show');
                                //console.log("false");
                            }
                        });

                        break;
                    }

                case 'edit':
                    //console.log($scope.idc);

                    if (tbafect == "tpdocsri"){

                        $http.put(API_URL + 'Nomenclador/'+ $scope.idc, data ).success(function (response) {
                            $scope.CargadataTPdoc();
                            $('#modalActionTipoDoc').modal('hide');
                            $scope.message = 'Se editó correctamente el Registro seleccionado';
                            $('#modalMessage').modal('show');
                            $scope.hideModalMessage();
                        }).error(function (res) {

                        });
                        break;
                    }
                    if (tbafect == "tpidentsri"){
                            url += "/updatetpidentsri/" + $scope.idc
                            Upload.upload({
                                url: url,
                                method: method,
                                data: data
                            }).success(function(data, status, headers, config) {
                                if (data.success == true) {
                                    $scope.idpersona = 0;

                                    $scope.objectPerson = {
                                        idperson: 0,
                                        identify: ''
                                    };

                                    $scope.CargadataTPident();
                                    $('#modalActionTipoIdent').modal('hide');
                                    $scope.message = 'Se editó correctamente el Registro seleccionado';
                                    $('#modalMessage').modal('show');
                                    $scope.hideModalMessage();
                                }
                                else {
                                    $('#modalActionTipoIdent').modal('hide');
                                    $scope.message_error = 'Ya existe el Registro...';
                                    $('#modalMessage').modal('show');
                                    $scope.hideModalMessage();
                                }
                            });

                        break;

                    }
                    if (tbafect == "timpsri"){
                        url += "/updatetpimpsri/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataTPimp();
                                $('#modalActionTipoImp').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionTipoImp').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "tpimpiva"){
                        url += "/updatetpimpIvasri/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataImpIVA();
                                $('#modalActionImpuestoIva').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionImpuestoIva').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;

                    }

                    if (tbafect == "tpimpice"){
                        url += "/updatetpimpIcesri/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataImpICE();
                                $('#modalActionImpuestoIce').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionImpuestoIce').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "tpimpretsri"){
                        url += "/updatetpimpRetensri/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataImpIVARENTA();
                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "tpimpivaretsri"){
                        url += "/updatetpimpIvaRetensri/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataImpIVARENTA();
                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionTipoImpIvaRetRenta').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "sustrib"){
                        url += "/updateSustentoTributario/" + $scope.idc
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataSustentoTrib();
                                $('#modalActionSustentoTributario').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionSustentoTributario').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "compsust"){
                        url += "/updateSustento_Comprobante/" + $scope.idc
                    //console.log($scope.idc);
                        Upload.upload({
                        url: url,
                        method: method,
                        data: data
                    }).success(function(data, status, headers, config) {
                        if (data.success == true) {

                            $scope.CargadataSustentoTrib();
                            $('#modalActionCompSustentoTributario').modal('hide');
                            $scope.message = 'Se editó correctamente el Registro seleccionado';
                            $('#modalMessage').modal('show');
                            $scope.hideModalMessage();
                        }
                        else {
                            $('#modalActionCompSustentoTributario').modal('hide');
                            $scope.message_error = 'Ya existe el Registro...';
                            $('#modalMessage').modal('show');
                            $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "tppagores"){
                        url += "/updatePagoResidente/" + $scope.idc
                        //console.log($scope.idc);
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataPagoResidente();
                                $('#modalActionPagoResidente').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionPagoResidente').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "pagopais"){
                        url += "/updatePagoPais/" + $scope.idc
                        //console.log($scope.idc);
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataPagoPais();
                                $('#modalActionPaisPago').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionPaisPago').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }

                    if (tbafect == "formapago"){
                        url += "/updateFormaPago/" + $scope.idc
                        //console.log($scope.idc);
                        Upload.upload({
                            url: url,
                            method: method,
                            data: data
                        }).success(function(data, status, headers, config) {
                            if (data.success == true) {

                                $scope.CargadataFormaPago();
                                $('#modalActionFormapago').modal('hide');
                                $scope.message = 'Se editó correctamente el Registro seleccionado';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                            else {
                                $('#modalActionFormapago').modal('hide');
                                $scope.message_error = 'Ya existe el Registro...';
                                $('#modalMessage').modal('show');
                                $scope.hideModalMessage();
                            }
                        });

                        break;
                    }
            }
        };

        $scope.showModalConfirm = function(tipodocumento,tbafect){

            if (tbafect == "tpdocsri"){

                $scope.idtipodocumento_del = tipodocumento.idtipodocumento;
                $scope.tipodocument_seleccionado = tipodocumento.nametipodocumento;
                $scope.TipoAccion =  "tpdocsri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "tpidentsri"){
                //console.log(tipodocumento);
                $scope.idtipodocumento_del = tipodocumento.idtipoidentificacion;
                $scope.tipodocument_seleccionado = tipodocumento.nameidentificacion;
                $scope.TipoAccion =  "tpidentsri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "timpsri"){
                //console.log(tipodocumento);
                $scope.idtipodocumento_del = tipodocumento.idtipoimpuesto;
                $scope.tipodocument_seleccionado = tipodocumento.nameimpuesto;
                $scope.TipoAccion =  "timpsri";
                $('#modalConfirmDelete').modal('show');
            }
            if (tbafect == "tpimpivasri"){
                //console.log(tipodocumento);
                $scope.idtipodocumento_del = tipodocumento.idtipoimpuestoiva;
                $scope.tipodocument_seleccionado = tipodocumento.nametipoimpuestoiva;
                $scope.TipoAccion =  "tpimpivasri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "tpimpicesri"){
                //console.log(tipodocumento);
                $scope.idtipodocumento_del = tipodocumento.idtipoimpuestoice;
                $scope.tipodocument_seleccionado = tipodocumento.nametipoimpuestoice;
                $scope.TipoAccion =  "tpimpicesri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "tpimpretsri"){

                $scope.idtipodocumento_del = tipodocumento.idtipoimpuestoretencion;
                $scope.tipodocument_seleccionado = tipodocumento.nametipoimpuestoretencion;
                $scope.TipoAccion =  "tpimpretsri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "tpimpivaretsri"){

                $scope.idtipodocumento_del = tipodocumento.iddetalleimpuestoretencion;
                $scope.tipodocument_seleccionado = tipodocumento.namedetalleimpuestoretencion;
                $scope.TipoAccion =  "tpimpivaretsri";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "sustrib"){

                $scope.idtipodocumento_del = tipodocumento.idsustentotributario;
                $scope.tipodocument_seleccionado = tipodocumento.namesustento;
                $scope.TipoAccion =  "sustrib";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "compsust"){

                $scope.idtipodocumento_del = tipodocumento.idtipocomprobante;
                $scope.tipodocument_seleccionado = tipodocumento.namecomprobante;
                $scope.TipoAccion =  "compsust";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "tppagores"){

                $scope.idtipodocumento_del = tipodocumento.idpagoresidente;
                $scope.tipodocument_seleccionado = tipodocumento.tipopagoresidente;
                $scope.TipoAccion =  "tppagores";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "pagopais"){

                $scope.idtipodocumento_del = tipodocumento.idpagopais;
                $scope.tipodocument_seleccionado = tipodocumento.pais;
                $scope.TipoAccion =  "pagopais";
                $('#modalConfirmDelete').modal('show');
            }

            if (tbafect == "formapago"){

                $scope.idtipodocumento_del = tipodocumento.idformapago;
                $scope.tipodocument_seleccionado = tipodocumento.nameformapago;
                $scope.TipoAccion =  "formapago";
                $('#modalConfirmDelete').modal('show');
            }
        };

        $scope.delete = function(tbafect){


            var data = {
                id: $scope.idtipodocumento_del
            };

            //console.log($scope.TipoAccion);
            //console.log(tbafect);

            if (tbafect == "tpdocsri"){

                $http.delete(API_URL + 'Nomenclador/' + $scope.idtipodocumento_del).success(function(response) {

                    //console.log(response.success);
                    if(response.success == true){
                        //$scope.initLoad();
                        $scope.CargadataTPdoc();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.idtipodocumento_del = 0;
                        $scope.message = 'Se eliminó correctamente el Tipo Documento seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El Tipo Documento no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });

            }


            if (tbafect == "tpidentsri"){


                //console.log('estoy aqui');
                //console.log(data);
                $http.post(API_URL + 'Nomenclador/deleteTipoIdentSRI', data).success(function(response) {

                    //console.log(response.success);
                    if(response.success == true){
                        //$scope.initLoad();
                        $scope.CargadataTPident();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Tipo de Identificacion seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El Tipo de Identificacion no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }


            if (tbafect == "timpsri"){

                //console.log(data);

                $http.post(API_URL + 'Nomenclador/deleteTipoImpuesto', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataTPimp();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Tipo Impuesto seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El Tipo Impuesto no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "tpimpivasri"){

                $http.post(API_URL + 'Nomenclador/deleteTipoImpuestoIva', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataImpIVA();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Impuesto Iva seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El Impuesto Iva no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "tpimpicesri"){

                $http.post(API_URL + 'Nomenclador/deleteTipoImpuestoIce', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataImpICE();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Impuesto Ice seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El Impuesto Ice no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "tpimpretsri"){

                $http.post(API_URL + 'Nomenclador/deleteTipoImpuestoRetencion', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataTipoImpRetenc();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "tpimpivaretsri"){

                $http.post(API_URL + 'Nomenclador/deleteTipoImpuestoIvaRetencion', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataImpIVARENTA();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "sustrib"){

                $http.post(API_URL + 'Nomenclador/deleteSustentoTrib', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataSustentoTrib();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            //compsust

            if (tbafect == "compsust"){

                $http.post(API_URL + 'Nomenclador/deleteSustentoComprobante', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataComprobante();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "tppagores"){

                $http.post(API_URL + 'Nomenclador/deleteTipoPagoResidente', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataPagoResidente();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "pagopais"){

                $http.post(API_URL + 'Nomenclador/deletepagopais', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataPagoPais();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }

            if (tbafect == "formapago"){

                $http.post(API_URL + 'Nomenclador/deleteformapago', data).success(function(response) {


                    if(response.success == true){

                        $scope.CargadataFormaPago();
                        $('#modalConfirmDelete').modal('hide');
                        $scope.tipoidentificacion_del = 0;
                        $scope.message = 'Se eliminó correctamente el Registro seleccionado...';
                        $('#modalMessage').modal('show');
                        $scope.hideModalMessage();

                    } else {
                        $scope.message_error = 'El registro no puede ser eliminado porque esta asignado a un colaborador...';
                        $('#modalMessageError').modal('show');
                        $('#modalConfirmDelete').modal('hide');
                    }
                });
            }
        };





        $scope.hideModalMessage = function () {
            setTimeout("$('#modalMessage').modal('hide')", 3000);
        };


        //$scope.initLoad();

});

