<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aqua Riego-Tarifas</title>

        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

        <style>
            td{
                vertical-align: middle !important;
            }

            .datepicker{
                color: #000 !important;
            }
        </style>

    </head>
    <body>

        <div class="col-xs-12" ng-controller="tarifaController" style="margin-top: 2%;">

            <div class="col-xs-12">
                <div class="col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Año:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker" name="s_anno" id="s_anno" ng-model="s_anno" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="t_tarifa" class="col-sm-4 control-label"><span style="float: right;">Tipo:</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="t_tarifa" id="t_tarifa"
                                    ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                    ng-change="getAreaCaudal();"> </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12" style="margin-top: 10px;">
                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th colspan="2" class="text-center">AREA</th>
                            <th colspan="2" class="text-center">LITROS X SEGUNDO</th>
                            <th>USD</th>
                            <th colspan="3" class="text-center">
                                <button type="button" class="btn btn-info" id="btn_inform" ng-click="">
                                    Generar Tarifa <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-info" id="btn_edit" ng-click="showModal();" >
                                    Nueva <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-default" id="btn_edit" ng-click="createRow();" >
                                    <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                </button>
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 15%;">Desde</th>
                            <th style="width: 15%;">Hasta</th>
                            <th style="width: 15%;">Desde</th>
                            <th style="width: 15%;">Hasta</th>
                            <th style="width: 15%;">x Litro</th>
                            <th>Observaciones</th>
                            <th style="width: 4%;">Fija</th>
                            <th style="width: 4%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in area_caudal">
                            <td><input type="text" class="form-control" ng-model="item.area.desde" ng-blur="calculateCaudalDesde(item);"></td>
                            <td><input type="text" class="form-control" ng-model="item.area.hasta" ng-blur="calculateCaudalHasta(item);"></td>
                            <td>{{item.caudal.desde}}</td>
                            <td>{{item.caudal.hasta}}</td>
                            <td><input type="text" class="form-control" ng-model="item.area.costo"></td>
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

            <div class="col-xs-12 text-right" style="margin-top: 10px">
                <button type="button" class="btn btn-success" id="btn-save" ng-click="saveSubTarifas();">
                    Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                </button>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalTarifa">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                Nueva Tarifa <br>
                                Fecha Ingreso: {{year_ingreso}}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" name="formTarifa" novalidate="">
                                <div class="form-group">
                                    <label for="t_codigo_cargo" class="col-sm-4 control-label">Código:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="idtarifa" id="idtarifa" ng-model="idtarifa" placeholder="" disabled>
                                    </div>
                                </div>
                                <div class="form-group error">
                                    <label for="t_name_cargo" class="col-sm-4 control-label">Nombre de la Tarifa:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nombretarifa" id="nombretarifa" ng-model="nombretarifa" placeholder=""
                                               ng-required="true" ng-maxlength="64">
                                        <span class="help-block error"
                                              ng-show="formTarifa.nombretarifa.$invalid && formTarifa.nombretarifa.$touched">El nombre de la Tarifa es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formTarifa.nombretarifa.$invalid && formTarifa.nombretarifa.$error.maxlength">La longitud máxima es de 16 caracteres</span>
                                    </div>
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

        </div>

    </body>

    <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
    <script src="<?= asset('js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js') ?>"></script>

    <script src="<?= asset('js/moment.min.js') ?>"></script>
    <script src="<?= asset('js/es.js') ?>"></script>
    <script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= asset('app/app.js') ?>"></script>
    <script src="<?= asset('app/controllers/tarifaController.js') ?>"></script>

</html>