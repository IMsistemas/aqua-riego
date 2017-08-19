

    <div ng-controller="clientesController">

        <div class="col-xs-12">

            <h4>Gestión de Clientes</h4>

            <hr>

        </div>

        <div class="col-xs-12" style="margin-top: 5px;">
            <div class="col-sm-6 col-xs-12">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="t_busqueda" placeholder="BUSCAR..." ng-model="t_busqueda">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon">Estado:</span>
                    <select class="form-control" name="s_estado_search" id="s_estado_search" ng-model="s_estado_search" ng-change="initLoad(1)">
                        <option value="0">-- Seleccione --</option>
                        <option value="1">ACTIVO</option>
                        <option value="2">INACTIVO</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="showModalAddCliente()">
                    Agregar <span class="glyphicon glyphicon-plus" aria-hidden="true">
                </button>
            </div>
        </div>

        <div class="col-xs-12" style="font-size: 12px !important;">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th class="text-center" style="width: 10%;">RUC / CI</th>
                    <th class="text-center" style="width: 10%;">FECHA INGRESO</th>
                    <th class="text-center" style="">RAZON SOCIAL / NOMBRE Y APELLIDOS</th>
                    <th class="text-center" style="width: 8%;">CELULAR</th>
                    <th class="text-center" style="width: 20%;">DIRECCION</th>
                    <th class="text-center" style="width: 7%;">ESTADO</th>
                    <th class="text-center" style="width: 15%;">ACCIONES</th>
                </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in clientes | orderBy:sortKey:reverse | itemsPerPage:8" total-items="totalItems" ng-cloak >
                        <td>{{item.numdocidentific}}</td>
                        <td>{{item.fechaingreso | formatDate}}</td>
                        <td>{{item.razonsocial}}</td>
                        <td>{{item.celphone}}</td>
                        <td>{{item.direccion}}</td>

                        <td ng-if="item.estado == true" class="btn-success text-center" style="font-weight: bold;">ACTIVO</td>
                        <td ng-if="item.estado == false" class="btn-danger text-center" style="font-weight: bold;">INACTIVO</td>

                        <td  class="text-center">

                            <div class="btn-group" role="group" aria-label="...">
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
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
            <dir-pagination-controls

                    on-page-change="pageChanged(newPageNumber)"

                    template-url="dirPagination.html"

                    class="pull-right"
                    max-size="8"
                    direction-links="true"
                    boundary-links="true" >

            </dir-pagination-controls>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalAddCliente">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form class="form-horizontal" name="formEmployee" novalidate="">
                        <div class="modal-header modal-header-primary">
                            <div class="col-md-3 col-xs-12">
                                <h4 class="modal-title">{{title_modal_cliente}}</h4>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Fecha de Ingreso:</span>
                                    <input type="text" class="datepicker form-control" name="t_fecha_ingreso" id="t_fecha_ingreso" ng-model="t_fecha_ingreso" ng-required="true">
                                </div>
                                <span class="help-block error"
                                      ng-show="formEmployee.t_fecha_ingreso.$invalid && formEmployee.t_fecha_ingreso.$touched">La Fecha de Ingreso es requerida</span>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Estado:</span>
                                    <select class="form-control" name="s_estado" id="s_estado" ng-model="s_estado">
                                        <option value="1">ACTIVO</option>
                                        <option value="2">INACTIVO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 col-xs-12 text-right" style="padding: 0;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-xs-12" style="margin-top: 5px;">

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Tipo Identificación: </span>
                                            <select class="form-control" name="tipoidentificacion" id="tipoidentificacion" ng-model="tipoidentificacion"
                                                    ng-options="value.id as value.label for value in idtipoidentificacion" required></select>
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.tipoidentificacion.$invalid && formEmployee.tipoidentificacion.$touched">El Tipo de Identificación es requerido</span>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">RUC / CI:</span>
                                            <!--<input type="text" class="form-control" name="documentoidentidadempleado" id="documentoidentidadempleado"
                                                   ng-model="documentoidentidadempleado" ng-required="true" ng-maxlength="13" > -->

                                            <angucomplete-alt
                                                    id = "documentoidentidadempleado"
                                                    pause = "200"
                                                    selected-object = "showDataPurchase"

                                                    input-changed="inputChanged"

                                                    remote-url = "{{API_URL}}cliente/getIdentify/"

                                                    focus-out="focusOut()"


                                                    title-field="numdocidentific"

                                                    minlength="1"
                                                    input-class="form-control form-control-small small-input"
                                                    match-class="highlight"
                                                    field-required="true"
                                                    input-name="documentoidentidadempleado"
                                                    disable-input="guardado"
                                                    text-searching="Buscando Identificaciones Personas"
                                                    text-no-results="Persona no encontrada"

                                            > </angucomplete-alt>

                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.documentoidentidadempleado.$invalid && formEmployee.documentoidentidadempleado.$touched">La Identificación es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.documentoidentidadempleado.$invalid && formEmployee.documentoidentidadempleado.$error.maxlength">La longitud máxima es de 13 caracteres</span>
                                    </div>

                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Apellidos: </span>
                                            <input type="text" class="form-control" name="apellido" id="apellido"
                                                   ng-model="apellido" ng-required="true" ng-maxlength="128" ng-pattern="/^([a-zA-ZáéíóúñÑ ])+$/" >
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.apellido.$invalid && formEmployee.apellido.$touched">El Apellido es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.apellido.$invalid && formEmployee.apellido.$error.maxlength">La longitud máxima es de 128 caracteres</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.apellido.$invalid && formEmployee.apellido.$error.pattern">El Apellido debe ser solo letras y espacios</span>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Nombre(s): </span>
                                            <input type="text" class="form-control" name="nombre" id="nombre"
                                                   ng-model="nombre" ng-required="true" ng-maxlength="128" ng-pattern="/^([a-zA-ZáéíóúñÑ ])+$/" >
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.nombre.$invalid && formEmployee.nombre.$touched">El Nombre es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.nombre.$invalid && formEmployee.nombre.$error.maxlength">La longitud máxima es de 128 caracteres</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.nombre.$invalid && formEmployee.nombre.$error.pattern">El Nombre debe ser solo letras y espacios</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Teléfono Principal: </span>
                                            <input type="text" class="form-control" name="telefonoprincipal" id="telefonoprincipal"
                                                   ng-model="telefonoprincipal" ng-minlength="9" ng-maxlength="16" ng-pattern="/^([0-9-\(\)]+)$/" required>
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipal.$invalid && formEmployee.telefonoprincipal.$touched">El Teléfono Principal es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipal.$invalid && formEmployee.telefonoprincipal.$error.maxlength">La longitud máxima es de 16 números</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipal.$invalid && formEmployee.telefonoprincipal.$error.pattern">El Teléfono debe ser solo números, guion y espacios</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipal.$invalid && formEmployee.telefonoprincipal.$error.minlength">La longitud mínima es de 9 caracteres</span>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Teléfono Secundario: </span>
                                            <input type="text" class="form-control" name="telefonosecundario" id="telefonosecundario"
                                                   ng-model="telefonosecundario" ng-minlength="9"  ng-maxlength="16" ng-pattern="/^([0-9-\(\)]+)$/" >
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundario.$invalid && formEmployee.telefonosecundario.$error.maxlength">La longitud máxima es de 16 números</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundario.$invalid && formEmployee.telefonosecundario.$error.pattern">El Teléfono debe ser solo números, guion y espacios</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundario.$invalid && formEmployee.telefonosecundario.$error.minlength">La longitud mínima es de 9 caracteres</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Celular: </span>
                                            <input type="text" class="form-control" name="celular" id="celular"
                                                   ng-model="celular" ng-minlength="10" ng-maxlength="16" ng-pattern="/^([0-9-\(\)]+)$/">
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.celular.$invalid && formEmployee.celular.$error.maxlength">La longitud máxima es de 16 números</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.celular.$invalid && formEmployee.celular.$error.pattern">El Teléfono debe ser solo números, guion y espacios</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.celular.$invalid && formEmployee.celular.$error.minlength">La longitud mínima es de 10 caracteres</span>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">E-mail: </span>
                                            <input type="text" class="form-control" name="correo" id="correopersona" ng-model="correo" ng-pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/" placeholder="" required>
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.correo.$invalid && formEmployee.correo.$touched">El E-mail es requerido</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.correo.$invalid && formEmployee.correo.$error.pattern">Formato de email no es correcto</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Dirección: </span>
                                            <input type="text" class="form-control" name="direccion" id="direccion" ng-model="direccion" ng-maxlength="256">
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.direccion.$invalid && formEmployee.direccion.$touched">La Dirección es requerida</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.direccion.$invalid && formEmployee.direccion.$error.maxlength">La longitud máxima es de 256 caracteres</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Teléfono Principal Trabajo: </span>
                                            <input type="text" class="form-control" name="telefonoprincipaltrabajo" id="telefonoprincipaltrabajo"
                                                   ng-model="telefonoprincipaltrabajo" ng-minlength="9" ng-maxlength="16" ng-pattern="/^([0-9-\(\)]+)$/" >
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipaltrabajo.$invalid && formEmployee.telefonoprincipaltrabajo.$error.maxlength">La longitud máxima es de 16 números</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipaltrabajo.$invalid && formEmployee.telefonoprincipaltrabajo.$error.pattern">El Teléfono debe ser solo números, guion y espacios</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonoprincipaltrabajo.$invalid && formEmployee.telefonoprincipaltrabajo.$error.minlength">La longitud mínima es de 9 caracteres</span>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Teléfono Secundario Trabajo: </span>
                                            <input type="text" class="form-control" name="telefonosecundariotrabajo" id="telefonosecundariotrabajo"
                                                   ng-model="telefonosecundariotrabajo" ng-minlength="9"  ng-maxlength="16" ng-pattern="/^([0-9-\(\)]+)$/" >
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundariotrabajo.$invalid && formEmployee.telefonosecundariotrabajo.$error.maxlength">La longitud máxima es de 16 números</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundariotrabajo.$invalid && formEmployee.telefonosecundariotrabajo.$error.pattern">El Teléfono debe ser solo números, guion y espacios</span>
                                        <span class="help-block error"
                                              ng-show="formEmployee.telefonosecundariotrabajo.$invalid && formEmployee.telefonosecundariotrabajo.$error.minlength">La longitud mínima es de 9 caracteres</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Dirección Trabajo: </span>
                                            <input type="text" class="form-control" name="direcciontrabajo" id="direcciontrabajo" ng-model="direcciontrabajo" ng-maxlength="256">
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.direcciontrabajo.$invalid && formEmployee.direcciontrabajo.$error.maxlength">La longitud máxima es de 256 caracteres</span>
                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Impuesto IVA: </span>
                                            <select class="form-control" name="iva" id="iva" ng-model="iva"
                                                    ng-options="value.id as value.label for value in imp_iva" required></select>
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.iva.$invalid && formEmployee.iva.$touched">El Impuesto IVA es requerido</span>

                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Tipo (ATS): </span>
                                            <select class="form-control" name="tipoempresaats" id="tipoempresaats" ng-model="tipoempresaats"
                                                    ng-options="value.id as value.label for value in listtipoempresaats" required></select>
                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.tipoempresaats.$invalid && formEmployee.tipoempresaats.$touched">El Tipo es requerido</span>

                                    </div>
                                </div>

                                <div class="col-xs-12" style="margin-top: 5px;">

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Tipo Parte (ATS): </span>
                                            <select class="form-control" name="tipoparte" id="tipoparte" ng-model="tipoparte"
                                                    ng-options="value.id as value.label for value in listtipoparte" required></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">C. Contab.: </span>
                                            <input type="text" class="form-control" name="cuenta_employee" id="cuenta_employee" ng-model="cuenta_employee" placeholder=""
                                                   ng-required="true" readonly>
                                            <span class="input-group-btn" role="group">
                                                <button type="button" class="btn btn-info" id="btn-pcc" ng-click="showPlanCuenta()">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                            </span>

                                        </div>
                                        <span class="help-block error"
                                              ng-show="formEmployee.cuenta_employee.$error.required">La asignación de una cuenta es requerida</span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save" ng-click="saveCliente()" ng-disabled="formEmployee.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
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
                                        <th style="width: 10%;">COD. SRI</th>
                                        <th style="width: 4%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="item in cuentas | filter:searchContabilidad" ng-cloak >
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalDeleteCliente">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Realmente desea eliminar el cliente: <strong>"{{nom_cliente}}"</strong> </span>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Información Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <!--<div class="col-xs-12 text-center">
                            <img class="img-thumbnail" src="<?= asset('img/solicitud.png') ?>" alt="">
                        </div>-->
                        <div class="row">

                            <div class="col-xs-12 text-center" style="font-size: 24px; margin-bottom: 10px;">{{name_cliente}}</div>

                            <div class="col-xs-6">

                                <div class="col-xs-12 text-center" style="margin-bottom: 10px; font-weight: bold;">DATOS PERSONALES</div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">CI / RUC: </span>{{identify_cliente}}
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
                                    <span style="font-weight: bold">Tipo: </span>{{tipoempresa}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Tipo Parte: </span>{{tipoparte}}
                                </div>
                                <div class="col-xs-12">
                                    <span style="font-weight: bold">Estado: </span>{{estado_solicitud}}
                                </div>

                            </div>

                            <div class="col-xs-6">
                                <div class="col-xs-12 text-center" style="margin-bottom: 10px; font-weight: bold;">DATOS TERRENO</div>

                                <div class="col-xs-12" style="overflow-y: auto; height: 230px;">

                                    <div class="row" ng-repeat="terrenos_item in terrenos_list">
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">No. Terreno: </span>{{terrenos_item.idterreno}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Junta Modular: </span>{{terrenos_item.derivacion.canal.calle.barrio.namebarrio}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Toma: </span>{{terrenos_item.derivacion.canal.calle.namecalle}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Canal: </span>{{terrenos_item.derivacion.canal.nombrecanal}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Derivación: </span>{{terrenos_item.derivacion.nombrederivacion}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Tipo Cultivo: </span>{{terrenos_item.cultivo.tarifa.nombretarifa}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Cultivo: </span>{{terrenos_item.cultivo.nombrecultivo}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Area: </span>{{terrenos_item.area}}
                                        </div>
                                        <div class="col-xs-12">
                                            <span style="font-weight: bold">Caudal: </span>{{terrenos_item.caudal}}
                                        </div>
                                        <div class="col-xs-12">
                                            <hr>
                                        </div>
                                    </div>

                                </div>

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
                        <h4 class="modal-title">Tipo de Solicitud</h4>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn btn-primary btn-block" ng-click="actionRiego()">
                            RIEGO
                        </button>
                        <button type="button" class="btn btn-primary btn-block" ng-click="actionSetName()">
                            CAMBIO DE NOMBRE
                        </button>
                        <button type="button" class="btn btn-primary btn-block" ng-click="actionFraccion()">
                            FRACCIONAMIENTO
                        </button>
                        <button type="button" class="btn btn-primary btn-block" ng-click="actionOtro()">
                            OTRO TIPO
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
                            <h4 class="modal-title">Solicitud de Riego Nro: {{num_solicitud_riego}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_process"
                                           id="t_fecha_process" ng-model="t_fecha_process" style="color: black !important;" disabled>
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

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente" id="documentoidentidad_cliente"
                                                           ng-model="documentoidentidad_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cliente: </span>
                                                    <input class="form-control" type="text" name="nom_cliente" id="nom_cliente"
                                                           ng-model="nom_cliente" disabled >
                                                </div>

                                                <input type="hidden" ng-model="h_codigocliente">
                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente" id="direcc_cliente"
                                                           ng-model="direcc_cliente" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente" id="celular_cliente"
                                                           ng-model="celular_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente" id="telf_cliente"
                                                           ng-model="telf_cliente" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente" id="telf_trab_cliente"
                                                           ng-model="telf_trab_cliente" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-xs-12" style="padding: 0; margin-top: -15px;">
                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Nro. Terreno: </span>
                                                    <input class="form-control" type="text" name="nro_terreno" id="nro_terreno" ng-model="nro_terreno" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Escrituras: </span>
                                                    <input class="form-control" type="file" ngf-select ng-model="file" name="file" id="file"
                                                           ngf-max-size="8MB" >
                                                </div>
                                                <!--<span class="help-block error"
                                                          ng-show="formProcess.file.$error.pattern">El archivo debe ser PDF</span>-->
                                                <span class="help-block error"
                                                      ng-show="formProcess.file.$error.maxSize">El tamaño máximo es de 8 MB </span>
                                            </div>


                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Tipo Cultivo: </span>
                                                    <select class="form-control" name="t_tarifa" id="t_tarifa"
                                                            ng-model="t_tarifa" ng-options="value.id as value.label for value in tarifas"
                                                            ng-change="getCultivos()"></select><!--ng-change="showAddCultivo()"-->
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12 error">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cultivo: </span>
                                                    <select class="form-control" name="t_cultivo" id="t_cultivo"
                                                            ng-model="t_cultivo" ng-options="value.id as value.label for value in cultivos">
                                                    </select><!--ng-change="showAddCultivo()"-->
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12 error">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Area (m2): </span>
                                                    <input type="text" class="form-control" name="t_area" id="t_area" ng-keypress="onlyNumber($event)"
                                                           ng-model="t_area" ng-required="true" ng-pattern="/^([0-9.]+)$/" ng-blur="calculate()">
                                                </div>
                                                <span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                                <span class="help-block error"
                                                      ng-show="formProcess.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Caudal: </span>
                                                    <input class="form-control" type="text" name="calculate_caudal" id="calculate_caudal" ng-model="calculate_caudal" disabled >
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Valor Anual: </span>
                                                    <input class="form-control" type="text" name="valor_total" id="valor_total" ng-model="valor_total" disabled >
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -35px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Ubicación</legend>
                                        <div class="col-sm-6 col-xs-12 error">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <select class="form-control" name="t_junta" id="t_junta"
                                                        ng-model="t_junta" ng-options="value.id as value.label for value in barrios"
                                                        ng-change="getTomas()" ></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <select class="form-control" name="t_toma" id="t_toma"
                                                        ng-model="t_toma" ng-options="value.id as value.label for value in tomas"
                                                        ng-change="getCanales()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <select class="form-control" name="t_canal" id="t_canal"
                                                        ng-model="t_canal" ng-options="value.id as value.label for value in canales"
                                                        ng-change="getDerivaciones()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12 error" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <select class="form-control" name="t_derivacion" id="t_derivacion"
                                                        ng-model="t_derivacion" ng-options="value.id as value.label for value in derivaciones"></select>
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_riego" ng-model="t_observacion_riego" rows="2" placeholder="Observación"></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-riego"
                                ng-click="saveSolicitudRiego()" ng-disabled="formProcess.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-riego"
                                ng-click="procesarSolicitud('btn-process-riego')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionSetNombre">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Solicitud de Cambio de Nombre Nro: {{num_solicitud_setnombre}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_setnombre"
                                           id="t_fecha_setnombre" ng-model="t_fecha_setnombre" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formSetNombre" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente actual</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente_setnombre" id="documentoidentidad_cliente_setnombre"
                                                           ng-model="documentoidentidad_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Nombre y Apellidos: </span>
                                                    <input class="form-control" type="text" name="nom_cliente_setnombre" id="nom_cliente_setnombre"
                                                           ng-model="nom_cliente_setnombre" disabled >
                                                </div>
                                                <input type="hidden" ng-model="h_codigocliente_setnombre">

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente_setnombre" id="direcc_cliente_setnombre"
                                                           ng-model="direcc_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente_setnombre" id="telf_cliente_setnombre"
                                                           ng-model="telf_cliente_setnombre" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente_setnombre" id="telf_clcelular_cliente_setnombreiente_setnombre"
                                                           ng-model="celular_cliente_setnombre" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente_setnombre" id="telf_trab_cliente_setnombre"
                                                           ng-model="telf_trab_cliente_setnombre" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Terrenos </span>
                                                <select class="form-control" name="t_terrenos_setnombre" id="t_terrenos_setnombre"
                                                        ng-model="t_terrenos_setnombre" ng-options="value.id as value.label for value in terrenos_setN"
                                                        ng-change="searchInfoTerreno()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <input class="form-control" type="text" name="junta_setnombre" id="junta_setnombre"
                                                       ng-model="junta_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <input class="form-control" type="text" name="toma_setnombre" id="toma_setnombre"
                                                       ng-model="toma_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <input class="form-control" type="text" name="canal_setnombre" id="canal_setnombre"
                                                       ng-model="canal_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <input class="form-control" type="text" name="derivacion_setnombre" id="derivacion_setnombre"
                                                       ng-model="derivacion_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Tipo Cultivo: </span>
                                                <input class="form-control" type="text" name="cultivo_setnombre" id="cultivo_setnombre"
                                                       ng-model="cultivo_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area (m2): </span>
                                                <input class="form-control" type="text" name="area_setnombre" id="area_setnombre"
                                                       ng-model="area_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_setnombre" id="caudal_setnombre"
                                                       ng-model="caudal_setnombre" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del nuevo Cliente</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <select class="form-control"
                                                        name="t_ident_new_client_setnombre" id="t_ident_new_client_setnombre"
                                                        ng-model="t_ident_new_client_setnombre" ng-options="value.id as value.label for value in clientes_setN"
                                                        ng-change="getClienteByIdentify()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_new_cliente_setnombre" id="nom_new_cliente_setnombre"
                                                       ng-model="nom_new_cliente_setnombre" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_new_codigocliente_setnombre">

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Dirección Domicilio: </span>
                                                <input class="form-control" type="text" name="direcc_new_cliente_setnombre" id="direcc_new_cliente_setnombre"
                                                       ng-model="direcc_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Domicilio: </span>
                                                <input class="form-control" type="text" name="telf_new_cliente_setnombre" id="telf_new_cliente_setnombre"
                                                       ng-model="telf_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Celular: </span>
                                                <input class="form-control" type="text" name="celular_new_cliente_setnombre" id="celular_new_cliente_setnombre"
                                                       ng-model="celular_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Trabajo: </span>
                                                <input class="form-control" type="text" name="telf_trab_new_cliente_setnombre" id="telf_trab_new_cliente_setnombre"
                                                       ng-model="telf_trab_new_cliente_setnombre" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>
                                <div class="col-xs-12" style="">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_setnombre" ng-model="t_observacion_setnombre" rows="2" placeholder="Observacion"></textarea>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-setnombre"
                                ng-click="saveSolicitudSetName()" ng-disabled="formSetNombre.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-setnombre"
                                ng-click="procesarSolicitud('btn-process-setnombre')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionFraccion">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Solicitud de Fraccionamiento Nro: {{num_solicitud_fraccion}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_fraccion" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_fraccion"
                                           id="t_fecha_fraccion" ng-model="t_fecha_fraccion" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formFraccion" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <input class="form-control" type="text" name="documentoidentidad_cliente_fraccion" id="documentoidentidad_cliente_fraccion"
                                                       ng-model="documentoidentidad_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_cliente_fraccion" id="nom_cliente_fraccion"
                                                       ng-model="nom_cliente_fraccion" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_codigocliente_fraccion">
                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Dirección Domicilio: </span>
                                                <input class="form-control" type="text" name="direcc_cliente_fraccion" id="direcc_cliente_fraccion"
                                                       ng-model="direcc_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Domicilio: </span>
                                                <input class="form-control" type="text" name="telf_cliente_fraccion" id="telf_cliente_fraccion"
                                                       ng-model="telf_cliente_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Celular: </span>
                                                <input class="form-control" type="text" name="celular_cliente_fraccion" id="celular_cliente_fraccion"
                                                       ng-model="celular_cliente_fraccion" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Teléfono Trabajo: </span>
                                                <input class="form-control" type="text" name="telf_trab_cliente_fraccion" id="telf_trab_cliente_fraccion"
                                                       ng-model="telf_trab_cliente_fraccion" disabled >
                                            </div>

                                        </div>


                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos de Terreno</legend>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Terrenos: </span>
                                                <select class="form-control" name="t_terrenos_fraccion" id="t_terrenos_fraccion"
                                                        ng-model="t_terrenos_fraccion" ng-options="value.id as value.label for value in terrenos_fraccion"
                                                        ng-change="searchInfoTerrenoFraccion()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Junta Modular: </span>
                                                <input class="form-control" type="text" name="junta_fraccion" id="junta_fraccion"
                                                       ng-model="junta_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Toma: </span>
                                                <input class="form-control" type="text" name="toma_fraccion" id="toma_fraccion"
                                                       ng-model="toma_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Canal: </span>
                                                <input class="form-control" type="text" name="canal_fraccion" id="canal_fraccion"
                                                       ng-model="canal_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Derivación: </span>
                                                <input class="form-control" type="text" name="derivacion_fraccion" id="derivacion_fraccion"
                                                       ng-model="derivacion_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-6 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Tipo Cultivo: </span>
                                                <input class="form-control" type="text" name="cultivo_fraccion" id="cultivo_fraccion"
                                                       ng-model="cultivo_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area Actual (m2): </span>
                                                <input class="form-control" type="text" name="area_fraccion" id="area_fraccion"
                                                       ng-model="area_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_fraccion" id="caudal_fraccion"
                                                       ng-model="caudal_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Valor: </span>
                                                <input class="form-control" type="text" name="valor_fraccion" id="valor_fraccion"
                                                       ng-model="valor_fraccion" disabled >
                                            </div>

                                        </div>


                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Area Fracc.: </span>
                                                <input type="text" class="form-control" name="t_area_fraccion" id="t_area_fraccion" ng-keypress="onlyNumber($event)"
                                                       ng-model="t_area_fraccion" ng-required="true" ng-pattern="/^([0-9]+)$/" ng-blur="calculateFraccion()">
                                            </div>
                                            <span class="help-block error"
                                                  ng-show="formFraccion.t_area.$invalid && formProcess.t_area.$touched">El Area es requerido</span>
                                            <span class="help-block error"
                                                  ng-show="formFraccion.t_area.$invalid && formProcess.t_area.$error.pattern">El Area debe ser solo números</span>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Caudal: </span>
                                                <input class="form-control" type="text" name="caudal_new_fraccion" id="caudal_new_fraccion"
                                                       ng-model="caudal_new_fraccion" disabled >
                                            </div>

                                        </div>

                                        <div class="col-sm-4 col-xs-12" style="margin-top: 5px;">

                                            <div class="input-group">
                                                <span class="input-group-addon">Valor: </span>
                                                <input class="form-control" type="text" name="valor_new_fraccion" id="valor_new_fraccion"
                                                       ng-model="valor_new_fraccion" disabled >
                                            </div>

                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="padding: 2%; margin-top: -25px !important;">
                                    <fieldset>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Nuevo Cliente</legend>

                                        <div class="col-sm-5 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">RUC/CI: </span>
                                                <select class="form-control"
                                                        name="t_ident_new_client_fraccion" id="t_ident_new_client_fraccion"
                                                        ng-model="t_ident_new_client_fraccion" ng-options="value.id as value.label for value in clientes_fraccion"
                                                        ng-change="getClienteByIdentifyFraccion()"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-5 col-xs-12">

                                            <div class="input-group">
                                                <span class="input-group-addon">Cliente: </span>
                                                <input class="form-control" type="text" name="nom_new_cliente_fraccion" id="nom_new_cliente_fraccion"
                                                       ng-model="nom_new_cliente_fraccion" disabled >
                                            </div>

                                            <input type="hidden" ng-model="h_new_codigocliente_fraccion">

                                        </div>

                                        <div class="col-sm-2 col-xs-12">
                                            <input type="checkbox" class="" ng-model="ch_arriend_fraccion"> Arriendo
                                        </div>

                                    </fieldset>
                                </div>

                                <div class="col-xs-12" style="margin-top: -15px;">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_fraccion" ng-model="t_observacion_fraccion" rows="2" placeholder="Observacion"></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-fraccion"
                                ng-click="saveSolicitudFraccion()" ng-disabled="formFraccion.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-fraccion"
                                ng-click="procesarSolicitud('btn-process-fraccion')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalActionOtro">
            <div class="modal-dialog" role="document" style="width: 60%;">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">

                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title">Otra Solicitud Nro: {{num_solicitud_otro}}</h4>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <h4 class="modal-title"><label for="t_fecha_process" class="col-sm-6" style="font-weight: normal !important;">Fecha Ingreso:</label></h4>
                                <div class="col-sm-5" style="padding: 0;">
                                    <input type="text" class="form-control input-sm datepicker" name="t_fecha_otro"
                                           id="t_fecha_otro" ng-model="t_fecha_otro" style="color: black !important;" disabled>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" name="formProcessOtros" novalidate="">

                            <div class="row">
                                <div class="col-xs-12" style="padding: 2%; margin-top: -20px !important;">
                                    <fieldset ng-cloak>
                                        <legend style="font-size: 16px; font-weight: bold;">Datos del Cliente</legend>

                                        <div class="col-xs-12" style="padding: 0;">
                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">RUC/CI: </span>
                                                    <input class="form-control" type="text" name="documentoidentidad_cliente_otro" id="documentoidentidad_cliente_otro"
                                                           ng-model="documentoidentidad_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-6 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Cliente: </span>
                                                    <input class="form-control" type="text" name="nom_cliente_otro" id="nom_cliente_otro"
                                                           ng-model="nom_cliente_otro" disabled >
                                                </div>

                                                <input type="hidden" ng-model="h_codigocliente_otro">
                                            </div>
                                        </div>

                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Dirección Domicilio: </span>
                                                    <input class="form-control" type="text" name="direcc_cliente_otro" id="direcc_cliente_otro"
                                                           ng-model="direcc_cliente_otro" disabled >
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding: 0; margin-top: 5px;">
                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Celular: </span>
                                                    <input class="form-control" type="text" name="celular_cliente_otro" id="celular_cliente_otro"
                                                           ng-model="celular_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Domicilio: </span>
                                                    <input class="form-control" type="text" name="telf_cliente_otro" id="telf_cliente_otro"
                                                           ng-model="telf_cliente_otro" disabled >
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-xs-12">

                                                <div class="input-group">
                                                    <span class="input-group-addon">Teléfono Trabajo: </span>
                                                    <input class="form-control" type="text" name="telf_trab_cliente_otro" id="telf_trab_cliente_otro"
                                                           ng-model="telf_trab_cliente_otro" disabled >
                                                </div>

                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-xs-12">
                                        <textarea class="form-control" id="t_observacion_otro" ng-model="t_observacion_otro" rows="2" ng-required="true" placeholder="Observación"></textarea>
                                        <span class="help-block error"
                                              ng-show="formProcessOtros.t_observacion_otro.$invalid && formProcessOtros.t_observacion_otro.$touched">La Descripción es requerida</span>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-success" id="btn-save-otro"
                                ng-click="saveSolicitudOtro();" ng-disabled="formProcessOtros.$invalid">
                            Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn-process-otro"
                                ng-click="procesarSolicitud('btn-process-otro')" disabled>
                            Procesar <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
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
