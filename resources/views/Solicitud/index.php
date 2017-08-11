

    <div class="col-xs-12" ng-controller="solicitudController" style="">

        <div class="col-xs-12">

            <h4>Gestión de Solicitudes</h4>

            <hr>

        </div>

        <div class="col-xs-12">
            <div class="col-sm-4 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="search" placeholder="BUSCAR..." ng-model="search">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Tipo Solicitud:</span>
                    <select class="form-control" name="t_estado" id="t_tipo_solicitud"
                            ng-model="t_tipo_solicitud" ng-options="value.id as value.name for value in tipo"
                            ng-change="initLoad(1)"> </select>
                </div>

            </div>
            <div class="col-sm-4 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Estado:</span>
                    <select class="form-control" name="t_estado" id="t_estado"
                            ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                            ng-change="initLoad(1)"> </select>
                </div>

            </div>

        </div>

        <div class="col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th style="width: 5%;">NO.</th>
                    <th style="width: 10%;">FECHA</th>
                    <th>CLIENTE</th>
                    <th>DIRECCION</th>
                    <th style="width: 10%;">TELEFONO</th>
                    <th style="width: 10%;">TIPO SOLICITUD</th>
                    <th style="width: 10%;">ESTADO</th>
                    <th style="width: 10%;">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                <tr dir-paginate="solicitud in solicitudes | orderBy:sortKey:reverse |itemsPerPage:10 | filter : search" ng-cloak>
                    <td>{{solicitud.idsolicitud}}</td>
                    <td>{{solicitud.fechasolicitud | formatDate}}</td>
                    <td>{{solicitud.razonsocial}}</td>
                    <td>{{solicitud.direccion}}</td>
                    <td>{{solicitud.telefonoprincipaldomicilio}}</td>
                    <td>{{solicitud.tipo}}</td>
                    <td ng-if="solicitud.estaprocesada == true" class="btn-success" style="font-weight: bold;">PROCESADA</td>
                    <td ng-if="solicitud.estaprocesada == false" class="btn-warning" style="font-weight: bold;">EN ESPERA</td>
                    <td>

                        <div class="btn-group" role="group" aria-label="...">

                            <button type="button" class="btn btn-info" id="btn_inform" ng-click="info(solicitud)" >
                                <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                            </button>

                            <span ng-if="solicitud.tipo == 'Riego'">
                                <button type="button" class="btn btn-default" id="btn_pdf" ng-click="viewPDF(solicitud)" >
                                    <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true" style="color: red !important;"></i>
                                </button>
                            </span>

                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
            <dir-pagination-controls
                    max-size="5"
                    direction-links="true"
                    boundary-links="true" >
            </dir-pagination-controls>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionRiego">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Solicitud de Riego Nro: {{num_solicitud_riego}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_process"
                                           id="t_fecha_process" ng-model="t_fecha_process" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formProcess" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente" id="documentoidentidad_cliente"
                                                           ng-model="documentoidentidad_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cliente: </span>
                                                    <input class="form-control" type="text" name="nom_cliente" id="nom_cliente"
                                                           ng-model="nom_cliente" disabled >
                                                </div>

                                                <input type="hidden" ng-model="h_codigocliente">
                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente" id="direcc_cliente"
                                                           ng-model="direcc_cliente" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente" id="celular_cliente"
                                                           ng-model="celular_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente" id="telf_cliente"
                                                           ng-model="telf_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente" id="telf_trab_cliente"
                                                           ng-model="telf_trab_cliente" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-xs-12" style="padding: 0; margin-top: -15px;">
                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Nro. Terreno: </span>
                                                    <input class="form-control" type="text" name="nro_terreno" id="nro_terreno" ng-model="nro_terreno" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Escrituras: </span>
                                                    <input class="form-control" type="file" ngf-select ng-model="file" name="file" id="file"
                                                           ngf-max-size="8MB" >
                                                </div>
                                                <!--<span class="help-block error"
                                                          ng-show="formProcess.file.$error.pattern">El archivo debe ser PDF</span>-->
                                                <span class="help-block error"
                                                      ng-show="formProcess.file.$error.maxSize">El tamaño máximo es de 8 MB </span>
                                            </div>


                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Tipo Cultivo: </span>
                                                    <select class="form-control" name="t_tarifa" id="t_tarifa"
                                                            ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                                            ng-change="getCultivos()"></select><!--ng-change="showAddCultivo()"-->
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cultivo: </span>
                                                    <select class="form-control" name="t_cultivo" id="t_cultivo"
                                                            ng-model="t_cultivo" ng-options="value.id as value.label for value in cultivos">
                                                    </select><!--ng-change="showAddCultivo()"-->
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12 error">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Area (m2): </span>
                                                    <input type="text" class="form-control" name="t_area" id="t_area" ng-keypress="onlyNumber($event)"
                                                           ng-model="t_area" ng-required="true" ng-pattern="/^([0-9.]+)$/" ng-blur="calculate()">
                                                </div>
                                                <span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                                <span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Caudal: </span>
                                                    <input class="form-control" type="text" name="calculate_caudal" id="calculate_caudal" ng-model="calculate_caudal" disabled >
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Valor Anual: </span>
                                                    <input class="form-control" type="text" name="valor_total" id="valor_total" ng-model="valor_total" disabled >
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -35px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Ubicación</legend>
                                        <div class="col-sm-6 col-xs-12 error">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <select class="form-control" name="t_junta" id="t_junta"
                                                        ng-model="t_junta" ng-options="value.id as value.label for value in barrios"
                                                        ng-change="getTomas()" ></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <select class="form-control" name="t_toma" id="t_toma"
                                                        ng-model="t_toma" ng-options="value.id as value.label for value in tomas"
                                                        ng-change="getCanales()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <select class="form-control" name="t_canal" id="t_canal"
                                                        ng-model="t_canal" ng-options="value.id as value.label for value in canales"
                                                        ng-change="getDerivaciones()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <select class="form-control" name="t_derivacion" id="t_derivacion"
                                                        ng-model="t_derivacion" ng-options="value.id as value.label for value in derivaciones"></select>
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_riego" ng-model="t_observacion_riego" rows="2" placeholder="Observación"></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer" id="modal-footer-riego">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-riego"
                                ng-click="saveSolicitudRiego()" ng-disabled="formProcess.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-riego"
                                ng-click="procesarSolicitudRiego()" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionSetNombre">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Solicitud de Cambio de Nombre Nro: {{num_solicitud_setnombre}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_setnombre"
                                           id="t_fecha_setnombre" ng-model="t_fecha_setnombre" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formSetNombre" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente actual</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente_setnombre" id="documentoidentidad_cliente_setnombre"
                                                           ng-model="documentoidentidad_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Nombre y Apellidos: </span>
                                                    <input class="form-control" type="text" name="nom_cliente_setnombre" id="nom_cliente_setnombre"
                                                           ng-model="nom_cliente_setnombre" disabled >
                                                </div>
                                                <input type="hidden" ng-model="h_codigocliente_setnombre">

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente_setnombre" id="direcc_cliente_setnombre"
                                                           ng-model="direcc_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente_setnombre" id="telf_cliente_setnombre"
                                                           ng-model="telf_cliente_setnombre" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente_setnombre" id="telf_clcelular_cliente_setnombreiente_setnombre"
                                                           ng-model="celular_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente_setnombre" id="telf_trab_cliente_setnombre"
                                                           ng-model="telf_trab_cliente_setnombre" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Terrenos </span>
                                                <select class="form-control" name="t_terrenos_setnombre" id="t_terrenos_setnombre"
                                                        ng-model="t_terrenos_setnombre" ng-options="value.id as value.label for value in terrenos_setN"
                                                        ng-change="searchInfoTerreno()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <input class="form-control" type="text" name="junta_setnombre" id="junta_setnombre"
                                                       ng-model="junta_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <input class="form-control" type="text" name="toma_setnombre" id="toma_setnombre"
                                                       ng-model="toma_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <input class="form-control" type="text" name="canal_setnombre" id="canal_setnombre"
                                                       ng-model="canal_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <input class="form-control" type="text" name="derivacion_setnombre" id="derivacion_setnombre"
                                                       ng-model="derivacion_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cultivo: </span>
                                                <input class="form-control" type="text" name="cultivo_setnombre" id="cultivo_setnombre"
                                                       ng-model="cultivo_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area (m2): </span>
                                                <input class="form-control" type="text" name="area_setnombre" id="area_setnombre"
                                                       ng-model="area_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_setnombre" id="caudal_setnombre"
                                                       ng-model="caudal_setnombre" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del nuevo Cliente</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <select class="form-control"
                                                        name="t_ident_new_client_setnombre" id="t_ident_new_client_setnombre"
                                                        ng-model="t_ident_new_client_setnombre" ng-options="value.id as value.label for value in clientes_setN"
                                                        ng-change="getClienteByIdentify()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_new_cliente_setnombre" id="nom_new_cliente_setnombre"
                                                       ng-model="nom_new_cliente_setnombre" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_new_codigocliente_setnombre">

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Dirección Domicilio: </span>
                                                <input class="form-control" type="text" name="direcc_new_cliente_setnombre" id="direcc_new_cliente_setnombre"
                                                       ng-model="direcc_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Domicilio: </span>
                                                <input class="form-control" type="text" name="telf_new_cliente_setnombre" id="telf_new_cliente_setnombre"
                                                       ng-model="telf_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Celular: </span>
                                                <input class="form-control" type="text" name="celular_new_cliente_setnombre" id="celular_new_cliente_setnombre"
                                                       ng-model="celular_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Trabajo: </span>
                                                <input class="form-control" type="text" name="telf_trab_new_cliente_setnombre" id="telf_trab_new_cliente_setnombre"
                                                       ng-model="telf_trab_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>
                                <div class="col-xs-12" style="">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_setnombre" ng-model="t_observacion_setnombre" rows="2" placeholder="Observacion"></textarea>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" id="modal-footer-setnombre">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-setnombre"
                                ng-click="saveSolicitudSetName()" ng-disabled="formSetNombre.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-setnombre"
                                ng-click="procesarSolicitudSetN()" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionFraccion">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Solicitud de Fraccionamiento Nro: {{num_solicitud_fraccion}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_fraccion" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_fraccion"
                                           id="t_fecha_fraccion" ng-model="t_fecha_fraccion" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formFraccion" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <input class="form-control" type="text" name="documentoidentidad_cliente_fraccion" id="documentoidentidad_cliente_fraccion"
                                                       ng-model="documentoidentidad_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_cliente_fraccion" id="nom_cliente_fraccion"
                                                       ng-model="nom_cliente_fraccion" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_codigocliente_fraccion">
                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Dirección Domicilio: </span>
                                                <input class="form-control" type="text" name="direcc_cliente_fraccion" id="direcc_cliente_fraccion"
                                                       ng-model="direcc_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Domicilio: </span>
                                                <input class="form-control" type="text" name="telf_cliente_fraccion" id="telf_cliente_fraccion"
                                                       ng-model="telf_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Celular: </span>
                                                <input class="form-control" type="text" name="celular_cliente_fraccion" id="celular_cliente_fraccion"
                                                       ng-model="celular_cliente_fraccion" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Trabajo: </span>
                                                <input class="form-control" type="text" name="telf_trab_cliente_fraccion" id="telf_trab_cliente_fraccion"
                                                       ng-model="telf_trab_cliente_fraccion" disabled >
                                            </div>

                                        </div>


                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Terrenos: </span>
                                                <select class="form-control" name="t_terrenos_fraccion" id="t_terrenos_fraccion"
                                                        ng-model="t_terrenos_fraccion" ng-options="value.id as value.label for value in terrenos_fraccion"
                                                        ng-change="searchInfoTerrenoFraccion()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <input class="form-control" type="text" name="junta_fraccion" id="junta_fraccion"
                                                       ng-model="junta_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <input class="form-control" type="text" name="toma_fraccion" id="toma_fraccion"
                                                       ng-model="toma_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <input class="form-control" type="text" name="canal_fraccion" id="canal_fraccion"
                                                       ng-model="canal_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <input class="form-control" type="text" name="derivacion_fraccion" id="derivacion_fraccion"
                                                       ng-model="derivacion_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Tipo Cultivo: </span>
                                                <input class="form-control" type="text" name="cultivo_fraccion" id="cultivo_fraccion"
                                                       ng-model="cultivo_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area Actual (m2): </span>
                                                <input class="form-control" type="text" name="area_fraccion" id="area_fraccion"
                                                       ng-model="area_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_fraccion" id="caudal_fraccion"
                                                       ng-model="caudal_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Valor: </span>
                                                <input class="form-control" type="text" name="valor_fraccion" id="valor_fraccion"
                                                       ng-model="valor_fraccion" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area Fracc.: </span>
                                                <input type="text" class="form-control" name="t_area_fraccion" id="t_area_fraccion" ng-keypress="onlyNumber($event)"
                                                       ng-model="t_area_fraccion" ng-required="true" ng-pattern="/^([0-9]+)$/" ng-blur="calculateFraccion()">
                                            </div>
                                            <span class="help-block error"
                                                  ng-show="formFraccion.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                            <span class="help-block error"
                                                  ng-show="formFraccion.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_new_fraccion" id="caudal_new_fraccion"
                                                       ng-model="caudal_new_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Valor: </span>
                                                <input class="form-control" type="text" name="valor_new_fraccion" id="valor_new_fraccion"
                                                       ng-model="valor_new_fraccion" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Nuevo Cliente</legend>

                                        <div class="col-sm-5 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <select class="form-control"
                                                        name="t_ident_new_client_fraccion" id="t_ident_new_client_fraccion"
                                                        ng-model="t_ident_new_client_fraccion" ng-options="value.id as value.label for value in clientes_fraccion"
                                                        ng-change="getClienteByIdentifyFraccion()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-5 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_new_cliente_fraccion" id="nom_new_cliente_fraccion"
                                                       ng-model="nom_new_cliente_fraccion" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_new_codigocliente_fraccion">

                                        </div>

                                        <div class="col-sm-2 col-xs-12">
                                            <input type="checkbox" class="" ng-model="ch_arriend_fraccion"> Arriendo
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="margin-top: -15px;">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_fraccion" ng-model="t_observacion_fraccion" rows="2" placeholder="Observacion"></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-fraccion"
                                ng-click="saveSolicitudFraccion()" ng-disabled="formFraccion.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-fraccion"
                                ng-click="procesarSolicitud('btn-process-fraccion')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionOtro">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Otra Solicitud Nro: {{num_solicitud_otro}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_otro"
                                           id="t_fecha_otro" ng-model="t_fecha_otro" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formProcessOtros" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente_otro" id="documentoidentidad_cliente_otro"
                                                           ng-model="documentoidentidad_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cliente: </span>
                                                    <input class="form-control" type="text" name="nom_cliente_otro" id="nom_cliente_otro"
                                                           ng-model="nom_cliente_otro" disabled >
                                                </div>

                                                <input type="hidden" ng-model="h_codigocliente_otro">
                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente_otro" id="direcc_cliente_otro"
                                                           ng-model="direcc_cliente_otro" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente_otro" id="celular_cliente_otro"
                                                           ng-model="celular_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente_otro" id="telf_cliente_otro"
                                                           ng-model="telf_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente_otro" id="telf_trab_cliente_otro"
                                                           ng-model="telf_trab_cliente_otro" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_otro" ng-model="t_observacion_otro" rows="2" ng-required="true" placeholder="Observación"></textarea>
                                        <span class="help-block error"
                                              ng-show="formProcessOtros.t_observacion_otro.$invalid && formProcessOtros.t_observacion_otro.$touched">La Descripción es requerida</span>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer" id="modal-footer-otro">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-otro"
                                ng-click="saveSolicitudOtro();" ng-disabled="formProcessOtros.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-otro"
                                ng-click="procesarSolicitudOtro()" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id="modalMessage">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-success">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>{{message}}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalMessageInfo">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Información</h4>
                    </div>
                    <div class="modal-body">
                        <span>{{message_info}}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
