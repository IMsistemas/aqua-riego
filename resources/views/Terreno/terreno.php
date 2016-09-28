<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aqua Riego-Edición Terreno</title>

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

    <div class="col-xs-12" ng-controller="terrenoController" style="margin-top: 2%;">

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
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Año:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_estado" id="t_estado"
                                ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                                ng-change="searchByFilter()"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label" ><span style="float: right;">Tarifa:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_estado" id="t_estado"
                                ng-model="t_estado" ng-options="value.id as value.label for value in tarifas"
                                ng-change="searchByFilter()"> </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Canal:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_estado" id="t_estado"
                                ng-model="t_estado" ng-options="value.id as value.label for value in canales"
                                ng-change="searchByFilter()"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Toma:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_estado" id="t_estado"
                                ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                                ng-change="searchByFilter()"> </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="t_estado" class="col-sm-4 control-label"><span style="float: right;">Derivación:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_estado" id="t_estado"
                                ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                                ng-change="searchByFilter()"> </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12" style="margin-top: 10px;">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th>Cliente</th>

                    <th style="width: 15%;">Tarifa</th>
                    <th style="width: 10%;">Cultivo</th>
                    <th style="width: 10%;">Derivación</th>
                    <th style="width: 15%;">Junta Modular</th>
                    <th style="width: 8%;">Caudal</th>
                    <th style="width: 10%;">Area (m2)</th>
                    <th style="width: 10%;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="terreno in terrenos" ng-cloak>
                    <td style="font-weight: bold;"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{terreno.cliente.apellido + ' ' + terreno.cliente.nombre}}</td>
                    <td>{{terreno.tarifa.nombretarifa}}</td>
                    <td>{{terreno.cultivo.nombrecultivo}}</td>
                    <td>{{terreno.derivacion.descripcionderivacion}}</td>
                    <td>{{terreno.barrio.nombrebarrio}}</td>
                    <td>{{terreno.caudal}}</td>
                    <td>{{terreno.area}}</td>
                    <td>
                        <button type="button" class="btn btn-info" id="btn_inform" ng-click="loadInformation(terreno)">
                            <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-warning" id="btn_edit" ng-click="edit(terreno)" >
                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
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
                                                <span class="label label-default" style="font-size: 12px !important;">Cliente:</span> {{nom_cliente}}
                                                <input type="hidden" ng-model="h_codigocliente">
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">Teléfono:</span> {{telf_cliente}}
                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-xs-12">
                                                <span class="label label-default" style="font-size: 12px !important;">Dirección Domicilio:</span> {{direcc_cliente}}
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
                                        </div>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_junta" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Junta Modular:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_junta" id="t_junta"
                                                            ng-model="t_junta" ng-options="value.id as value.label for value in barrios"></select>
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
                                            <label for="t_tarifa" class="col-sm-4 col-xs-12 control-label">Tarifa:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_tarifa" id="t_tarifa"
                                                        ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                                        ng-change="calculateValor()"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_canal" class="col-sm-4 col-xs-12 control-label">Canal:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_canal" id="t_canal"
                                                        ng-model="t_canal" ng-options="value.id as value.label for value in canales"
                                                        ng-change="loadTomas()"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 form-group error">
                                            <label for="t_toma" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Toma:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <select class="form-control" name="t_toma" id="t_toma"
                                                        ng-model="t_toma" ng-options="value.id as value.label for value in tomas_edit"
                                                        ng-change="loadDerivaciones()"></select>
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
                        <button type="button" class="btn btn-success" id="btn-process" ng-click="save()" ng-disabled="formProcess.$invalid">
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

    </body>

    <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
    <script src="<?= asset('js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js') ?>"></script>

    <script src="<?= asset('js/moment.min.js') ?>"></script>
    <script src="<?= asset('js/es.js') ?>"></script>
    <script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= asset('app/app.js') ?>"></script>
    <script src="<?= asset('app/controllers/terrenoController.js') ?>"></script>

</html>