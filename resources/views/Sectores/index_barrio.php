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
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

</head>
<body>
    <div ng-controller="barrioController">

        <div class="col-xs-12">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="viewModalAdd()">Nuevo</button>
            </div>
        </div>

        <div class="col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th style="width: 15%;">Fecha de Ingreso</th>
                        <th style="width: 15%;">Nombre de la Junta</th>
                        <th style="">Tomas</th>
                        <th style="width: 15%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in barrios" ng-cloak>
                        <td>{{item.fechaingreso}}</td>
                        <td>{{item.nombrebarrio}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalNueva">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            Nueva Junta Modular <br>
                            Fecha Ingreso: {{date_ingreso}}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formBarrio" novalidate="">
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Código: {{codigo}}</label>
                            </div>

                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Parroquia:</label>
                                <div class="col-sm-8">
                                    <select id="t_parroquias" class="form-control" ng-model="t_parroquias"
                                            ng-options="value.id as value.label for value in parroquias"></select>
                                </div>
                            </div>

                            <div class="form-group error">
                                <label for="t_name" class="col-sm-4 control-label">Nombre de la Junta:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nombrebarrio" ng-model="nombrebarrio" placeholder=""
                                           ng-required="true" ng-maxlength="64">
                                    <span class="help-block error"
                                          ng-show="formBarrio.nombrebarrio.$invalid && formBarrio.nombrebarrio.$touched">El nombre de la Junta es requerido</span>
                                    <span class="help-block error"
                                          ng-show="formBarrio.nombrebarrio.$invalid && formBarrio.nombrebarrio.$error.maxlength">La longitud máxima es de 64 caracteres</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Observaciones:</label>
                                <div class="col-sm-8">
                                    <textarea id="observacionBarrio" class="form-control" rows="5" ng-model="observacionBarrio"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveBarrio();" ng-disabled="formBarrio.$invalid">
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

    </div>
</body>

<script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>

<script src="<?= asset('app/app.js') ?>"></script>
<script src="<?= asset('app/controllers/barrioController.js') ?>"></script>

</html>