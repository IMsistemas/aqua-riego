

<div class="col-xs-12" ng-controller="recaudacionController" style="margin-top: 2%;">

    <div class="col-xs-12">
        <div class="col-sm-6 col-xs-12">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                       ng-model="search" >
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="t_estado" class="col-sm-4 control-label">Estado:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="t_estado" id="t_estado"
                            ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                            ng-change="searchByFilter()"> </select>
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-xs-12" style="padding: 0;">
            <button type="button" id="btn-generate" class="btn btn-primary" style="float: right;" ng-click="generate()" disabled>
                Generar <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="col-xs-12">
        <table class="table table-responsive table-striped table-hover table-condensed">
            <thead class="bg-primary">
            <tr>
                <th style="width: 5%;" ng-click="sort('aniocobro')">
                    Periodo
                    <span class="glyphicon sort-icon" ng-show="sortKey=='aniocobro'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                </th>
                <th ng-click="sort('complete_name')">
                    Cliente
                    <span class="glyphicon sort-icon" ng-show="sortKey=='complete_name'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                </th>
                <th style="width: 10%;">Tarifa</th>
                <th style="width: 10%;">Junta</th>
                <th style="width: 10%;">Toma</th>
                <th style="width: 10%;">Canal</th>
                <th style="width: 10%;">Derivación</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 6%;" ng-click="sort('total')">
                    Total
                    <span class="glyphicon sort-icon" ng-show="sortKey=='total'"
                          ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                </th>
                <th style="width: 6%;">Acción</th>
            </tr>
            </thead>
            <tbody style="font-size: 13px;">
            <tr dir-paginate="cobro in cobros | orderBy:sortKey:reverse |itemsPerPage:10 | filter : search" ng-cloak>
                <td>{{cobro.aniocobro}}</td>
                <td style="font-weight: bold;"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{cobro.complete_name}}</td>
                <td>{{cobro.nombretarifa}}</td>
                <td>{{cobro.nombrebarrio}}</td>
                <td>{{cobro.nombrecalle}}</td>
                <td>{{cobro.nombrecanal}}</td>
                <td>{{cobro.nombrederivacion}}</td>
                <td ng-if="cobro.estapagada == true"><span class="label label-primary" style="font-size: 14px !important;">Pagada</span></td>
                <td ng-if="cobro.estapagada == false"><span class="label label-warning" style="font-size: 14px !important;">No Pagada</span></td>
                <td>{{cobro.total}}</td>
                <td>
                    <button type="button" class="btn btn-info" id="btn_inform" ng-click="infoAction(cobro)" >
                        <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                    </button>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoAction">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <div class="col-xs-12">Nueva Cuenta</div>
                        <div class="col-xs-12">Periodo: {{periodo}}</div>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <fieldset>
                                <legend>Datos de Terreno</legend>
                                <div class="col-xs-12 col-sm-6" style="padding: 0;  margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-user" aria-hidden="true"></i> Cliente:</span>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">{{cliente_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-list" aria-hidden="true"></i> Tarifa:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{tarifa_info}}</div>
                                </div>

                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-globe" aria-hidden="true"></i> Area:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{area_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-globe" aria-hidden="true"></i> Caudal:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{caudal_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0;  margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-5"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i> Junta Modular:</span></div>
                                    <div class="col-xs-12 col-sm-7">{{junta_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i> Toma:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{toma_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-list" aria-hidden="true"></i> Canal:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{canal_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">
                                            <i class="fa fa-list" aria-hidden="true"></i> Derivación:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{derivacion_info}}</div>
                                </div>
                            </fieldset>

                            <input type="hidden" ng-model="idcuenta">

                        </div>
                        <div class="col-xs-12">
                            <fieldset>
                                <legend>Rubros</legend>

                                <div class="col-xs-12">
                                    <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>Rubro</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-cloak>
                                            <tr>
                                                <td>{{tipo_tarifa}}</td>
                                                <td class="text-right">{{valor_base_tarifa}}</td>
                                            </tr>
                                            <tr>
                                                <td>Valores Atrasados</td>
                                                <td class="text-right">{{valor_atrasado}}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right" style="font-weight: bold;">TOTAL</th>
                                                <th class="text-right">{{total}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-info" id="btn-print" ng-click="imprimir();">
                        Imprimir <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-pagar" ng-click="pagar()">
                        Pagar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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
                <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <span>{{message_error}}</span>
                </div>
            </div>
        </div>
    </div>

    <div id="region-imprimir" style="font-family: Arial; display: none;">
        <div class="col-xs-12">
            <fieldset style="border-radius: 5px;">
                <legend>Datos de Terreno</legend>

                <table border="0" style="width: 100%;">

                    <tbody>
                        <tr>
                            <td style="width: 18%; font-weight: bold;">Cliente:</td>
                            <td style="width: 35%;">{{cliente_info}}</td>
                            <td style="width: 12%; font-weight: bold;">Tarifa:</td>
                            <td style="width: 35%;">{{tarifa_info}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Area:</td>
                            <td>{{area_info}}</td>
                            <td style="font-weight: bold;">Caudal:</td>
                            <td>{{caudal_info}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Junta Modular:</td>
                            <td>{{junta_info}}</td>
                            <td style="font-weight: bold;">Toma:</td>
                            <td>{{toma_info}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Canal:</td>
                            <td>{{canal_info}}</td>
                            <td style="font-weight: bold;">Derivación:</td>
                            <td>{{derivacion_info}}</td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
        </div>
        <div class="col-xs-12">
            <fieldset style="border-radius: 5px;">
                <legend>Rubros</legend>

                <div class="col-xs-12">
                    <table  border="1" style="width: 100%;" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Rubro</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{tipo_tarifa}}</td>
                                <td style="text-align: right;">{{valor_base_tarifa}}</td>
                            </tr>
                            <tr>
                                <td>Valores Atrasados</td>
                                <td style="text-align: right;">{{valor_atrasado}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL:</th>
                                <th style="text-align: right;">{{total}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>

