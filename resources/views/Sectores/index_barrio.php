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

        <div class="col-xs-12" style="margin-top: 15px;">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="viewModalAdd()">Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
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
                    <tr ng-repeat="item in barrios|filter:busqueda" ng-cloak>
                        <td>{{item.fechaingreso}}</td>

                        <td><input type="text" class="form-control" ng-model="item.nombrebarrio"></td>

                        <td>
                            <span ng-repeat="calle in item.calle">{{calle.nombrecalle}}; </span>
                            <button type="button" class="btn btn-primary btn-sm" ng-click="show_toma(item.idbarrio,2, item)">
                                <i class="fa fa-lg fa-plus" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" ng-click="showModalInfo(item)">
                                <i class="fa fa-lg fa-info-circle" aria-hidden="true"></i>
                            </button>
                            <!--<button type="button" class="btn btn-warning btn-sm" ng-click="edit(item)">
                                <i class="fa fa-lg fa-pencil-square-o" aria-hidden="true"></i>
                            </button>-->
                            <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDelete(item)">
                                <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" ng-click="showModalAction(item)">
                                <i class="fa fa-lg fa-eye" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-xs-12" style="float: right;">
            <button type="button" class="btn btn-success" style="float: right;" ng-click="editar()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></button>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalNueva">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-5 col-xs-12">
                            <h4 class="modal-title">Nueva Junta Modular</h4>
                        </div>
                        <div class="col-sm-7 col-xs-12 text-right">
                            <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso: {{date_ingreso}}</h4></div>
                            <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formBarrio" novalidate="">
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Código: </label>
                                <div class="col-sm-8" style="padding-top: 7px;">
                                    {{codigo}}
                                </div>
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
                                    <textarea id="observacionBarrio" class="form-control" rows="3" ng-model="observacionBarrio"></textarea>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalNuevaToma" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-5 col-xs-12">
                            <h4 class="modal-title">Nueva Toma</h4>
                        </div>
                        <div class="col-sm-7 col-xs-12 text-right">
                            <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso: {{date_ingreso_toma}}</h4></div>
                            <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" name="formCalle" novalidate="">
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Código: </label>
                                <div class="col-sm-8" style="padding-top: 7px;">
                                    {{codigo_toma}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_barrio" class="col-sm-4 control-label">Barrio:</label>
                                <div class="col-sm-8">
                                    <select disabled id="id_barrio" class="form-control" ng-model="id_barrio"
                                            ng-options="value.id as value.label for value in barrios2"></select>
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
                                    <textarea id="observacionCalle" class="form-control" rows="3" ng-model="observacionCalle"></textarea>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalInfo">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Junta Modular: {{name_junta}}</h4>
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
                                <span style="font-weight: bold">Tomas en la Junta: </span>{{junta_tomas}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Canales en la Junta: </span>{{junta_canales}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Derivaciones de la Junta: </span>{{junta_derivacion}}
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
                        <span>Realmente desea eliminar la Junta Modular: <strong>"{{nom_junta_modular}}"</strong>...</span>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalMessage" style="z-index: 99999;">
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalMessageError" style="z-index: 99999;">
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalTomas">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-12 col-xs-12">
                            <h4 class="modal-title">Tomas de la Junta Modular: {{junta_n}} </h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formBarrio" novalidate="">
                                <div class="col-xs-12"  style="margin-top: 15px;">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busquedaa">
                                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <button type="button" class="btn btn-primary" style="float: right;" ng-click="show_toma(barrio_actual,1)">Nuevo  <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                        <thead class="bg-primary">
                                        <tr>
                                            <th style="width: 15%;">Nombre de la Toma</th>
                                            <th style="">Canales</th>
                                            <th style="width: 15%;">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in aux_calles|filter:busquedaa" ng-cloak>
                                            <td><input type="text" class="form-control" ng-model="item.nombrecalle"></td>

                                            <td>
                                                <span ng-repeat="canal in item.canales">{{canal.nombrecanal}}; </span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDeleteCalle(item)">
                                                    <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" ng-click="showModalActionCanal(item)">
                                                    <i class="fa fa-lg fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                        </form>

                    <div class="modal-footer">

                            <button type="button" class="btn btn-success" style="float: right; " ng-click="editarCalles()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>

                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteCalle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Realmente desea eliminar la Toma: <strong>"{{nom_calle_delete}}"</strong>?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="deleteCalleEnBarrio()">
                            Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalCanales">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-12 col-xs-12">
                            <h4 class="modal-title">Canales de la Toma: {{toma_n}} </h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formBarrio" novalidate="">
                            <div class="col-xs-12"  style="margin-top: 15px;">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busquedaaa">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <button type="button" class="btn btn-primary" style="float: right;" ng-click="show_canal()">Nuevo  <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 15%;">Nombre del Canal</th>
                                        <th style="">Derivaciones</th>
                                        <th style="width: 15%;">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in aux_canales|filter:busquedaaa" ng-cloak>
                                        <td><input type="text" class="form-control" ng-model="item.nombrecanal"></td>

                                        <td>
                                            <span ng-repeat="derivaciones in item.derivacion">{{derivaciones.nombrederivacion}}; </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDeleteCanal(item)">
                                                <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" ng-click="showModalActionDerivaciones(item)">
                                                <i class="fa fa-lg fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </form>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-success" style="float: right; " ng-click="editarCanal()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalDerivaciones">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-12 col-xs-12">
                            <h4 class="modal-title">Derivaciones del Canal: {{canal_n}} </h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formBarrio" novalidate="">
                            <div class="col-xs-12"  style="margin-top: 15px;">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busquedaaaa">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <button type="button" class="btn btn-primary" style="float: right;" ng-click="show_derivacion()">Nuevo  <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 15%;">Nombre de la Derivacion</th>
                                        <th style="width: 15%;">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in aux_derivaciones|filter:busquedaaaa" ng-cloak>
                                        <td><input type="text" class="form-control" ng-model="item.nombrederivacion"></td>

                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDeleteDerivaciones(item)">
                                                <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </form>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-success" style="float: right; " ng-click="editarCalles()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalNuevoCanal" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-5 col-xs-12">
                            <h4 class="modal-title">Nuevo Canal</h4>
                        </div>
                        <div class="col-sm-7 col-xs-12 text-right">
                            <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso: {{date_ingreso_canal}}</h4></div>
                            <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" name="formCanal" novalidate="">
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Código: </label>
                                <div class="col-sm-8" style="padding-top: 7px;">
                                    {{codigo_canal}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_toma" class="col-sm-4 control-label">Toma:</label>
                                <div class="col-sm-8">
                                    <select disabled id="id_toma" class="form-control" ng-model="id_toma"
                                            ng-options="value.id as value.label for value in calles2"></select>
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
                                    <textarea id="observacionCanal" class="form-control" rows="3" ng-model="observacionCanal"></textarea>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteCanal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Realmente desea eliminar el canal: <strong>"{{nom_canal_delete}}"</strong>?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="deleteCanal()">
                            Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalNuevaDerivacion" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <div class="col-sm-5 col-xs-12">
                            <h4 class="modal-title">Nueva Derivacion</h4>
                        </div>
                        <div class="col-sm-7 col-xs-12 text-right">
                            <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso: {{date_ingreso_deri}}</h4></div>
                            <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" name="formDeri" novalidate="">
                            <div class="form-group">
                                <label for="t_codigo" class="col-sm-4 control-label">Código: </label>
                                <div class="col-sm-8" style="padding-top: 7px;">
                                    {{codigo_deri}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="id_canal" class="col-sm-4 control-label">Canal:</label>
                                <div class="col-sm-8">
                                    <select disabled id="id_canal" class="form-control" ng-model="id_canal"
                                            ng-options="value.id as value.label for value in canal2"></select>
                                </div>
                            </div>

                            <div class="form-group error">
                                <label for="nombrederi" class="col-sm-4 control-label">Nombre Derivacion:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nombrederi" ng-model="nombrederi" placeholder=""
                                           ng-required="true" ng-maxlength="64">
                                    <span class="help-block error"
                                          ng-show="formDeri.nombrederi.$invalid && formDeri.nombrederi.$touched">El nombre de la Derivacion es requerido</span>
                                    <span class="help-block error"
                                          ng-show="formDeri.nombrederi.$invalid && formDeri.nombrederi.$error.maxlength">La longitud máxima es de 64 caracteres</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observacionDeri" class="col-sm-4 control-label">Observaciones:</label>
                                <div class="col-sm-8">
                                    <textarea id="observacionDeri" class="form-control" rows="3" ng-model="observacionDeri"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveDeri();" ng-disabled="formDeri.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
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
<script src="<?= asset('app/controllers/barrioController.js') ?>"></script>

</html>