<!doctype html>
<html  lang="es-ES" ng-app="softver-aqua">
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

<div ng-controller="canallController">
    <div class="col-xs-12" style="margin-top: 15px;">
        <div class="col-sm-3 col-xs-12">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>

        <div class="col-sm-3">
            <select id="s_barrio" class="form-control" ng-model="s_barrio" ng-change="FiltrarPorBarrio()"
                    ng-options="value.id as value.label for value in barrioss"></select>
        </div>


        <div class="col-sm-3">
            <select id="s_calle" class="form-control" ng-model="s_calle" ng-change="FiltrarPorCalle()"
                    ng-options="value.id as value.label for value in calless"></select>
        </div>


        <div class="col-sm-3 col-xs-12">
            <button type="button" class="btn btn-primary" style="float: right;" ng-click="viewModalAdd()">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
        </div>
    </div>

    <div class="col-xs-12">
        <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
            <thead class="bg-primary">
            <tr>
                <th style="width: 15%;">Fecha de Ingreso</th>
                <th style="width: 15%;">Nombre del Canal</th>
                <th style="">Derivaciones</th>
                <th style="width: 15%;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="item in canals|filter:busqueda" ng-cloak>
                <td>{{item.fechaingreso}}</td>
                <td><input type="text" class="form-control" ng-model="item.nombrecanal"></td>

                <td>
                    <!--<span ng-repeat="derivacion in item.derivaciones">{{derivacion.nombrederivacion}}; </span>-->
                    <span ng-repeat="derivacion1 in item.derivacion">{{derivacion1.nombrederivacion}}; </span>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" ng-click="showModalInfo(item)">
                        <i class="fa fa-lg fa-info-circle" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDelete(item)">
                        <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                    </button>

                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="col-xs-12" style="float: right;">
        <button type="button" class="btn btn-success" style="float: right; " ng-click="editar()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalNueva">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="modal-title">Nuevo Canal</h4>
                    </div>
                    <div class="col-sm-7 col-xs-12 text-right">
                        <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso:  {{date_ingreso}}</h4></div>
                        <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    </div>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" name="formCanal" novalidate="">

                        <div class="form-group">
                            <label for="t_codigo" class="col-sm-4 control-label">Código: </label>
                            <div class="col-sm-8" style="padding-top: 7px;">
                                {{codigo}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="t_calle" class="col-sm-4 control-label">Toma:</label>
                            <div class="col-sm-8">
                                <select id="t_calle" class="form-control" ng-model="t_calle"
                                        ng-options="value.id as value.label for value in calles"></select>
                            </div>
                        </div>

                        <div class="form-group error">
                            <label for="nombrecanal" class="col-sm-4 control-label">Nombre del Canal:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nombrecanal" ng-model="nombrecanal" placeholder=""
                                       ng-required="true" ng-maxlength="64">
                                <span class="help-block error"
                                      ng-show="formCanal.nombrecanal.$invalid && formCanal.nombrecanal.$touched">El nombre del Canal es requerido</span>
                                <span class="help-block error"
                                      ng-show="formCanal.nombrecanal.$invalid && formCanal.nombrecanal.$error.maxlength">La longitud máxima es de 64 caracteres</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observacionCanal" class="col-sm-4 control-label">Observaciones:</label>
                            <div class="col-sm-8">
                                <textarea id="observacionCanal" class="form-control" rows="5" ng-model="observacionCanal"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveCanal();" ng-disabled="formCanal.$invalid">
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
                    <h4 class="modal-title">Canal: {{name_canal}}</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 text-center">
                        <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                    </div>
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <span style="font-weight: bold">Ingresada el: </span>{{fecha_ingreso}}
                        </div>

                        <div class="col-xs-12">
                            <span style="font-weight: bold">Derivaciones en el Canal: </span>{{canal_derivacion}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <span>Realmente desea eliminar el Canal: <strong>"{{nom_canal}}"</strong>?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-save" ng-click="delete()">
                        Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
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
                    <h4 class="modal-title">Información</h4>
                </div>
                <div class="modal-body">
                    <span>{{message_error}}</span>
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
<script src="<?= asset('app/controllers/canallController.js') ?>"></script>

</html>

