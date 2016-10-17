<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>

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

        <div class="col-xs-12" ng-controller="solicitudController" style="margin-top: 2%;">

            <div class="col-xs-12">
                <div class="col-sm-4 col-xs-12">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="search" placeholder="BUSCAR..." ng-model="search">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="t_estado" class="col-sm-5 control-label">Tipo Solicitud:</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="t_estado" id="t_tipo_solicitud"
                                    ng-model="t_tipo_solicitud" ng-options="value.id as value.name for value in tipo"
                                    ng-change="searchByFilter()"> </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="t_estado" class="col-sm-4 control-label">Estado:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="t_estado" id="t_estado"
                                    ng-model="t_estado" ng-options="value.id as value.name for value in estados"
                                    ng-change="searchByFilter()"> </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <thead class="bg-primary">
                    <tr>
                        <th style="width: 10%;">Nro. Solicitud</th>
                        <th style="width: 10%;">Fecha</th>
                        <th>Cliente</th>
                        <th>Dirección</th>
                        <th style="width: 10%;">Teléfono</th>
                        <th style="width: 10%;">Tipo Solicitud</th>
                        <th style="width: 10%;">Estado</th>
                        <th style="width: 14%;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="solicitud in solicitudes | filter : search" ng-cloak>
                        <td>{{solicitud.no_solicitud}}</td>
                        <td>{{solicitud.fecha | formatDate}}</td>
                        <td style="font-weight: bold;"><i class="fa fa-user fa-lg" aria-hidden="true"></i> {{solicitud.cliente}}</td>
                        <td>{{solicitud.direccion}}</td>
                        <td>{{solicitud.telefono}}</td>
                        <td>{{solicitud.tipo}}</td>
                        <td ng-if="solicitud.estado == true"><span class="label label-primary" style="font-size: 14px !important;">Procesada</span></td>
                        <td ng-if="solicitud.estado == false"><span class="label label-warning" style="font-size: 14px !important;">En Espera</span></td>
                        <td ng-if="solicitud.estado == true">
                            <button type="button" class="btn btn-info" id="btn_inform" ng-click="info(solicitud)" >
                                <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-primary" id="btn_process" ng-click="" disabled>
                                <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
                            </button>

                            <span ng-if="solicitud.tipo == 'Riego'">
                                <button type="button" class="btn btn-default" id="btn_pdf" ng-click="" >
                                    <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true" style="color: red !important;"></i>
                                </button>
                            </span>


                        </td>
                        <td ng-if="solicitud.estado == false">
                            <button type="button" class="btn btn-info" id="btn_inform" disabled>
                                <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-primary" id="btn_process" ng-click="showModalProcesar(solicitud)" >
                                <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
                            </button>
                            <span ng-if="solicitud.tipo == 'Riego'">
                                <button type="button" class="btn btn-default" id="btn_pdf" disabled>
                                    <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true" style="color: red !important;"></i>
                                </button>
                            </span>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalProcesar">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirmación</h4>
                        </div>
                        <div class="modal-body">
                            <span>
                                Desea procesar la Solicitud Nro: <strong>"{{num_solicitud_process}}"</strong>
                                del Cliente: <strong>"{{cliente_process}}"</strong> de Tipo: <strong>"{{tipo_process}}"</strong>...
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="procesarSolicitud()">
                                Procesar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoSolOtros">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Otra Solicitud Nro.: {{no_info_otro}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 text-center">
                                <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                            </div>
                            <div class="row text-center">

                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ingresada el: </span>{{ingresada_info_otro}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Procesada el: </span>{{procesada_info_otro}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Cliente: </span>{{cliente_info_otro}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Descripción: </span>{{descripcion_info_otro}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoSolRiego">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Solicitud de Riego Nro.: {{no_info_riego}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 text-center">
                                <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                            </div>
                            <div class="row text-center">

                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ingresada el: </span>{{ingresada_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Procesada el: </span>{{procesada_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Cliente: </span>{{cliente_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Terreno Nro: </span>{{noterreno_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Junta Modular: </span>{{junta_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ubicado en la Toma: </span>{{toma_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Canal: </span>{{canal_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Derivación: </span>{{derivacion_info_riego}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Area: </span>{{area_info_riego}} (m2)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoSolSetName">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Solicitud de Cambio de Nombre Nro.: {{no_info_setN}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 text-center">
                                <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                            </div>
                            <div class="row text-center">

                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ingresada el: </span>{{ingresada_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Procesada el: </span>{{procesada_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Cliente: </span>{{cliente_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Terreno Nro: </span>{{noterreno_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Junta Modular: </span>{{junta_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ubicado en la Toma: </span>{{toma_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Canal: </span>{{canal_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Derivación: </span>{{derivacion_info_setN}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Area: </span>{{area_info_setN}} (m2)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoSolFraccion">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Solicitud de Fraccionamiento Nro.: {{no_info_fraccion}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 text-center">
                                <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                            </div>
                            <div class="row text-center">

                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Ingresada el: </span>{{ingresada_info_fraccion}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Procesada el: </span>{{procesada_info_fraccion}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Cliente: </span>{{cliente_info_fraccion}}
                                </div>

                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Area Arrendada: </span>{{area_info_fraccion}} (m2)
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
    <script src="<?= asset('app/controllers/solicitudController.js') ?>"></script>

</html>