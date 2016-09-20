<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aqua Riego-Solicitud</title>

        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

    </head>
    <body>

        <div class="col-xs-12" ng-controller="solicitudController" style="margin-top: 2%;">

            <div class="col-xs-12">
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                               ng-model="search" ng-change="">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="t_estado" class="col-sm-4 control-label">Estado:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="t_estado" id="t_estado" ng-model="t_estado"> </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button type="button" class="btn btn-primary" ng-click="toggle('add', 0)">
                        Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <thead class="bg-primary">
                        <tr>
                            <th>Nro. Solicitud</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="solicitud in solicitudes" ng-cloak>
                            <td>{{solicitud.idsolicitud}}</td>
                            <td>{{solicitud.fechasolicitud}}</td>
                            <td>{{solicitud.apellido + ' ' + solicitud.nombre}}</td>
                            <td>{{solicitud.direcciondomicilio}}</td>
                            <td>{{solicitud.telefonoprincipaldomicilio}}</td>
                            <td>{{solicitud.estaprocesada}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalIngSolicitud">
                <div class="modal-dialog" role="document" style="width: 60%;">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Ingresar Solicitud</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" name="formCargo" novalidate="">

                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 form-group">
                                        <label for="t_no_solicitud" class="col-sm-4 col-xs-12 control-label">Nro. Solicitud:</label>
                                        <div class="col-sm-8 col-xs-12">
                                            <input type="text" class="form-control" name="t_no_solicitud" id="t_no_solicitud" ng-model="t_no_solicitud" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 form-group">
                                        <label for="t_fecha_ingreso" class="col-sm-4 col-xs-12 control-label">Fecha Ingreso:</label>
                                        <div class="col-sm-8 col-xs-12">
                                            <input type="text" class="form-control" name="t_fecha_ingreso" id="t_fecha_ingreso" ng-model="t_fecha_ingreso">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="padding: 2%; margin-top: -15px !important;">
                                    <filedset>
                                        <legend>Datos de Cliente</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">
                                                <label for="t_doc_id" class="col-sm-4 col-xs-12 control-label">Documento ID:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_doc_id" id="t_fecha_ingreso" ng-model="t_doc_id">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12"></div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_apellidos" class="col-sm-4 col-xs-12 control-label">Apellidos:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_apellidos" id="t_apellidos" ng-model="t_apellidos">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_nombres" class="col-sm-4 col-xs-12 control-label">Nombre(s):</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_nombres" id="t_nombres" ng-model="t_nombres">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_telf_principal" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Principal:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_telf_principal" id="t_telf_principal" ng-model="t_telf_principal">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_telf_secundario" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Secundario:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_telf_secundario" id="t_telf_secundario" ng-model="t_telf_secundario">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_celular" class="col-sm-4 col-xs-12 control-label">Celular:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_celular" id="t_celular" ng-model="t_celular">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_direccion" class="col-sm-4 col-xs-12 control-label">Dirección:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_direccion" id="t_direccion" ng-model="t_direccion">
                                            </div>
                                        </div>
                                    </filedset>
                                </div>

                                <div class="row" style="padding: 2%;">
                                    <fieldset>
                                        <legend>Datos del Trabajo</legend>
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="t_telf_principal_emp" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Principal:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_telf_principal_emp" id="t_telf_principal_emp" ng-model="t_telf_principal_emp">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <label for="t_telf_secundario_emp" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Secundario:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_telf_secundario_emp" id="t_telf_secundario_emp" ng-model="t_telf_secundario_emp">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <label for="t_direccion_emp" class="col-sm-4 col-xs-12 control-label">Dirección:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" name="t_direccion_emp" id="t_direccion_emp" ng-model="t_direccion_emp">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <!--<div class="form-group">
                                    <label for="t_codigo_cargo" class="col-sm-4 control-label">Código Cargo:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="idcargo" id="idcargo" ng-model="idcargo" placeholder="" disabled>
                                    </div>
                                </div>
                                <div class="form-group error">
                                    <label for="t_name_cargo" class="col-sm-4 control-label">Nombre del Cargo:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nombrecargo" id="nombrecargo" ng-model="nombrecargo" placeholder=""
                                               ng-required="true" ng-maxlength="16">
                                        <span class="help-block error"
                                              ng-show="formCargo.nombrecargo.$invalid && formCargo.nombrecargo.$touched">El nombre del Cargo es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formCargo.nombrecargo.$invalid && formCargo.nombrecargo.$error.maxlength">La longitud máxima es de 16 caracteres</span>
                                    </div>
                                </div>-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-success" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formCargo.$invalid">
                                Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
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
    <script src="<?= asset('app/controllers/solicitudController.js') ?>"></script>

</html>