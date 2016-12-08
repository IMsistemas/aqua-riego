

    <div class="col-xs-12" ng-controller="terrenoController" style="margin-top: 2%;">

        <div class="col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="search" ng-model="search" placeholder="BUSCAR..."
                           ng-model="search" >
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Año:</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" name="s_year" id="s_year"
                               ng-model="s_year" >
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label" ><span style="float: right;">Tarifa:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_tarifa0" id="t_tarifa0"
                                ng-model="t_tarifa0" ng-options="value.id as value.label for value in tarifas"
                                ng-change="getByFilter()"> </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Junta:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_barrio_s" id="t_barrio_s"
                                ng-model="t_barrio_s" ng-options="value.id as value.label for value in barrios_s"
                                ng-change="loadTomas(); getByFilter();"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Toma:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_toma" id="t_toma0"
                                ng-model="t_toma0" ng-options="value.id as value.label for value in tomas_s"
                                ng-change="loadCanales(); getByFilter();"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Canal:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_canales" id="t_canales"
                                ng-model="t_canales" ng-options="value.id as value.label for value in canales_s"
                                ng-change="loadDerivaciones(); getByFilter();"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Derivación:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_derivacion0" id="t_derivacion0"
                                ng-model="t_derivacion0" ng-options="value.id as value.label for value in derivaciones_s"
                                ng-change="getByFilter()"> </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12" style="margin-top: 10px;">
            <table class="table table-responsive table-striped table-hover table-condensed">
                <thead class="bg-primary">
                <tr>
                    <th>Cliente</th>
                    <th style="width: 15%;">Tarifa</th>
                    <th style="width: 10%;">Cultivo</th>
                    <th style="width: 10%;">Derivación</th>
                    <th style="width: 15%;">Junta Modular</th>
                    <th style="width: 6%;">Caudal</th>
                    <th style="width: 8%;">Area (m2)</th>
                    <th style="width: 15%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr dir-paginate="terreno in terrenos | orderBy:sortKey:reverse |itemsPerPage:10  | filter : search" ng-cloak>
                    <td style="font-weight: bold;"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{terreno.cliente.complete_name}}</td>
                    <td>{{terreno.tarifa.nombretarifa}}</td>
                    <td>{{terreno.cultivo.nombrecultivo}}</td>
                    <td>{{terreno.derivacion.nombrederivacion}}</td>
                    <td>{{terreno.derivacion.canal.calle.barrio.nombrebarrio}}</td>
                    <td>{{terreno.caudal}}</td>
                    <td>{{terreno.area}}</td>
                    <td>
                        <button type="button" class="btn btn-info" id="btn_inform" ng-click="loadInformation(terreno)">
                            <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-warning" id="btn_edit" ng-click="edit(terreno)" >
                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                        </button>

                        <span ng-if="terreno.urlescrituras == null">
                            <button type="button" class="btn btn-default" id="btn_pdf" disabled >
                                <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true" style="color: red !important;"></i>
                            </button>
                        </span>

                        <span ng-if="terreno.urlescrituras != null">
                            <button type="button" class="btn btn-default" id="btn_pdf" ng-click="openEscrituras(terreno.urlescrituras)" >
                                <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true" style="color: red !important;"></i>
                            </button>
                        </span>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Editar Terreno Nro: {{num_terreno_edit}}</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formProcess" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -15px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Solicitud</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">
                                                    <i class="fa fa-star" aria-hidden="true"></i> RUC / CI:</span> {{codigo_cliente}}
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">
                                                    <i class="fa fa-user" aria-hidden="true"></i> Cliente:</span> {{nom_cliente}}
                                                <input type="hidden" ng-model="h_codigocliente">
                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-6 col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Dirección Domicilio:</span> {{direcc_cliente}}
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">
                                                    <i class="fa fa-phone" aria-hidden="true"></i> Teléfono:</span> {{telf_cliente}}
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -15px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_terreno" class="col-sm-4 col-xs-12 control-label">Nro Terreno:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_terreno" id="t_terreno"
                                                           ng-model="t_terreno" ng-required="true" ng-pattern="/^([0-9]+)$/" disabled>
                                                    <span class="help-block error"
                                                          ng-show="formProcess.t_doc_id.$invalid && formProcess.t_doc_id.$touched">El Nro. Terreno es requerido</span>
                                                    <span class="help-block error"
                                                          ng-show="formProcess.t_terreno.$invalid && formProcess.t_terreno.$error.pattern">El Nro. Terreno debe ser solo números</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group">

                                                <label for="foto" class="col-sm-4 control-label">Escrituras:</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="file" ngf-select ng-model="file" name="file" id="file"
                                                           ngf-max-size="8MB" >

                                                    <!--<span class="help-block error"
                                                          ng-show="formProcess.file.$error.pattern">El archivo debe ser PDF</span>-->
                                                    <span class="help-block error"
                                                          ng-show="formProcess.file.$error.maxSize">El tamaño máximo es de 8 MB </span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0;">

                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_tarifa" class="col-sm-4 col-xs-12 control-label">Tarifa:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_tarifa" id="t_tarifa"
                                                            ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                                            ng-change="calculateValor(); loadCultivos();"></select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_cultivo" class="col-sm-4 col-xs-12 control-label">Cultivo:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_cultivo" id="t_cultivo"
                                                            ng-model="t_cultivo"
                                                            ng-options="value.id as value.label for value in cultivos"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_area" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Area (m2):</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_area" id="t_area"
                                                           ng-model="t_area" ng-required="true" ng-pattern="/^([0-9.]+)$/" ng-blur="calculateCaudal()">
                                                    <span class="help-block error"
                                                          ng-show="formProcess.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                                    <span class="help-block error"
                                                          ng-show="formProcess.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error" style="margin-top: 8px;">
                                                <div class="col-xs-12" ng-cloak="">
                                                    <span class="label label-info" style="font-size: 20px !important;">Caudal:</span>
                                                    <span style="font-size: 20px !important; font-weight: bold;">{{calculate_caudal}}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Ubicación</legend>

                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_junta" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Junta Modular:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_junta" id="t_junta" ng-change="loadTomasEdit()"
                                                        ng-model="t_junta" ng-options="value.id as value.label for value in barrios"></select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_toma" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Toma:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_toma" id="t_toma"
                                                        ng-model="t_toma" ng-options="value.id as value.label for value in tomas_edit"
                                                        ng-change="loadCanalesEdit()"></select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_canal" class="col-sm-4 col-xs-12 control-label">Canal:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_canal" id="t_canal"
                                                        ng-model="t_canal" ng-options="value.id as value.label for value in canales_edit"
                                                        ng-change="loadDerivacionesEdit()"></select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_derivacion" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Derivación:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_derivacion" id="t_derivacion"
                                                        ng-model="t_derivacion" ng-options="value.id as value.label for value in derivaciones_edit"></select>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <span class="label label-info" style="font-size: 20px !important;">Valor Anual:</span>
                                    <span style="font-size: 20px !important; font-weight: bold;">{{valor_total}}</span>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-process" ng-click="save()">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Terreno No. {{num_terreno}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 text-center">
                            <img class="img-thumbnail" src="<?= asset('img/verTerreno.png') ?>" alt="">
                        </div>
                        <div class="row text-center">
                            <div class="col-xs-12">
                                <span style="font-weight: bold;">Ingresado el: </span>{{fecha_ingreso}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Cliente: </span>{{cliente}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Cultivo: </span>{{cultivo}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Tarifa: </span>{{tarifa}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Area: </span>{{area}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Caudal: </span>{{caudal}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Valor Anual: </span>{{valor_anual}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Junta Modular: </span>{{barrio}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Ubicado en el Canal: </span>{{canal}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Toma: </span>{{toma}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Derivación: </span>{{derivacion}}
                            </div>
                        </div>
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

    </div>

