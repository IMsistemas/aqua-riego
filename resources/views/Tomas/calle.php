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
<div ng-controller="callesController">
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
                <th style="width: 15%;">Nombre de la Toma</th>
                <th style="">Derivaciones</th>
                <th style="width: 15%;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="item in calles" ng-cloak>
                <td>{{item.fechaingreso}}</td>
                <td>{{item.nombrecalle}}</td>
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
                        Nueva Toma <br>
                        Fecha Ingreso: {{date_ingreso}}
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" name="formCalle" novalidate="">
                        <div class="form-group">
                            <label for="t_codigo" class="col-sm-4 control-label">Código: {{codigo}}</label>
                        </div>

                        <div class="form-group">
                            <label for="t_barrio" class="col-sm-4 control-label">Barrio:</label>
                            <div class="col-sm-8">
                                <select id="t_barrio" class="form-control" ng-model="t_barrio"
                                        ng-options="value.id as value.label for value in barrios"></select>
                            </div>
                        </div>

                        <div class="form-group error">
                            <label for="nombrecalle" class="col-sm-4 control-label">Nombre de la Toma:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nombrecalle" ng-model="nombrecalle" placeholder=""
                                       ng-required="true" ng-maxlength="64">
                                <span class="help-block error"
                                      ng-show="formCalle.nombrecalle.$invalid && formCalle.nombrecalle.$touched">El nombre de la Toma es requerido</span>
                                <span class="help-block error"
                                      ng-show="formCalle.nombrecalle.$invalid && formCalle.nombrecalle.$error.maxlength">La longitud máxima es de 64 caracteres</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observacionCalle" class="col-sm-4 control-label">Observaciones:</label>
                            <div class="col-sm-8">
                                <textarea id="observacionCalle" class="form-control" rows="5" ng-model="observacionCalle"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveCalle();" ng-disabled="formCalle.$invalid">
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
<script src="<?= asset('app/controllers/callesController.js') ?>"></script>


</html>