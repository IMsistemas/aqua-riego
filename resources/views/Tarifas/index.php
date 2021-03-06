

        <div class="container" ng-controller="tarifaController">

            <div class="col-xs-12">

                <h4>Gestión de Tarifas</h4>

                <hr>

            </div>

            <div class="col-xs-12">
                <div class="col-sm-3 col-xs-12">

                    <div class="input-group">
                        <span class="input-group-addon">Año: </span>
                        <input type="text" class="datepicker form-control" name="t_year" id="t_year" ng-model="t_year" ng-change=""/>
                    </div>

                </div>
                <div class="col-sm-4 col-xs-12">

                    <div class="input-group">
                        <span class="input-group-addon">Tipo Tarifa: </span>
                        <select class="form-control" name="t_tarifa" id="t_tarifa"
                                ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                ng-change="getAreaCaudal();"> </select>
                    </div>

                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 10px; font-size: 12px !important;">
                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th colspan="2" class="text-center">AREA</th>
                            <th colspan="2" class="text-center">LITROS X SEGUNDO</th>
                            <th class="text-center">USD</th>
                            <th colspan="3" class="text-center">
                                <button type="button" class="btn btn-info" id="btn_inform" ng-click="generate();">
                                    Generar Tarifa <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-primary" id="btn_edit" ng-click="getListTarifas();" >
                                    Tarifas <i class="fa fa-cog fa-lg" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-default" id="btn_create_row" ng-click="createRow();" disabled>
                                    <i class="fa fa-plus" aria-hidden="true"></i><i class="fa fa-tasks fa-lg" aria-hidden="true"></i>
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 12%;" class="text-center">DESDE</th>
                            <th style="width: 12%;" class="text-center">HASTA</th>
                            <th style="width: 12%;" class="text-center">DESDE</th>
                            <th style="width: 12%;" class="text-center">HASTA</th>
                            <th style="width: 12%;" class="text-center">x LITRO</th>
                            <th class="text-center">OBSERVACIONES</th>
                            <th style="width: 4%;" class="text-center">FIJA</th>
                            <th style="width: 4%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in area_caudal" ng-cloak>
                            <td><input type="text" class="form-control" ng-model="item.area.desde" ng-blur="calculateCaudalDesde(item);" ng-keypress="onlyDecimal($event)"></td>
                            <td><input type="text" class="form-control" ng-model="item.area.hasta" ng-blur="calculateCaudalHasta(item);" ng-keypress="onlyDecimal($event)"></td>
                            <td>{{item.caudal.desde}}</td>
                            <td>{{item.caudal.hasta}}</td>
                            <td><input type="text" class="form-control" ng-model="item.area.costo" ng-keypress="onlyDecimal($event)"></td>
                            <td><textarea rows="2" class="form-control" ng-model="item.area.observacion"></textarea></td>
                            <td>
                                <input type="checkbox" class="form-control" ng-model="item.area.esfija" >
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" ng-click="showDeleteRow(item);" >
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-xs-12 text-right" style="margin: 5px 0 20px 0;">
                <button type="button" class="btn btn-success" id="btn-save-tarifas" ng-click="saveSubTarifas();" disabled>
                    Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                </button>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalTarifa" style="z-index: 99999;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Tarifa - Fecha Ingreso: {{year_ingreso}}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" name="formTarifa" novalidate="">

                                <!--<div class="col-xs-12">

                                    <div class="input-group">
                                        <span class="input-group-addon">Código: </span>
                                        <input type="text" class="form-control" name="idtarifa" id="idtarifa" ng-model="idtarifa" placeholder="" disabled>
                                    </div>

                                </div>-->

                                <input type="hidden" class="form-control" name="idtarifa" id="idtarifa" ng-model="idtarifa">

                                <div class="col-xs-12" style="margin-top: 5px;">

                                    <div class="input-group">
                                        <span class="input-group-addon">Nombre de la Tarifa: </span>
                                        <input type="text" class="form-control" name="nombretarifa" id="nombretarifa" ng-model="nombretarifa" placeholder=""
                                               ng-required="true" ng-maxlength="64">
                                    </div>
                                    <span class="help-block error"
                                          ng-show="formTarifa.nombretarifa.$invalid && formTarifa.nombretarifa.$touched">El nombre de la Tarifa es requerido</span>
                                    <span class="help-block error"
                                          ng-show="formTarifa.nombretarifa.$invalid && formTarifa.nombretarifa.$error.maxlength">La longitud máxima es de 64 caracteres</span>

                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-success" id="btn-save" ng-click="saveTarifa();" ng-disabled="formTarifa.$invalid">
                                Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalListTarifa">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Listado de Tarifas
                            </h4>
                        </div>
                        <div class="modal-body">

                            <div class="col-xs-12">
                                <button type="button" class="btn btn-info" ng-click="showModal();" >
                                    Nueva Tarifa <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                </button>
                            </div>


                            <div class="col-xs-12" style="margin-top: 5px;">

                                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th>ANNO</th>
                                        <th>TARIFA</th>
                                        <th style="width: 25%;">ACCIONES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in listTarifa" ng-cloak>
                                    <td>{{item.aniotarifa}}</td>
                                    <td>{{item.nombretarifa}}</td>
                                    <td class="text-center">

                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" class="btn btn-warning" ng-click="editTarifa(item)">
                                                Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger" ng-click="showModalConfirmTarifa(item)">
                                                Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </div>

                                    </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
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

            <div class="modal fade" tabindex="-1" role="dialog" id="modalMessageError">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirmación</h4>
                        </div>
                        <div class="modal-body">
                            <span>{{message_error}}</span>
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

            <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmDelete">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirmación</h4>
                        </div>
                        <div class="modal-body">
                            <span>Realmente desea eliminar la SubTarifa seleccionada...</span>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-danger" id="btn-save" ng-click="deleteRow()">
                                Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmDeleteTarifa">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirmación</h4>
                        </div>
                        <div class="modal-body">

                            <span>Realmente desea eliminar la Tarifa {{name_tarifa}}...</span>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-danger" id="btn-save" ng-click="deleteTarifa()">
                                Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

   