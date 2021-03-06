<!DOCTYPE html>
<html lang="es-ES" ng-app="softver-aqua">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Retencion Compras</title>

        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/angucomplete-alt.css') ?>" rel="stylesheet">

        <style>
            .dataclient{
                font-weight: bold;
            }
        </style>
    </head>

    <body>

        <div ng-controller="retencionComprasController">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="idretencioncompra" value="<?= $idretencioncompra ?>">

            <form name="formRteCompras" novalidate="">
                
                <div class="col-xs-12" style="padding-top: 5px;">
                    <div class="col-sm-4 col-xs-12"><img ng-src="../../img/logo.png" style=""></div>
                    <div class="col-sm-4 col-xs-12 text-center" style="padding-top: 3%; font-weight: bold; font-size: 24px;">
                        RETENCIONES COMPRA
                    </div>
                    <div class="col-sm-4 col-xs-12" style="padding-top: 2%;">
                        <div style="float: right">
                            <a href="#id" ng-click="imprimir()" data-toggle="tab" >
                                <img ng-src="../../img/impresora.png" style="height: 50px" >
                            </a>
                        </div>
                        <div style="float: right">
                            <a href="#id" ng-click="pdf()" data-toggle="tab">
                                <img ng-src="../../img/pdf.png" style="height: 50px" >
                            </a>
                        </div>
                        <div style="float: right">
                            <a href="#id" ng-click="excel()" data-toggle="tab">
                                <img ng-src="../../img/excel.png" style="height: 50px" >
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-12" style="margin-top: 15px;">
                    <div class="col-sm-4 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Fecha Ingreso: </span>
                            <input type="text" class="datepicker form-control" id="t_fechaingreso" name="t_fechaingreso" ng-model="t_fechaingreso" placeholder="" disabled />
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12 error">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Retención Nro.: </span>
                            <input type="text" class="form-control" id="t_nroretencion" name="t_nroretencion"
                                   ng-model="t_nroretencion" ng-required="true" ng-keypress="onlyNumber($event, 12, 't_nroretencion')" placeholder="" />

                        </div>
                        <span class="help-block error" style="text-align: right !important; color: red;"
                              ng-show="formRteCompras.t_nroretencion.$invalid && formRteCompras.t_nroretencion.$touched" >El Nro. de Retención es requerido</span>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Compra Nro.: </span>
                            <!--<input type="text" class="form-control" id="t_nrocompra" name="t_nrocompra" ng-model="t_nrocompra" placeholder="" />-->

                            <angucomplete-alt
                                    id = "t_nrocompra"
                                    pause = "400"
                                    selected-object = "showDataPurchase"

                                    remote-url = "{{API_URL}}../getCompras/"

                                    title-field="codigocompra"

                                    minlength="1"
                                    input-class="form-control"
                                    match-class="highlight"
                                    field-required="true"
                                    input-name="t_nrocompra"
                                    disable-input="guardado"
                                    text-searching="Buscando Compras"
                                    text-no-results="Compra no encontrada"

                            />


                        </div>
                        <span class="help-block error" style="text-align: right !important; color: red;"
                              ng-show="formRteCompras.t_nrocompra.$invalid && formRteCompras.t_nrocompra.$touched" >El Nro. de Compra es requerido</span>
                    </div>
                </div>

                <div class="col-xs-12" style="margin-top: 15px;">
                    <fieldset>
                        <legend>Datos Retención</legend>
                        <div class="container">
                            <div class="col-xs-12">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> RUC / CI: </span>
                                        <input type="text" class="form-control" id="t_rucci" name="t_rucci" ng-model="t_rucci" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Razón Social: </span>
                                        <input type="text" class="form-control" id="t_razonsocial" name="t_razonsocial" ng-model="t_razonsocial" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> Télefono: </span>
                                        <input type="text" class="form-control" id="t_phone" name="t_phone" ng-model="t_phone" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Dirección: </span>
                                        <input type="text" class="form-control" id="t_direccion" name="t_direccion" ng-model="t_direccion" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Ciudad: </span>
                                        <input type="text" class="form-control" id="t_ciudad" name="t_ciudad" ng-model="t_ciudad" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tipo Comprobante: </span>
                                        <input type="text" class="form-control" id="t_tipocomprobante" name="t_tipocomprobante" ng-model="t_tipocomprobante" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Nro. Documento: </span>
                                        <span class="input-group-btn" style="width: 15%;">
                                        <input type="text" class="form-control" id="t_establ" name="t_establ" ng-model="t_establ" ng-keypress="onlyNumber($event, 3, 't_establ')" ng-blur="calculateLength('t_establ', 3)" />
                                    </span>
                                        <span class="input-group-btn" style="width: 15%;" >
                                        <input type="text" class="form-control" id="t_pto" name="t_pto" ng-model="t_pto" ng-keypress="onlyNumber($event, 3, 't_pto')" ng-blur="calculateLength('t_pto', 3)" />
                                    </span>
                                        <input type="text" class="form-control" id="t_secuencial" name="t_secuencial" ng-model="t_secuencial" ng-keypress="onlyNumber($event, 9, 't_secuencial')" ng-blur="calculateLength('t_secuencial', 9)" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 error">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Autorización: </span>
                                        <input type="text" class="form-control" id="t_nroautorizacion" name="t_nroautorizacion"
                                               ng-model="t_nroautorizacion" ng-required="true" ng-keypress="onlyNumber($event, 16, 't_nroautorizacion')" placeholder="" />
                                    </div>
                                    <span class="help-block error" style="text-align: right !important; color: red;"
                                          ng-show="formRteCompras.t_nroautorizacion.$invalid && formRteCompras.t_nroautorizacion.$touched" >El Nro. de Autorización es requerido</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-xs-12" style="margin-top: 15px;">
                    <fieldset>
                        <legend>Detalle Retención</legend>

                        <div class="container">

                            <div class="col-xs-12">
                                <button type="button" class="btn btn-primary" id="btn-createrow" style="float: right;" ng-click="createRow()"
                                        data-toggle="tooltip" data-placement="left" title="Agregar Retención" disabled>
                                    <i class="fa fa-lg fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <table class="table table-responsive table-striped table-hover table-condensed">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center" style="width: 8%;">
                                            Año
                                        </th>
                                        <th class="text-center" style="width: 12%;">
                                            Código
                                        </th>
                                        <th class="text-center" ng-click="sort('')">
                                            Detalle
                                            <span class="glyphicon sort-icon" ng-show="sortKey==''"
                                                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                                        </th>
                                        <th class="text-center" style="width: 15%;" ng-click="sort('')">
                                            Base Imponible
                                            <span class="glyphicon sort-icon" ng-show="sortKey==''"
                                                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                                        </th>
                                        <th class="text-center" style="width: 10%;" ng-click="sort('')">
                                            %
                                            <span class="glyphicon sort-icon" ng-show="sortKey==''"
                                                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                                        </th>
                                        <th class="text-center" style="width: 12%;" ng-click="sort('')">
                                            Valor
                                            <span class="glyphicon sort-icon" ng-show="sortKey==''"
                                                  ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                                        </th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in itemretencion" ng-cloak>
                                        <td class="text-center">{{item.year}}</td>
                                        <td>
                                            <input type="hidden" name="h_iddetalleretencionfuente" ng-model="h_iddetalleretencionfuente">
                                            <div class="col-xs-12">
                                                <angucomplete-alt
                                                        id = "item.codigo{{$index}}"
                                                        pause = "400"
                                                        selected-object = "showInfoRetencion"
                                                        selected-object-data = "item"

                                                        remote-url = "{{API_URL}}../getCodigos/"

                                                        title-field="codigosri"

                                                        minlength="1"
                                                        input-class="form-control text-right error"
                                                        match-class="highlight"
                                                        field-required="true"
                                                        input-name="itemcodigo{{$index}}"
                                                        disable-input="guardado"
                                                        text-searching="Buscando Códigos"
                                                        text-no-results="Código no encontrado"
                                                        initial-value="item.codigo"
                                                />
                                            </div>
                                            <span class="help-block error" style="text-align: right !important; color: red;"
                                                  ng-show="formRteCompras.itemcodigo{{$index}}.$invalid && formRteCompras.itemcodigo{{$index}}.$touched" >
                                                Es requerido</span>
                                        </td>
                                        <td>{{item.detalle}}</td>
                                        <td class="text-right">$ {{item.baseimponible}}</td>
                                        <td>
                                            <input type="text" class="form-control" style="text-align: right !important;" ng-model="item.porciento" ng-blur="recalculateRow(item)" ng-keypress="onlyDecimal($event)">
                                        </td>
                                        <td class="text-right">$ {{item.valor}}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger" name="btn-deleterow" style="float: right;" ng-click="deleteRow(item)"
                                                    data-toggle="tooltip" data-placement="left" title="Eliminar Retención" >
                                                <i class="fa fa-lg fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">TOTAL:</th>
                                        <th>
                                            <input type="text" class="form-control" style="text-align: right !important;" id="t_total" name="t_total" ng-model="t_total" ng-keypress="onlyDecimal($event)" disabled/>
                                        </th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-xs-12">
                                <button type="button" class="btn btn-default" style="float: right;" ng-click=""
                                        data-toggle="tooltip" data-placement="bottom" title="Anular la Retención de la Compra">
                                    Anular <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-success" style="float: right;" ng-click="save()" ng-disabled="formRteCompras.$invalid"
                                        data-toggle="tooltip" data-placement="left" title="Guardar la Retención de la Compra" >
                                    Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                                </button>
                            </div>

                        </div>
                    </fieldset>
                </div>
            </form>
            
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

        </div>

    </body>

    <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/dirPagination.js') ?>"></script>
    <script src="<?= asset('js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset('js/menuLateral.js') ?>"></script>
    <script src="<?= asset('js/moment.min.js') ?>"></script>
    <script src="<?= asset('js/es.js') ?>"></script>
    <script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= asset('app/lib/angular/ng-file-upload-shim.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/ng-file-upload.min.js') ?>"></script>

    <script src="<?= asset('app/lib/angular/angucomplete-alt.min.js') ?>"></script>
    <script src="<?= asset('app/app.js') ?>"></script>

    <script src="<?= asset('app/controllers/retencionCompraController.js') ?>"></script>
</html>

