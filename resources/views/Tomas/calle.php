
<div class="container" ng-controller="callesController">

    <div class="col-xs-12">

        <h4>Gestión de Tomas</h4>

        <hr>

    </div>

    <div class="col-xs-12"  style="margin-top: 15px; padding: 0;">
        <div class="col-sm-6 col-xs-12">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>
        <div class="col-sm-3">
            <select id="s_barrio" class="form-control" ng-model="s_barrio" ng-change="FiltrarPorBarrio()"
                    ng-options="value.id as value.label for value in barrioss"></select>
        </div>
        <div class="col-sm-3 col-xs-12">
            <button type="button" class="btn btn-primary" style="float: right;" ng-click="viewModalAdd()">Nuevo  <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
        </div>

    </div>

    <div class="col-xs-12">
        <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th style="width: 12%;">FECHA INGRESO</th>
                    <th style="width: 25%;">TOMA</th>
                    <th style="">OBSERVACION</th>
                    <th style="width: 20%;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr dir-paginate="item in calles | itemsPerPage:10|filter:busqueda" ng-cloak >
                    <td class="text-center">{{item.fechaingreso}}</td>
                    <td><input type="text" class="form-control" ng-model="item.namecalle"></td>
                    <td>{{item.observacion}}</td>
                    <td class="text-center">

                        <div class="btn-group" role="group" aria-label="...">
                            <!--<button type="button" class="btn btn-info" ng-click="showModalInfo(item)">
                                Información <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                            </button>-->
                            <button type="button" class="btn btn-danger" ng-click="showModalDelete(item)">
                                Eliminar <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
        <dir-pagination-controls
            max-size="10"
            direction-links="true"
            boundary-links="true" >
        </dir-pagination-controls>

    </div>

    <div class="col-xs-12" style="float: right;">
        <button type="button" class="btn btn-success" style="float: right; " ng-click="editar()">Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span></button>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalNueva">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="modal-title">Nueva Toma</h4>
                    </div>
                    <div class="col-sm-7 col-xs-12 text-right">
                        <div class="col-xs-10"><h4 class="modal-title">Fecha Ingreso:  {{date_ingreso}}</h4></div>
                        <div class="col-xs-2"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    </div>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" name="formCalle" novalidate="">

                        <div class="row">

                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Junta Modular: </span>
                                    <select id="t_barrio" class="form-control" ng-model="t_barrio"
                                            ng-options="value.id as value.label for value in barrios" required></select>
                                </div>
                            </div>

                            <div class="col-xs-12 error" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Nombre de la Toma: </span>
                                    <input type="text" class="form-control" name="nombrecalle" id="nombrecalle" ng-model="nombrecalle" placeholder=""
                                           ng-required="true" ng-maxlength="100">
                                </div>
                                <span class="help-block error"
                                      ng-show="formCalle.nombrecalle.$invalid && formCalle.nombrecalle.$touched">El nombre de la Toma es requerido</span>
                                <span class="help-block error"
                                      ng-show="formCalle.nombrecalle.$invalid && formCalle.nombrecalle.$error.maxlength">La longitud máxima es de 100 caracteres</span>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <textarea id="observacionCalle" class="form-control" rows="3" ng-model="observacionCalle" placeholder="Observación"></textarea>
                            </div>
                        </div>




                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-success" id="btn-savecalle" ng-click="saveCalle();" ng-disabled="formCalle.$invalid">
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
                    <h4 class="modal-title">Toma: {{name_calle}}</h4>
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
                            <span style="font-weight: bold">Canales en la Toma: </span>{{calle_canales}}
                        </div>
                        <div class="col-xs-12">
                            <span style="font-weight: bold">Derivaciones en la Toma: </span>{{calle_derivacion}}
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
                    <span>Realmente desea eliminar la Toma: <strong>"{{nom_calle}}"</strong>?</span>
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
