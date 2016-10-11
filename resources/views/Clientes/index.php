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

        <style>
            td{
                vertical-align: middle !important;
            }
        </style>

    </head>
    <body>

        <div ng-controller="clientesController">

            <div class="col-xs-12" style="margin-top: 15px;">
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="t_busqueda" placeholder="BUSCAR..." ng-model="t_busqueda">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-primary" style="float: right;" ng-click="showModalAddCliente()">
                        Nuevo <i class="fa fa-lg fa-user-plus" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                    <thead class="bg-primary">
                    <tr>
                        <th style="width: 10%;">CI / RUC</th>
                        <th style="width: 10%;">Fecha Ingreso</th>
                        <th style="">Razón Social</th>
                        <th style="width: 10%;">Celular</th>
                        <th style="width: 10%;">Telf. Domicilio</th>
                        <th style="width: 10%;">Telf. Trabajo</th>
                        <th style="width: 10%;">Dirección</th>
                        <th style="width: 6%;">Estado</th>
                        <th style="width: 10%;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in clientes | filter : t_busqueda" ng-cloak>
                            <td>{{item.documentoidentidad}}</td>
                            <td>{{item.fechaingreso | formatDate}}</td>
                            <td style="font-weight: bold;"><i class="fa fa-user" aria-hidden="true"></i> {{item.apellido + ' ' + item.nombre}}</td>
                            <td>{{item.celular}}</td>
                            <td>{{item.telefonoprincipaldomicilio}}</td>
                            <td>{{item.telefonoprincipaltrabajo}}</td>
                            <td>{{item.direcciondomicilio}}</td>
                            <td ng-if="item.estaactivo == true">
                                <span class="label label-primary" style="font-size: 14px !important;">Activo</span>
                            </td>
                            <td ng-if="item.estaactivo == false">
                                <span class="label label-warning" style="font-size: 14px !important;">Inactivo</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" ng-click="showModalInfoCliente(item)">
                                    <i class="fa fa-lg fa-info-circle" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" ng-click="edit(item)">
                                    <i class="fa fa-lg fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" ng-click="showModalDeleteCliente(item)">
                                    <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" ng-click="showModalAction(item)">
                                    <i class="fa fa-lg fa-cogs" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="modal fade" tabindex="-1" role="dialog" id="modalAddCliente">
                <div class="modal-dialog" role="document" style="width: 60%;">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">{{title_modal_cliente}}</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" name="formCliente" novalidate="">

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="col-sm-6 col-xs-12 form-group">
                                            <label for="t_fecha_ingreso" class="col-sm-4 col-xs-12 control-label">Fecha Ingreso:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control datepicker" name="t_fecha_ingreso" id="t_fecha_ingreso" ng-model="t_fecha_ingreso" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <fieldset>
                                            <legend style="font-size: 16px; font-weight: bold;">Datos de Cliente</legend>
                                            <input type="hidden" id="t_codigocliente" ng-model="t_codigocliente" value="0">
                                            <div class="col-xs-12" style="padding: 0;">
                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_doc_id" class="col-sm-4 col-xs-12 control-label">Documento ID:</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control" name="t_doc_id" id="t_doc_id"
                                                               ng-model="t_doc_id" ng-required="true" ng-pattern="/^([0-9a-zA-Z]+)$/">
                                                        <span class="help-block error"
                                                              ng-show="formCliente.t_doc_id.$invalid && formCliente.t_doc_id.$touched">El Identificación es requerida</span>
                                                        <span class="help-block error"
                                                              ng-show="formCliente.t_doc_id.$invalid && formCliente.t_doc_id.$error.pattern">La Identificación debe ser solo números y letras</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_doc_id" class="col-sm-4 col-xs-12 control-label">Email:</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control" name="t_email" id="t_email"
                                                               ng-model="t_email" ng-pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/">
                                                        <span class="help-block error"
                                                              ng-show="formCliente.t_email.$invalid && formCliente.t_email.$error.pattern">Formato de email no es correcto</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_apellidos" class="col-sm-4 col-xs-12 control-label">Apellidos:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_apellidos" id="t_apellidos"
                                                           ng-model="t_apellidos" ng-required="true">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_apellidos.$invalid && formCliente.t_apellidos.$touched">El Apellido es requerido</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_nombres" class="col-sm-4 col-xs-12 control-label">Nombre(s):</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_nombres" id="t_nombres"
                                                           ng-model="t_nombres" ng-required="true">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_nombres.$invalid && formCliente.t_nombres.$touched">El Nombre(s) es requerido</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_telf_principal" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Principal:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_telf_principal" id="t_telf_principal"
                                                           ng-model="t_telf_principal" ng-pattern="/^([0-9-\(\)]+)$/">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_telf_principal.$invalid && formCliente.t_telf_principal.$error.pattern">Solo números, guion y parentesis</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_telf_secundario" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Secundario:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_telf_secundario" id="t_telf_secundario"
                                                           ng-model="t_telf_secundario" ng-pattern="/^([0-9-\(\)]+)$/">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_telf_secundario.$invalid && formCliente.t_telf_secundario.$error.pattern">Solo números, guion y parentesis</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_celular" class="col-sm-4 col-xs-12 control-label">Celular:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_celular" id="t_celular"
                                                           ng-model="t_celular" ng-pattern="/^([0-9-\(\)]+)$/">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_celular.$invalid && formCliente.t_celular.$error.pattern">Solo números, guion y parentesis</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_direccion" class="col-sm-4 col-xs-12 control-label">Dirección:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_direccion" id="t_direccion" ng-model="t_direccion">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-xs-12">
                                        <fieldset>
                                            <legend style="font-size: 16px; font-weight: bold;">Datos del Trabajo</legend>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_telf_principal_emp" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Principal:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_telf_principal_emp" id="t_telf_principal_emp"
                                                           ng-model="t_telf_principal_emp" ng-pattern="/^([0-9-\(\)]+)$/">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_telf_principal_emp.$invalid && formCliente.t_telf_principal_emp.$error.pattern">Solo números, guion y parentesis</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_telf_secundario_emp" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Teléf. Secundario:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_telf_secundario_emp" id="t_telf_secundario_emp"
                                                           ng-model="t_telf_secundario_emp" ng-pattern="/^([0-9-\(\)]+)$/">
                                                    <span class="help-block error"
                                                          ng-show="formCliente.t_telf_secundario_emp.$invalid && formCliente.t_telf_secundario_emp.$error.pattern">Solo números, guion y parentesis</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_direccion_emp" class="col-sm-4 col-xs-12 control-label">Dirección:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <input type="text" class="form-control" name="t_direccion_emp" id="t_direccion_emp" ng-model="t_direccion_emp">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-success" id="btn-save" ng-click="saveCliente()" ng-disabled="formCliente.$invalid">
                                Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteCliente">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Confirmación</h4>
                        </div>
                        <div class="modal-body">
                            <span>Realmente desea eliminar el cliente: <strong>"{{nom_cliente}}"</strong> seleccionado...</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-danger" id="btn-save" ng-click="deleteCliente()">
                                Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoCliente">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Información Cliente</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 text-center">
                                <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                            </div>
                            <div class="row text-center">
                                <div class="col-xs-12 text-center" style="font-size: 18px;">{{name_cliente}}</div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">CI/RUC: </span>{{identify_cliente}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Fecha Solicitud: </span>{{fecha_solicitud}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Dirección Domicilio: </span>{{address_cliente}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Email: </span>{{email_cliente}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Celular: </span>{{celular_cliente}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Teléfonos Domicilio: </span>{{telf_cliente}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Teléfonos Trabajo: </span>{{telf_cliente_emp}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Estado: </span>{{estado_solicitud}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalAction">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-info">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">¿Tipo de Solicitud?</h4>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-info btn-block" ng-click="actionRiego()">
                                Riego
                            </button>
                            <button type="button" class="btn btn-warning btn-block" ng-click="">
                                Cambio de Nombre
                            </button>
                            <button type="button" class="btn btn-danger btn-block" ng-click="">
                                Fraccionamiento
                            </button>
                            <button type="button" class="btn btn-primary btn-block" ng-click="">
                                Otro tipo de Solicitud
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalActionRiego">
                <div class="modal-dialog" role="document" style="width: 60%;">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">

                            <div class="col-md-6 col-xs-12">
                                <h4 class="modal-title">Procesar Solicitud de Riego Nro: {{num_solicitud}}</h4>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Procesada:</label></h4>
                                    <div class="col-sm-5" style="padding: 0;">
                                        <input type="text" class="form-control input-sm datepicker" name="t_fecha_process"
                                               id="t_fecha_process" ng-model="t_fecha_process" style="color: black !important;">
                                    </div>
                                    <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" name="formProcess" novalidate="">

                                <div class="row">
                                    <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                        <fieldset ng-cloak>
                                            <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                            <div class="col-xs-12" style="padding: 0;">
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">RUC/CI:</span> {{documentoidentidad_cliente}}
                                                </div>
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">Cliente:</span> {{nom_cliente}}
                                                    <input type="hidden" ng-model="h_codigocliente">
                                                </div>
                                            </div>
                                            <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">Dirección Domicilio:</span> {{direcc_cliente}}
                                                </div>
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">Teléfono Domicilio:</span> {{telf_cliente}}
                                                </div>
                                            </div>
                                            <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">Celular:</span> {{celular_cliente}}
                                                </div>
                                                <div class="col-sm-6 col-xs-12">
                                                    <span class="label label-default" style="font-size: 12px !important;">Teléfono Trabajo:</span> {{telf_trab_cliente}}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                        <fieldset>
                                            <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                            <div class="col-xs-12" style="padding: 0; margin-top: -15px;">
                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_terreno" class="col-sm-4 col-xs-12 control-label">Nro. Terreno:</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        {{nro_terreno}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12" style="padding: 0;">
                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_tarifa" class="col-sm-4 col-xs-12 control-label">Tipo Cultivo:</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        <select class="form-control" name="t_tarifa" id="t_tarifa"
                                                                ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                                                ng-change="getCultivos()"></select><!--ng-change="showAddCultivo()"-->
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_cultivo" class="col-sm-4 col-xs-12 control-label">Cultivo:</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        <select class="form-control" name="t_cultivo" id="t_cultivo"
                                                                ng-model="t_cultivo" ng-options="value.id as value.label for value in cultivos">
                                                        </select><!--ng-change="showAddCultivo()"-->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12" style="padding: 0;">
                                                <div class="col-sm-6 col-xs-12 form-group error">
                                                    <label for="t_area" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Area (m2):</label>
                                                    <div class="col-sm-8 col-xs-12">
                                                        <input type="text" class="form-control" name="t_area" id="t_area"
                                                               ng-model="t_area" ng-required="true" ng-pattern="/^([0-9]+)$/" ng-blur="calculate()">
                                                        <span class="help-block error"
                                                              ng-show="formProcess.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                                        <span class="help-block error"
                                                              ng-show="formProcess.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xs-12 form-group error" style="margin-top: 5px;">
                                                    <div class="col-sm-6 col-xs-12" ng-cloak>
                                                        <span class="label label-info" style="font-size: 12px !important;">Caudal:</span>
                                                        <span style="font-size: 14px !important; font-weight: bold;">{{calculate_caudal}}</span>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-12" ng-cloak>
                                                        <span class="label label-info" style="font-size: 12px !important;">Valor Anual:</span>
                                                        <span style="font-size: 14px !important; font-weight: bold;">{{valor_total}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>

                                    <div class="col-xs-12" style="padding: 2%; margin-top: -35px !important;">
                                        <fieldset>
                                            <legend style="font-size: 16px; font-weight: bold;">Datos de Ubicación</legend>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_junta" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Junta Modular:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_junta" id="t_junta"
                                                            ng-model="t_junta" ng-options="value.id as value.label for value in barrios"
                                                            ng-change="getTomas()" ></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_toma" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Toma:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_toma" id="t_toma"
                                                            ng-model="t_toma" ng-options="value.id as value.label for value in tomas"
                                                            ng-change="getCanales()"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_canal" class="col-sm-4 col-xs-12 control-label">Canal:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_canal" id="t_canal"
                                                            ng-model="t_canal" ng-options="value.id as value.label for value in canales"
                                                            ng-change="getDerivaciones()"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-12 form-group error">
                                                <label for="t_derivacion" class="col-sm-4 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Derivación:</label>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select class="form-control" name="t_derivacion" id="t_derivacion"
                                                            ng-model="t_derivacion" ng-options="value.id as value.label for value in derivaciones"></select>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>


                                    <div class="col-xs-12 form-group" style="margin-top: -15px;">
                                        <label for="t_derivacion" class="col-sm-2 col-xs-12 control-label" style="padding: 5px 0 5px 0;">Observación:</label>
                                        <div class="col-sm-10 col-xs-12">
                                            <textarea class="form-control" id="t_observacion_riego" ng-model="t_observacion_riego" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>



                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-success" ng-click="saveSolicitudRiego()" ng-disabled="formProcess.$invalid">
                                Guardar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-primary" ng-click="processSolicitud()" ng-disabled="formProcess.$invalid">
                                Procesar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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
    <script src="<?= asset('app/controllers/clientesController.js') ?>"></script>

</html>