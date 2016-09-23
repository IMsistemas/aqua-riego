<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aqua Riego-Recaudación</title>

    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

    <style>
        td{
            vertical-align: middle !important;
        }
    </style>

</head>
<body>

<div class="col-xs-12" ng-controller="recaudacionController" style="margin-top: 2%;">

    <div class="col-xs-12">
        <div class="col-sm-6 col-xs-12">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                       ng-model="search" ng-change="searchByFilter()">
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
                <th style="width: 5%;">Periodo</th>
                <th>Cliente</th>
                <th style="width: 10%;">Tarifa</th>
                <th style="width: 10%;">Junta</th>
                <th style="width: 10%;">Canal</th>
                <th style="width: 10%;">Toma</th>
                <th style="width: 10%;">Derivación</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 6%;">Total</th>
                <th style="width: 6%;">Acción</th>
            </tr>
            </thead>
            <tbody style="font-size: 13px;">
            <tr ng-repeat="cobro in cobros" ng-cloak>
                <td>{{cobro.fechaperiodo}}</td>
                <td style="font-weight: bold;"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{cobro.apellido + ' ' + cobro.nombre}}</td>
                <td>{{cobro.nombretarifa}}</td>
                <td>{{cobro.nombrebarrio}}</td>
                <td>{{cobro.descripcioncanal}}</td>
                <td>{{cobro.descripciontoma}}</td>
                <td>{{cobro.descripcionderivacion}}</td>
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
                                <div class="col-xs-12 col-sm-6" style="padding: 0;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">Cliente:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{cliente_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">Junta Modular:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{junta_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">Area:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{area_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">Caudal:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{caudal_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">Tarifa:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{tarifa_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">Canal:</span></div>
                                    <div class="col-xs-12 col-sm-8">{{canal_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-3"><span class="label label-default" style="font-size: 14px !important;">Toma:</span></div>
                                    <div class="col-xs-12 col-sm-9">{{toma_info}}</div>
                                </div>
                                <div class="col-xs-12 col-sm-6" style="padding: 0; margin-top: 5px;">
                                    <div class="col-xs-12 col-sm-4"><span class="label label-default" style="font-size: 14px !important;">Derivación:</span></div>
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
                                        <tbody>
                                            <tr>
                                                <td>Consumo Ciclo Corto</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Valores Atrasados</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </fieldset>
                        </div>
                        <div class="col-xs-12" style="font-weight: bold;">
                            <span class="label label-default" style="font-size: 14px !important;">TOTAL:</span> {{total}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-info" id="btn-print" ng-click="">
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
<script src="<?= asset('app/controllers/recaudacionController.js') ?>"></script>

</html>