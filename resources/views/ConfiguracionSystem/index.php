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
                            <li role="presentation" class="active tabs"><a href="#cont_general" aria-controls="cont_general" role="tab" data-toggle="tab"></i> General</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_compras" aria-controls="cont_compras" role="tab" data-toggle="tab"></i> Factura Compra</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_venta" aria-controls="cont_venta" role="tab" data-toggle="tab"></i> Factura Ventas</a></li>
                            <li role="presentation" class="tabs"><a href="#cont_notacredit" aria-controls="cont_notacredit" role="tab" data-toggle="tab"></i> Notas de Crédito</a></li>
                        </ul>
                        <!-- Tab panels -->
                        <div class="tab-content" style="padding-top: 10px;">
                            <div role="tabpanel" class="tab-pane fade active in" id="cont_general">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Impuesto IVA (defecto): </span>
                                        <select class="form-control" name="iva" id="iva" ng-model="iva"
                                                ng-options="value.id as value.label for value in imp_iva"></select>
                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="updateIvaDefault()">
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_compras">

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" name="irbpnr_compra" id="irbpnr_compra" ng-model="irbpnr_compra" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="irbpnr_compra_h" id="irbpnr_compra_h" ng-model="irbpnr_compra_h">
                                        <input type="hidden" name="id_irbpnr_compra_h" id="id_irbpnr_compra_h" ng-model="id_irbpnr_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-irbpnr-compra" ng-click="showPlanCuenta('irbpnr_compra', 'irbpnr_compra_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" name="propina_compra" id="propina_compra" ng-model="propina_compra" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="propina_compra_h" id="propina_compra_h" ng-model="propina_compra_h">
                                        <input type="hidden" name="id_propina_compra_h" id="id_propina_compra_h" ng-model="id_propina_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-propina-compra" ng-click="showPlanCuenta('propina_compra', 'propina_compra_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" name="retiva_compra" id="retiva_compra" ng-model="retiva_compra" readonly>
                                        <input type="hidden" name="retiva_compra_h" id="retiva_compra_h" ng-model="retiva_compra_h">
                                        <input type="hidden" name="id_retiva_compra_h" id="id_retiva_compra_h" ng-model="id_retiva_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retiva-compra" ng-click="showPlanCuenta('retiva_compra', 'retiva_compra_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" name="retrenta_compra" id="retrenta_compra" ng-model="retrenta_compra" readonly>
                                        <input type="hidden" name="retrenta_compra_h" id="retrenta_compra_h" ng-model="retrenta_compra_h">
                                        <input type="hidden" name="id_retrenta_compra_h" id="id_retrenta_compra_h" ng-model="id_retrenta_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retrenta-compra" ng-click="showPlanCuenta('retrenta_compra', 'retrenta_compra_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigCompra()">
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_venta">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" name="irbpnr_venta" id="irbpnr_venta" ng-model="irbpnr_venta" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="irbpnr_venta_h" id="irbpnr_venta_h" ng-model="irbpnr_venta_h">
                                        <input type="hidden" name="id_irbpnr_venta_h" id="id_irbpnr_venta_h" ng-model="id_venta_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-irbpnr_venta" ng-click="showPlanCuenta('irbpnr_venta', 'irbpnr_venta_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" name="propina_venta" id="propina_venta" ng-model="propina_venta" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="propina_venta_h" id="propina_venta_h" ng-model="propina_venta_h">
                                        <input type="hidden" name="id_propina_venta_h" id="id_propina_venta_h" ng-model="id_propina_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-propina-venta" ng-click="showPlanCuenta('propina_venta', 'propina_venta_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" name="retiva_venta" id="retiva_venta" ng-model="retiva_venta" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="retiva_venta_h" id="retiva_venta_h" ng-model="retiva_venta_h">
                                        <input type="hidden" name="id_retiva_venta_h" id="id_retiva_venta_h" ng-model="id_retiva_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retiva-venta" ng-click="showPlanCuenta('retiva_venta', 'retiva_venta_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" name="retrenta_venta" id="retrenta_venta" ng-model="retrenta_venta" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="retrenta_venta_h" id="retrenta_venta_h" ng-model="retrenta_venta_h">
                                        <input type="hidden" name="id_retrenta_venta_h" id="id_retrenta_venta_h" ng-model="id_retrenta_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retrenta-venta" ng-click="showPlanCuenta('retrenta_venta', 'retrenta_venta_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Costo de Venta: </span>
                                        <input type="text" class="form-control" name="costo_venta" id="costo_venta" ng-model="costo_venta" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="costo_venta_h" id="costo_venta_h" ng-model="costo_venta_h">
                                        <input type="hidden" name="id_costo_venta_h" id="id_costo_venta_h" ng-model="id_costo_compra_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-costo-venta" ng-click="showPlanCuenta('costo_venta', 'costo_venta_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigVenta()" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_notacredit">
                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta IRBPNR: </span>
                                        <input type="text" class="form-control" name="irbpnr_nc" id="irbpnr_nc" ng-model="irbpnr_nc" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="irbpnr_nc_h" id="irbpnr_nc_h" ng-model="irbpnr_nc_h">
                                        <input type="hidden" name="id_irbpnr_nc_h" id="id_irbpnr_nc_h" ng-model="id_venta_nc_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-irbpnr-nc" ng-click="showPlanCuenta('irbpnr_nc', 'irbpnr_nc_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Propina: </span>
                                        <input type="text" class="form-control" name="propina_nc" id="propina_nc" ng-model="propina_nc" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="propina_nc_h" id="propina_nc_h" ng-model="propina_nc_h">
                                        <input type="hidden" name="id_propina_nc_h" id="id_propina_nc_h" ng-model="id_propina_nc_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-propina-nc" ng-click="showPlanCuenta('propina_nc', 'propina_nc_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención IVA: </span>
                                        <input type="text" class="form-control" name="retiva_nc" id="retiva_nc" ng-model="retiva_nc" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="retiva_nc_h" id="retiva_nc_h" ng-model="retiva_nc_h">
                                        <input type="hidden" name="id_retiva_nc_h" id="id_retiva_nc_h" ng-model="id_retiva_nc_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retiva_nc" ng-click="showPlanCuenta('retiva_nc', 'retiva_nc_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cuenta Retención Renta: </span>
                                        <input type="text" class="form-control" name="retrenta_nc" id="retrenta_nc" ng-model="retrenta_nc" placeholder=""
                                               ng-required="true" readonly>
                                        <input type="hidden" name="retrenta_nc_h" id="retrenta_nc_h" ng-model="retrenta_nc_h">
                                        <input type="hidden" name="id_retrenta_nc_h" id="id_retrenta_nc_h" ng-model="id_retrenta_nc_h">
                                        <span class="input-group-btn" role="group">
                                            <button type="button" class="btn btn-info" id="btn-retrenta-nc" ng-click="showPlanCuenta('retrenta_nc', 'retrenta_nc_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                            </button>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigNC()" >
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalPlanCuenta">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Plan de Cuenta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                <thead class="bg-primary">
                                <tr>
                                    <th style="width: 15%;">ORDEN</th>
                                    <th>CONCEPTO</th>
                                    <th style="width: 10%;">COD. SRI</th>
                                    <th style="width: 4%;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="item in cuentas" ng-cloak >
                                    <td>{{item.jerarquia}}</td>
                                    <td>{{item.concepto}}</td>
                                    <td>{{item.codigosri}}</td>
                                    <td>
                                        <input type="radio" name="select_cuenta"  ng-click="click_radio(item)">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-ok" ng-click="selectCuenta()">
                        Aceptar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <span>{{message_error}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalMessageInfo" style="z-index: 999999;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Información</h4>
                </div>
                <div class="modal-body">
                    <span>{{message_info}}</span>
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












