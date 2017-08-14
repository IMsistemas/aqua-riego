

    <div class="col-xs-12" ng-controller="terrenoController" style="">

        <div class="col-xs-12">

            <h4>Gestión de Terrenos</h4>

            <hr>

        </div>

        <div class="col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="search" ng-model="search" placeholder="BUSCAR..."
                           ng-model="search" ng-keyup="initLoad(1)">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>

            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Año:</span>
                    <input type="text" class="form-control datepicker_year" name="s_year" id="s_year"
                           ng-model="s_year" >
                </div>

            </div>
            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Tarifa:</span>
                    <select class="form-control" name="t_tarifa0" id="t_tarifa0"
                            ng-model="t_tarifa0" ng-options="value.id as value.label for value in tarifas"
                            ng-change="initLoad(1)"> </select>
                </div>

            </div>
        </div>

        <div class="col-xs-12">
            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Junta:</span>
                    <select class="form-control" name="t_barrio_s" id="t_barrio_s"
                            ng-model="t_barrio_s" ng-options="value.id as value.label for value in barrios_s"
                            ng-change="loadTomas(); initLoad(1);"> </select>
                </div>

            </div>

            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Toma:</span>
                    <select class="form-control" name="t_toma" id="t_toma0"
                            ng-model="t_toma0" ng-options="value.id as value.label for value in tomas_s"
                            ng-change="loadCanales(); initLoad(1);"> </select>
                </div>

            </div>

            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Canal:</span>
                    <select class="form-control" name="t_canales" id="t_canales"
                            ng-model="t_canales" ng-options="value.id as value.label for value in canales_s"
                            ng-change="loadDerivaciones(); initLoad(1);"> </select>
                </div>

            </div>

            <div class="col-sm-3 col-xs-12">

                <div class="input-group">
                    <span class="input-group-addon">Derivación:</span>
                    <select class="form-control" name="t_derivacion0" id="t_derivacion0"
                            ng-model="t_derivacion0" ng-options="value.id as value.label for value in derivaciones_s"
                            ng-change="initLoad(1)"> </select>
                </div>

            </div>
        </div>

        <div class="col-xs-12" style="margin-top: 5px;">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>CLIENTE</th>
                    <th style="width: 15%;">TARIFA</th>
                    <th style="width: 10%;">CULTIVO</th>
                    <th style="width: 10%;">DERIVACION</th>
                    <th style="width: 15%;">JUNTA MODULAR</th>
                    <th style="width: 6%;">CAUDAL</th>
                    <th style="width: 8%;">AREA (m2)</th>
                    <th style="width: 10%;">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                <tr dir-paginate="terreno in terrenos | itemsPerPage:10" total-items="totalItems" ng-cloak>
                    <td>{{terreno.razonsocial}}</td>
                    <td>{{terreno.nombretarifa}}</td>
                    <td>{{terreno.nombrecultivo}}</td>
                    <td>{{terreno.nombrederivacion}}</td>
                    <td>{{terreno.namebarrio}}</td>
                    <td class="text-right">{{terreno.caudal}}</td>
                    <td class="text-right">{{terreno.area}}</td>
                    <td>

                        <div class="btn-group" role="group" aria-label="...">
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
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
            <dir-pagination-controls

                    on-page-change="pageChanged(newPageNumber)"

                    template-url="dirPagination.html"

                    class="pull-right"
                    max-size="10"
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



        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionRiego">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Editar Riego Nro: {{num_solicitud_riego}}</h4>
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
                                                           ng-model="t_area" ng-required="true" ng-blur="calculate()">
                                                </div>
                                                <span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                                <!--<span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>-->
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-riego"
                                ng-click="save()" ng-disabled="formProcess.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <!--<button type="button" class="btn btn-primary" id="btn-process-riego"
                                ng-click="procesarSolicitud('btn-process-riego')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>-->
                    </div>
                </div>
            </div>
        </div>

    </div>

