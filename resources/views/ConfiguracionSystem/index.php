
<div class="container" ng-controller="configuracionSystemController" ng-init="getCuentas()">

    <div class="col-xs-12">

        <div class="col-xs-12">

            <h4>Configuración del Sistema</h4>

            <hr>

        </div>

        <div id="dvTab" style="margin-top: 5px;">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active tabs"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"> Empresa</a></li>
                <li role="presentation" class="tabs"><a href="#contabilidad" aria-controls="contabilidad" role="tab" data-toggle="tab"> Contabilidad</a></li>
                <li role="presentation" class="tabs"><a href="#sri" aria-controls="sri" role="tab" data-toggle="tab"> SRI</a></li>
                <li role="presentation" class="tabs"><a href="#especifica" aria-controls="especifica" role="tab" data-toggle="tab"> Específicas</a></li>
            </ul>
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade active in" id="empresa" style="padding-top: 10px;">

                    <form class="form-horizontal" name="formEstablecim" novalidate="">

                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Razón Social: </span>
                                <input type="text" class="form-control" name="t_razonsocial" id="t_razonsocial" ng-model="t_razonsocial" required/>
                            </div>
                            <span class="help-block error"
                                  ng-show="formEstablecim.t_razonsocial.$invalid && formEstablecim.t_razonsocial.$touched">La Razón Social es requerida</span>
                        </div>

                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Nombre Comercial: </span>
                                <input type="text" class="form-control" name="t_nombrecomercial" id="t_nombrecomercial" ng-model="t_nombrecomercial" required/>
                            </div>
                            <span class="help-block error"
                                  ng-show="formEstablecim.t_nombrecomercial.$invalid && formEstablecim.t_nombrecomercial.$touched">El Nombre Comercial es requerido</span>
                        </div>

                        <div class="col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Dirección: </span>
                                <input type="text" class="form-control" name="t_direccion" id="t_direccion" ng-model="t_direccion" required />
                            </div>
                            <span class="help-block error"
                                  ng-show="formEstablecim.t_direccion.$invalid && formEstablecim.t_direccion.$touched">La Dirección es requerida</span>
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
                                        <input type="text" class="form-control" id="t_secuencial" name="t_secuencial" ng-model="t_secuencial" ng-keypress="onlyNumber($event, 13, 't_secuencial')" ng-blur="calculateLength('t_secuencial', 13)" />
                                    </div>
                                </div>
                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="input-group">
                                        <span class="input-group-addon">No. Contribuyente Especial (si presenta): </span>
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
                                        <input type="file" class="form-control" ngf-select name="file" id="file" ng-model="file" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 text-center" style="margin-top: 5px;" ng-cloak>
                                <img class="img-thumbnail" ngf-src="file" ng-src="{{url_foto}}" alt="" style="width: 50%;">
                            </div>
                        </div>
                    </form>

                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default" ng-click="getDataEmpresa()">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveEstablecimiento()" ng-disabled="formEstablecim.$invalid">
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
                            <li role="presentation" class="tabs"><a href="#cont_nomina" aria-controls="cont_nomina" role="tab" data-toggle="tab"></i> Nómina</a></li>
                        </ul>
                        <!-- Tab panels -->
                        <div class="tab-content" style="padding-top: 10px;">

                            <div role="tabpanel" class="tab-pane fade active in" id="cont_general">

                                <form class="form-horizontal" name="formContGeneral" novalidate="">

                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <div class="input-group">
                                                <span class="input-group-addon">Impuesto IVA (defecto): </span>
                                                <select class="form-control" name="iva" id="iva" ng-model="iva"
                                                        ng-options="value.id as value.label for value in imp_iva" required></select>
                                            </div>
                                            <span class="help-block error"
                                                  ng-show="formContGeneral.iva.$invalid && formContGeneral.iva.$touched">El IVA es requerido</span>
                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <div class="input-group">
                                                <span class="input-group-addon">Cuenta Cliente (defecto): </span>
                                                <input type="text" class="form-control" name="cont_cliente_default" id="cont_cliente_default" ng-model="cont_cliente_default" placeholder=""
                                                       readonly>
                                                <input type="hidden" name="cont_cliente_default_h" id="cont_cliente_default_h" ng-model="cont_cliente_default_h">
                                                <input type="hidden" name="id_cont_cliente_default_h" id="id_cont_cliente_default_h" ng-model="id_cont_cliente_default_h">
                                                <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-cont-cli" ng-click="showPlanCuenta('cont_cliente_default', 'cont_cliente_default_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-cont-cli" ng-click = "clean('cont_cliente_default', 'cont_cliente_default_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <div class="input-group">
                                                <span class="input-group-addon">Cuenta Proveedor (defecto): </span>
                                                <input type="text" class="form-control" name="cont_prov_default" id="cont_prov_default" ng-model="cont_prov_default" placeholder=""
                                                       readonly>
                                                <input type="hidden" name="cont_prov_default_h" id="cont_prov_default_h" ng-model="cont_prov_default_h">
                                                <input type="hidden" name="id_cont_prov_default_h" id="id_cont_prov_default_h" ng-model="id_cont_prov_default_h">
                                                <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-cont-prov" ng-click="showPlanCuenta('cont_prov_default', 'cont_prov_default_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-cont-prov" ng-click = "clean('cont_prov_default', 'cont_prov_default_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <div class="input-group">
                                                <span class="input-group-addon">Cuenta C. Cuenta x Cobrar (defecto): </span>
                                                <input type="text" class="form-control" name="cont_cxc_default" id="cont_cxc_default" ng-model="cont_cxc_default" placeholder=""
                                                       readonly>
                                                <input type="hidden" name="cont_cxc_default_h" id="cont_cxc_default_h" ng-model="cont_cxc_default_h">
                                                <input type="hidden" name="id_cont_cxc_default_h" id="id_cont_cxc_default_h" ng-model="id_cont_cxc_default_h">
                                                <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-cxc-cli" ng-click="showPlanCuenta('cont_cxc_default', 'cont_cxc_default_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-cxc-cli" ng-click = "clean('cont_cxc_default', 'cont_cxc_default_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                            <div class="input-group">
                                                <span class="input-group-addon">Cuenta C. Cuenta x Pagar (defecto): </span>
                                                <input type="text" class="form-control" name="cont_cxp_default" id="cont_cxp_default" ng-model="cont_cxp_default" placeholder=""
                                                       readonly>
                                                <input type="hidden" name="cont_cxp_default_h" id="cont_cxp_default_h" ng-model="cont_cxp_default_h">
                                                <input type="hidden" name="id_cont_cxp_default_h" id="id_cont_cxp_default_h" ng-model="id_cont_cxp_default_h">
                                                <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-cxp-prov" ng-click="showPlanCuenta('cont_cxp_default', 'cont_cxp_default_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-cxp-prov" ng-click = "clean('cont_cxp_default', 'cont_cxp_default_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default" ng-click="getImpuestoIVA()">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="updateIvaDefault()" ng-disabled="formContGeneral.$invalid">
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_compras">

                                <form class="form-horizontal" name="formCompras" novalidate="">

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IVA: </span>
                                            <input type="text" class="form-control" name="iva_compra" id="iva_compra" ng-model="iva_compra" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="iva_compra_h" id="iva_compra_h" ng-model="iva_compra_h">
                                            <input type="hidden" name="id_iva_compra_h" id="id_iva_compra_h" ng-model="id_iva_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-iva-compra" ng-click="showPlanCuenta('iva_compra', 'iva_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-iva-compra" ng-click = "clean('iva_compra', 'iva_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta ICE: </span>
                                            <input type="text" class="form-control" name="ice_compra" id="ice_compra" ng-model="ice_compra" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="ice_compra_h" id="ice_compra_h" ng-model="ice_compra_h">
                                            <input type="hidden" name="id_ice_compra_h" id="id_ice_compra_h" ng-model="id_ice_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-ice-compra" ng-click="showPlanCuenta('ice_compra', 'ice_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-ice-compra" ng-click = "clean('ice_compra', 'ice_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IRBPNR: </span>
                                            <input type="text" class="form-control" name="irbpnr_compra" id="irbpnr_compra" ng-model="irbpnr_compra" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="irbpnr_compra_h" id="irbpnr_compra_h" ng-model="irbpnr_compra_h">
                                            <input type="hidden" name="id_irbpnr_compra_h" id="id_irbpnr_compra_h" ng-model="id_irbpnr_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-irbpnr-compra" ng-click="showPlanCuenta('irbpnr_compra', 'irbpnr_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-irbpnr-compra" ng-click = "clean('irbpnr_compra', 'irbpnr_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Propina: </span>
                                            <input type="text" class="form-control" name="propina_compra" id="propina_compra" ng-model="propina_compra" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="propina_compra_h" id="propina_compra_h" ng-model="propina_compra_h">
                                            <input type="hidden" name="id_propina_compra_h" id="id_propina_compra_h" ng-model="id_propina_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-propina-compra" ng-click="showPlanCuenta('propina_compra', 'propina_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-propina_compra" ng-click = "clean('propina_compra', 'propina_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <!--<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención IVA: </span>
                                            <input type="text" class="form-control" name="retiva_compra" id="retiva_compra" ng-model="retiva_compra"  readonly>
                                            <input type="hidden" name="retiva_compra_h" id="retiva_compra_h" ng-model="retiva_compra_h">
                                            <input type="hidden" name="id_retiva_compra_h" id="id_retiva_compra_h" ng-model="id_retiva_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retiva-compra" ng-click="showPlanCuenta('retiva_compra', 'retiva_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retiva_compra" ng-click = "clean('retiva_compra', 'retiva_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención Renta: </span>
                                            <input type="text" class="form-control" name="retrenta_compra" id="retrenta_compra" ng-model="retrenta_compra"  readonly>
                                            <input type="hidden" name="retrenta_compra_h" id="retrenta_compra_h" ng-model="retrenta_compra_h">
                                            <input type="hidden" name="id_retrenta_compra_h" id="id_retrenta_compra_h" ng-model="id_retrenta_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retrenta-compra" ng-click="showPlanCuenta('retrenta_compra', 'retrenta_compra_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retrenta_compra" ng-click = "clean('retrenta_compra', 'retrenta_compra_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>-->

                                </form>

                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default" ng-click="getConfigCompra()">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigCompra()" ng-disabled="formCompras.$invalid">
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_venta">

                                <form class="form-horizontal" name="formVentas" novalidate="">

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IVA: </span>
                                            <input type="text" class="form-control" name="iva_venta" id="iva_venta" ng-model="iva_venta" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="iva_venta_h" id="iva_venta_h" ng-model="iva_venta_h">
                                            <input type="hidden" name="id_iva_venta_h" id="id_iva_venta_h" ng-model="id_iva_venta_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-iva-venta" ng-click="showPlanCuenta('iva_venta', 'iva_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-iva-venta" ng-click = "clean('iva_venta', 'iva_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta ICE: </span>
                                            <input type="text" class="form-control" name="ice_venta" id="ice_venta" ng-model="ice_venta" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="ice_venta_h" id="ice_venta_h" ng-model="ice_venta_h">
                                            <input type="hidden" name="id_ice_venta_h" id="id_ice_venta_h" ng-model="id_ice_venta_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-ice-venta" ng-click="showPlanCuenta('ice_venta', 'ice_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-ice-venta" ng-click = "clean('ice_venta', 'ice_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IRBPNR: </span>
                                            <input type="text" class="form-control" name="irbpnr_venta" id="irbpnr_venta" ng-model="irbpnr_venta" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="irbpnr_venta_h" id="irbpnr_venta_h" ng-model="irbpnr_venta_h">
                                            <input type="hidden" name="id_irbpnr_venta_h" id="id_irbpnr_venta_h" ng-model="id_venta_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-irbpnr_venta" ng-click="showPlanCuenta('irbpnr_venta', 'irbpnr_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-irbpnr_venta" ng-click = "clean('irbpnr_venta', 'irbpnr_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Propina: </span>
                                            <input type="text" class="form-control" name="propina_venta" id="propina_venta" ng-model="propina_venta" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="propina_venta_h" id="propina_venta_h" ng-model="propina_venta_h">
                                            <input type="hidden" name="id_propina_venta_h" id="id_propina_venta_h" ng-model="id_propina_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-propina-venta" ng-click="showPlanCuenta('propina_venta', 'propina_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-propina_venta" ng-click = "clean('propina_venta', 'propina_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <!--<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención IVA: </span>
                                            <input type="text" class="form-control" name="retiva_venta" id="retiva_venta" ng-model="retiva_venta" placeholder=""
                                                    readonly>
                                            <input type="hidden" name="retiva_venta_h" id="retiva_venta_h" ng-model="retiva_venta_h">
                                            <input type="hidden" name="id_retiva_venta_h" id="id_retiva_venta_h" ng-model="id_retiva_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retiva-venta" ng-click="showPlanCuenta('retiva_venta', 'retiva_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retiva_venta" ng-click = "clean('retiva_venta', 'retiva_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención Renta: </span>
                                            <input type="text" class="form-control" name="retrenta_venta" id="retrenta_venta" ng-model="retrenta_venta" placeholder=""
                                                    readonly>
                                            <input type="hidden" name="retrenta_venta_h" id="retrenta_venta_h" ng-model="retrenta_venta_h">
                                            <input type="hidden" name="id_retrenta_venta_h" id="id_retrenta_venta_h" ng-model="id_retrenta_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retrenta-venta" ng-click="showPlanCuenta('retrenta_venta', 'retrenta_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retrenta_venta" ng-click = "clean('retrenta_venta', 'retrenta_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>-->

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Costo de Venta: </span>
                                            <input type="text" class="form-control" name="costo_venta" id="costo_venta" ng-model="costo_venta" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="costo_venta_h" id="costo_venta_h" ng-model="costo_venta_h">
                                            <input type="hidden" name="id_costo_venta_h" id="id_costo_venta_h" ng-model="id_costo_compra_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-costo-venta" ng-click="showPlanCuenta('costo_venta', 'costo_venta_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-costo_venta" ng-click = "clean('costo_venta', 'costo_venta_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Tipo Comprobante (defecto): </span>
                                            <select class="form-control" name="comprobante_venta" id="comprobante_venta" ng-model="comprobante_venta"
                                                    ng-options="value.id as value.label for value in listcomprobante_venta" required></select>
                                            <input type="hidden" name="comprobante_venta_h" id="comprobante_venta_h" ng-model="comprobante_venta_h" />
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formVentas.comprobante_venta.$invalid && formVentas.comprobante_venta.$touched">El Tipo de Comprobante es requerido</span>
                                    </div>

                                </form>


                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default" ng-click="getConfigVenta()">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigVenta()" ng-disabled="formVentas.$invalid" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_notacredit">

                                <form class="form-horizontal" name="formNC" novalidate="">

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IVA: </span>
                                            <input type="text" class="form-control" name="iva_nc" id="iva_nc" ng-model="iva_nc" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="iva_nc_h" id="iva_nc_h" ng-model="iva_nc_h">
                                            <input type="hidden" name="id_iva_nc_h" id="id_iva_nc_h" ng-model="id_iva_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-iva-nc" ng-click="showPlanCuenta('iva_nc', 'iva_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-iva-nc" ng-click = "clean('iva_nc', 'iva_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta ICE: </span>
                                            <input type="text" class="form-control" name="ice_nc" id="ice_nc" ng-model="ice_nc" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="ice_nc_h" id="ice_nc_h" ng-model="ice_nc_h">
                                            <input type="hidden" name="id_ice_nc_h" id="id_ice_nc_h" ng-model="id_ice_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-ice-nc" ng-click="showPlanCuenta('ice_nc', 'ice_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-ice-nc" ng-click = "clean('ice_nc', 'ice_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta IRBPNR: </span>
                                            <input type="text" class="form-control" name="irbpnr_nc" id="irbpnr_nc" ng-model="irbpnr_nc" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="irbpnr_nc_h" id="irbpnr_nc_h" ng-model="irbpnr_nc_h">
                                            <input type="hidden" name="id_irbpnr_nc_h" id="id_irbpnr_nc_h" ng-model="id_venta_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-irbpnr-nc" ng-click="showPlanCuenta('irbpnr_nc', 'irbpnr_nc_h')">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-irbpnr_nc" ng-click = "clean('irbpnr_nc', 'irbpnr_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Propina: </span>
                                            <input type="text" class="form-control" name="propina_nc" id="propina_nc" ng-model="propina_nc" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="propina_nc_h" id="propina_nc_h" ng-model="propina_nc_h">
                                            <input type="hidden" name="id_propina_nc_h" id="id_propina_nc_h" ng-model="id_propina_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-propina-nc" ng-click="showPlanCuenta('propina_nc', 'propina_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-propina_nc" ng-click = "clean('propina_nc', 'propina_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <!--<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención IVA: </span>
                                            <input type="text" class="form-control" name="retiva_nc" id="retiva_nc" ng-model="retiva_nc" placeholder=""
                                                    readonly>
                                            <input type="hidden" name="retiva_nc_h" id="retiva_nc_h" ng-model="retiva_nc_h">
                                            <input type="hidden" name="id_retiva_nc_h" id="id_retiva_nc_h" ng-model="id_retiva_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retiva_nc" ng-click="showPlanCuenta('retiva_nc', 'retiva_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retiva_nc" ng-click = "clean('retiva_nc', 'retiva_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Cuenta Retención Renta: </span>
                                            <input type="text" class="form-control" name="retrenta_nc" id="retrenta_nc" ng-model="retrenta_nc" placeholder=""
                                                    readonly>
                                            <input type="hidden" name="retrenta_nc_h" id="retrenta_nc_h" ng-model="retrenta_nc_h">
                                            <input type="hidden" name="id_retrenta_nc_h" id="id_retrenta_nc_h" ng-model="id_retrenta_nc_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-retrenta-nc" ng-click="showPlanCuenta('retrenta_nc', 'retrenta_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-retrenta_nc" ng-click = "clean('retrenta_nc', 'retrenta_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>-->

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Costo de Venta: </span>
                                            <input type="text" class="form-control" name="costo_venta" id="costo_nc" ng-model="costo_nc" placeholder=""
                                                   readonly>
                                            <input type="hidden" name="costo_nc_h" id="costo_nc_h" ng-model="costo_nc_h">
                                            <input type="hidden" name="id_costo_nc_h" id="id_costo_venta_h" ng-model="id_costo_venta_h">
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-costo-nc" ng-click="showPlanCuenta('costo_nc', 'costo_nc_h')">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-default" id="btn-l-costo_venta" ng-click = "clean('costo_nc', 'costo_nc_h')">
                                                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Tipo Comprobante (defecto): </span>
                                            <select class="form-control" name="comprobante_nc" id="comprobante_nc" ng-model="comprobante_nc"
                                                    ng-options="value.id as value.label for value in listcomprobante_nc" required></select>
                                            <input type="hidden" name="comprobante_nc_h" id="comprobante_nc_h" ng-model="comprobante_nc_h" />
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formNC.comprobante_nc.$invalid && formNC.comprobante_nc.$touched">El Tipo de Comprobante es requerido</span>
                                    </div>

                                </form>


                                <div class="col-xs-12 text-center" style="margin-top: 5px;">

                                    <button type="button" class="btn btn-default" ng-click="getConfigNC()">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigNC()" ng-disabled="formNC.$invalid" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="cont_nomina">
                                <div class="col-xs-1">

                                </div>
                                <div class="col-xs-10" style="align-content:center">

                                    <form class="form-horizontal" name="formNomina" novalidate="">

                                        <table style="padding-top: 0px; margin-top: 0px;" class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                            <thead class="bg-primary">
                                            <tr>
                                                <th>CONCEPTO DE PAGO</th>
                                                <th style="width: 50%;">ASIGNAR CUENTA</th>
                                                <th style="width: 15%;">VALOR (IMP. SRI)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="item in conceptos" ng-cloak >
                                                <td>{{item.name_conceptospago}}</td>
                                                <td>
                                                    <div ng-show="item.id_categoriapago !== 4" class="col-xs-12" style="padding: 0px">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" ng-model="item.cuenta" placeholder="Cuenta Contable"
                                                                   readonly required>
                                                            <span class="input-group-btn" role="group">
                                                                <button type="button" id="cuenta_{{$index + 1}}" class="btn btn-info"  ng-click="showPlanCuentaItem(item)">
                                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <span class="help-block error"
                                                              ng-show="formNomina.nomplancuenta.$invalid && formNomina.nomplancuenta.$touched">Es requerido</span>
                                                    </div>

                                                    <div ng-show="item.id_categoriapago == 4" class="col-xs-12" style="padding: 0px">
                                                        <div class="col-xs-6" style="margin: 0px; padding: 0px">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="nomplancuenta" ng-model="item.cuenta" placeholder="Cuenta Contable"
                                                                       readonly required>
                                                                <span class="input-group-btn" role="group">
                                                                    <button type="button" id="cuenta_f_{{$index + 1}}" class="btn btn-info" ng-click="showPlanCuentaItem(item, 'btn_cuenta')">
                                                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span class="help-block error"
                                                                  ng-show="formNomina.nomplancuenta.$invalid && formNomina.nomplancuenta.$touched">Es requerido</span>
                                                        </div>
                                                        <div class="col-xs-6 error" style="margin: 0px; padding: 0px">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="nomplancuenta" ng-model="item.cuenta1" placeholder="Cuenta Contable"
                                                                       readonly required>
                                                                <span class="input-group-btn" role="group">
                                                                    <button type="button" id="cuenta_t_{{$index + 1}}" class="btn btn-info" ng-click="showPlanCuentaItem(item, 'btn_cuenta1')">
                                                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span class="help-block error"
                                                                  ng-show="formNomina.nomplancuenta.$invalid && formNomina.nomplancuenta.$touched">Es requerido</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-right" ng-model="item.impuesto" />
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </form>

                                </div>

                                <div class="col-xs-12 text-center" style="margin-top: 5px; margin-bottom: 10px;">

                                    <button type="button" class="btn btn-default" ng-click="getConfigNomina()">
                                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                    </button>
                                    <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigNomina()" >
                                        Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div role="tabpanel" class="tab-pane fade" id="sri" style="padding-top: 10px;">

                    <form class="form-horizontal" name="formSRI" novalidate="">
                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Tipo Ambiente: </span>
                                <select class="form-control" name="s_sri_tipoambiente" id="s_sri_tipoambiente" ng-model="s_sri_tipoambiente"
                                        ng-options="value.id as value.label for value in tipoambiente" required>
                                </select>
                                <input type="hidden" name="h_sri_tipoambiente" id="h_sri_tipoambiente" ng-model="h_sri_tipoambiente">
                            </div>
                            <span class="help-block error"
                                  ng-show="formSRI.s_sri_tipoambiente.$invalid && formSRI.s_sri_tipoambiente.$touched">Tipo Ambiente es requerido</span>
                        </div>
                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Tipo Emisión: </span>
                                <select class="form-control" name="s_sri_tipoemision" id="s_sri_tipoemision" ng-model="s_sri_tipoemision"
                                        ng-options="value.id as value.label for value in tipoemision" required>
                                </select>
                                <input type="hidden" name="h_sri_tipoemision" id="h_sri_tipoemision" ng-model="h_sri_tipoemision">
                            </div>
                            <span class="help-block error"
                                  ng-show="formSRI.s_sri_tipoemision.$invalid && formSRI.s_sri_tipoemision.$touched">Tipo Emisión es requerido</span>
                        </div>
                    </form>

                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default" ng-click="getConfigSRI()">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigSRI()" ng-disabled="formSRI.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>

                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="especifica" style="padding-top: 10px;">

                    <form class="form-horizontal" name="formEspecifica" novalidate="">

                        <!--<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Dividendos: </span>
                                <input type="text" class="form-control" placeholder="Para sistema AYORA"
                                    name="t_ayora_dividendos" id="t_ayora_dividendos" ng-model="t_ayora_dividendos" required
                                       ng-keypress="onlyNumber($event, 100, 't_ayora_dividendos')" />
                                <input type="hidden" name="h_ayora_dividendos" id="h_ayora_dividendos" ng-model="h_ayora_dividendos" >
                            </div>
                            <span class="help-block error"
                              ng-show="formEspecifica.t_ayora_dividendos.$invalid && formEspecifica.t_ayora_dividendos.$touched">Dividendos es requerido</span>
                        </div>

                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Tasa Interés (%): </span>
                                <input type="text" class="form-control" placeholder="Para sistema AYORA"
                                       name="t_ayora_tasainteres" id="t_ayora_tasainteres" ng-model="t_ayora_tasainteres" required
                                       ng-keypress="onlyDecimal($event)" />
                                <input type="hidden" name="h_ayora_tasainteres" id="h_ayora_tasainteres" ng-model="h_ayora_tasainteres" >
                            </div>
                            <span class="help-block error"
                              ng-show="formEspecifica.t_ayora_tasainteres.$invalid && formEspecifica.t_ayora_tasainteres.$touched">Tasa Interés es requerida</span>
                        </div>-->

                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
                            <div class="input-group">
                                <span class="input-group-addon">Constante: </span>
                                <input type="text" class="form-control" placeholder="Para sistema Pisque"
                                       name="t_pisque_constante" id="t_pisque_constante" ng-model="t_pisque_constante" required
                                       ng-keypress="onlyDecimal($event)" />
                                <input type="hidden" name="h_pisque_constante" id="h_pisque_constante" ng-model="h_pisque_constante" >
                            </div>
                            <span class="help-block error"
                                  ng-show="formEspecifica.t_pisque_constante.$invalid && formEspecifica.t_pisque_constante.$touched">La Constante es requerida</span>
                        </div>

                    </form>
                    <div class="col-xs-12 text-center" style="margin-top: 5px;">

                        <button type="button" class="btn btn-default" ng-click="getConfigEspecifica()">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveConfigEspecifica()"  ng-disabled="formEspecifica.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>

                    </div>

                    <!--<h4>Estructura Lectura</h4>
                    <hr>

                    <form class="form-horizontal" name="formEspecifica" novalidate="">
                        <table class="table table-responsive table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <th style="width: 50%;">LECTURA</th>
                                    <th style="width: 50%;">SERVICIO A BRINDAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Consumo Tarifa Básica</td>
                                    <td>
                                        <select class="form-control" name="serv_lect_tar" id="serv_lect_tar" ng-model="serv_lect_tar"
                                                ng-options="value.id as value.label for value in list_serv"></select>
                                        <input type="hidden" name="serv_lect_tar" id="serv_lect_tar" ng-model="serv_lect_tar">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Excedente</td>
                                    <td>
                                        <select class="form-control" name="serv_lect_ex" id="serv_lect_ex" ng-model="serv_lect_ex"
                                                ng-options="value.id as value.label for value in list_serv"></select>
                                        <input type="hidden" name="serv_lect_ex" id="serv_lect_ex" ng-model="serv_lect_ex">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alcantarillado</td>
                                    <td>
                                        <select class="form-control" name="serv_lect_alcant" id="serv_lect_alcant" ng-model="serv_lect_alcant"
                                                ng-options="value.id as value.label for value in list_serv"></select>
                                        <input type="hidden" name="serv_lect_alcant" id="serv_lect_alcant" ng-model="serv_lect_alcant">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Recogida Desechos Solidos</td>
                                    <td>
                                        <select class="form-control" name="serv_lect_rds" id="serv_lect_rds" ng-model="serv_lect_rds"
                                                ng-options="value.id as value.label for value in list_serv" required></select>
                                        <input type="hidden" name="serv_lect_rds" id="serv_lect_rds" ng-model="serv_lect_rds">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medio Ambiente</td>
                                    <td>
                                        <select class="form-control" name="serv_lect_ma" id="serv_lect_ma" ng-model="serv_lect_ma"
                                                ng-options="value.id as value.label for value in list_serv" required></select>
                                        <input type="hidden" name="serv_lect_ma" id="serv_lect_ma" ng-model="serv_lect_ma">
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-default" ng-click="getListServicio()">
                                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="btn btn-success" ng-click="saveListServicio()" >
                                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>-->

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
                            <div class="form-group  has-feedback">
                                <input type="text" class="form-control" id="" ng-model="searchContabilidad" placeholder="BUSCAR..." >
                                <span class="glyphicon glyphicon-search form-control-feedback" ></span>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                                <thead class="bg-primary">
                                <tr>
                                    <th style="width: 15%;">ORDEN</th>
                                    <th>CONCEPTO</th>
                                    <th style="width: 10%;">CODIGO</th>
                                    <th style="width: 4%;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="item in cuentas | filter:searchContabilidad" ng-cloak >
                                    <td>{{item.jerarquia}}</td>
                                    <td>{{item.concepto}}</td>
                                    <td>{{item.codigosri}}</td>
                                    <td>
                                        <input ng-show="item.madreohija=='1'" ng-hide="item.madreohija!='1'" type="radio" name="select_cuenta"  ng-click="click_radio(item)">
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












