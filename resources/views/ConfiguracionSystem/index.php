<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configuracion</title>

    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/angucomplete-alt.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

</head>

<body>

<div ng-controller="configuracionSystemController">
    <div class="container">
        <div id="dvTab" style="margin-top: 5px;">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active tabs"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"> Empresa</a></li>
                <li role="presentation" class="tabs"><a href="#contabilidad" aria-controls="contabilidad" role="tab" data-toggle="tab"> Contabilidad</a></li>
                <li role="presentation" class="tabs"><a href="#sri" aria-controls="sri" role="tab" data-toggle="tab"> SRI</a></li>
                <li role="presentation" class="tabs"><a href="#especifica" aria-controls="especifica" role="tab" data-toggle="tab"> Específicas</a></li>
            </ul>
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade active in" id="empresa" style="padding-top: 10px;">
                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Razón Social: </span>
                            <input type="text" class="form-control" name="t_razonsocial" id="t_razonsocial" ng-model="t_razonsocial" />
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Nombre Comercial: </span>
                            <input type="text" class="form-control" name="t_nombrecomercial" id="t_nombrecomercial" ng-model="t_nombrecomercial" />
                        </div>
                    </div>

                    <div class="col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Dirección: </span>
                            <input type="text" class="form-control" name="t_direccion" id="t_direccion" ng-model="t_direccion" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">RUC: </span>
                                    <span class="input-group-btn" style="width: 15%;">
					                    <input type="text" class="form-control" id="t_establ" name="t_establ" ng-model="t_establ" ng-keypress="onlyNumber($event, 3, 't_establ')" ng-blur="calculateLength('t_establ', 3)" />
					                </span>
                                    <span class="input-group-btn" style="width: 15%;" >
					                    <input type="text" class="form-control" id="t_pto" name="t_pto" ng-model="t_pto" ng-keypress="onlyNumber($event, 3, 't_pto')" ng-blur="calculateLength('t_pto', 3)" />
					                </span>
                                    <input type="text" class="form-control" id="t_secuencial" name="t_secuencial" ng-model="t_secuencial" ng-keypress="onlyNumber($event, 9, 't_secuencial')" ng-blur="calculateLength('t_secuencial', 9)" />
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Contribuyente Especial: </span>
                                    <input type="text" class="form-control" name="t_contribuyente" id="t_contribuyente" ng-model="t_contribuyente" />
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Obligado Contabilidad: </span>
                                    <select class="form-control" name="s_obligado" id="s_obligado" ng-model="s_obligado"
                                            ng-options="value.id as value.label for value in obligadocont"></select>
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Logo Empresa: </span>
                                    <input type="file" class="form-control"  name="f_logoempresa" id="f_logoempresa" ng-model="f_logoempresa" />
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            FOTO
                        </div>
                    </div>

                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveEstablecimiento()">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>

                    </div>

                </div>

                <div role="tabpanel" class="tab-pane fade" id="contabilidad">

                    <div id="dvTab2" style="margin-top: 5px;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active tabs"><a href="#cont_general" aria-controls="cont_general" role="tab" data-toggle="tab"><i class="fa fa-info-circle" style="font-size: 20px !important;"></i> General</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_compras" aria-controls="cont_compras" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Factura Compra</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_venta" aria-controls="cont_venta" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Factura Ventas</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_notacredit" aria-controls="cont_notacredit" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Notas de Crédito</a></li>
                        </ul>
                        <!-- Tab panels -->
                        <div class="tab-content" style="padding-top: 10px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="cont_general">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Impuesto IVA (defecto): </span>
                                        <select class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_compras">

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_venta">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_notacredit">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" readonly>
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>



                <div role="tabpanel" class="tab-pane fade" id="sri" style="padding-top: 10px;">
                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Tipo Ambiente: </span>
                            <select class="form-control">
                                <option value="1">PRUEBAS</option>
                                <option value="2">PRODUCCION</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Tipo Emisión: </span>
                            <select class="form-control">
                                <option value="1">NORMAL</option>
                                <option value="2">CONTINGENCIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" >
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>

                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="especifica" style="padding-top: 10px;">

                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Constante: </span>
                            <input type="text" class="form-control" placeholder="Para sistema Pisque" />
                        </div>
                    </div>

                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Dividendos: </span>
                            <input type="text" class="form-control" placeholder="Para sistema AYORA" />
                        </div>
                    </div>

                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                        <div class="input-group">
                            <span class="input-group-addon">Tasa Interés: </span>
                            <input type="text" class="form-control" placeholder="Para sistema AYORA" />
                        </div>
                    </div>

                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" >
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>



</body>


<script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>


<script src="<?= asset('app/lib/angular/ng-file-upload-shim.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/ng-file-upload.min.js') ?>"></script>


<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('js/moment.min.js') ?>"></script>
<script src="<?= asset('js/es.js') ?>"></script>
<script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angucomplete-alt.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/dirPagination.js') ?>"></script>

<script src="<?= asset('app/app.js') ?>"></script>
<script src="<?= asset('app/controllers/configuracionSystemController.js') ?>"></script>


</html>












