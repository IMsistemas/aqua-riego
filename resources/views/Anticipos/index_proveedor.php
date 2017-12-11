

<div ng-controller="anticipoProveedorController" ng-init="initLoad(1)">

    <div class="col-xs-12">

        <h4>Gestión de Anticipos a Proveedores</h4>

        <hr>

    </div>

    <div class="col-xs-12" style="margin-top: 5px;">

        <div class="col-sm-6 col-xs-8">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda" ng-keyup="initLoad(1)">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>

        <div class="col-sm-6 col-xs-4">
            <button type="button" class="btn btn-primary" style="float: right;" ng-click="createAnticipo()">
                Agregar <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>

        <div class="col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th>FECHA</th>
                        <th>PROVEEDOR</th>
                        <th>CUENTA</th>
                        <th>MONTO</th>
                        <th style="width: 25%;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in anticipos | itemsPerPage:10" total-items="totalItems" ng-cloak >
                        <td>{{item.fecha}}</td>
                        <td>{{item.idproveedor}}</td>
                        <td>{{item.idplancuenta}}</td>
                        <td>{{item.monto}}</td>
                        <td class="text-center">

                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-warning" ng-click="toggle('edit', item.idrol)">
                                    Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-default" ng-click="showModalConfirm(item)">
                                    Anular <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
            <dir-pagination-controls

                on-page-change="pageChanged(newPageNumber)"

                template-url="dirPagination.html"

                class="pull-right"
                max-size="10"
                direction-links="true"
                boundary-links="true" >

            </dir-pagination-controls>

        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalAction">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar Anticipo de Proveedor</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" name="formAnticipo" novalidate="">

                        <div class="row">

                            <div class="col-xs-12" style="padding: 0;">

                                <div class="col-xs-6 error">
                                    <div class="input-group">
                                        <span class="input-group-addon">Fecha: </span>
                                        <input type="text" class="form-control datepicker" name="fecha" id="fecha" ng-model="fecha" placeholder=""
                                               ng-required="true" >
                                    </div>
                                    <span class="help-block error"
                                          ng-show="formAnticipo.fecha.$invalid && formAnticipo.fecha.$touched">La Fecha es requerido</span>
                                </div>

                                <div class="col-xs-6 error">
                                    <div class="input-group">
                                        <span class="input-group-addon">Monto ($): </span>
                                        <input type="text" class="form-control" name="monto" id="monto" ng-model="monto" placeholder=""
                                               ng-required="true" >
                                    </div>
                                    <span class="help-block error"
                                          ng-show="formAnticipo.monto.$invalid && formAnticipo.monto.$touched">El Monto es requerido</span>
                                </div>

                            </div>

                            <div class="col-xs-12 error" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Proveedor (RUC): </span>

                                    <angucomplete-alt
                                            id = "idproveedor"
                                            pause = "200"
                                            selected-object = "showDataProveedor"

                                            remote-url = "{{API_URL}}DocumentoCompras/getProveedorByIdentify/"

                                            title-field="numdocidentific"

                                            minlength="1"
                                            input-class="form-control form-control-small small-input"
                                            match-class="highlight"
                                            field-required="true"
                                            input-name="idproveedor"
                                            disable-input="guardado"
                                            text-searching="Buscando Identificaciones Proveedor"
                                            text-no-results="Proveedor no encontrado"

                                    > </angucomplete-alt>

                                </div>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Forma Pago: </span>
                                    <select class="form-control" name="idformapago" id="idformapago" ng-model="idformapago" ng-required="true" ng-disabled="impreso"
                                            ng-options="value.id as value.label for value in listformapago">
                                    </select>
                                </div>
                                <span class="help-block error"
                                      ng-show="formAnticipo.idformapago.$invalid && formAnticipo.idformapago.$touched">La Forma Pago es requerida</span>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">C. Contab.: </span>
                                    <input type="text" class="form-control" name="idplancuenta" id="idplancuenta" ng-model="idplancuenta" placeholder=""
                                           ng-required="true" readonly>
                                    <span class="input-group-btn" role="group">
                                    <button type="button" class="btn btn-info" id="btn-pcc" ng-click="showPlanCuenta()">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </button>
                                </span>

                                </div>
                                <span class="help-block error"
                                      ng-show="formAnticipo.idplancuenta.$invalid && formAnticipo.idplancuenta.$touched">La asignación de una cuenta es requerida</span>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Centro de Costo: </span>
                                    <select class="form-control" name="iddepartamento" id="iddepartamento" ng-model="iddepartamento"
                                            ng-options="value.id as value.label for value in listdepartamento"></select>
                                </div>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <textarea class="form-control" name="observacion" id="observacion" ng-model="observacion" cols="30" rows="5" placeholder="Motivo de Anticipo" ng-required="true"></textarea>
                                <span class="help-block error"
                                      ng-show="formAnticipo.observacion.$invalid && formAnticipo.observacion.$touched">La Observación es requerida</span>
                            </div>

                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-success" id="btn-save" ng-click="save()" ng-disabled="formAnticipo.$invalid">
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmDelete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>
                <div class="modal-body">
                    <span>Realmente desea eliminar el Rol: <span style="font-weight: bold;">{{cargo_seleccionado}}</span></span>

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

</div>

