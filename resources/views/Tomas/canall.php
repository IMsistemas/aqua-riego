

<div class="container" ng-controller="canallController">


    <div class="col-xs-12">

        <h4>Gestión de Canales</h4>

        <hr>

    </div>


    <div class="col-xs-12" style="margin-top: 15px; padding: 0;">

        <div class="col-sm-9 col-xs-12">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>


        <div class="col-sm-3 col-xs-12">
            <button type="button" class="btn btn-primary" style="float: right;" ng-click="viewModalAdd()">Agregar <span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
        </div>

    </div>

    <div class="col-xs-12">
        <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
            <thead class="bg-primary">
                <tr>
                    <th style="width: 12%;">FECHA INGRESO</th>
                    <th style="width: 25%;">CANAL</th>
                    <th style="">OBSERVACION</th>
                    <th style="width: 20%;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr dir-paginate="item in canals | itemsPerPage:10 | filter:busqueda" ng-cloak >
                    <td class="text-center">{{item.fechaingreso}}</td>
                    <td>{{item.nombrecanal}}</td>
                    <td>{{item.observacion}}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-warning" ng-click="showModalEdit(item)">
                                Editar <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </button>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalNueva">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{title_modal}}</h4>

                </div>

                <div class="modal-body">
                    <form class="form-horizontal" name="formCanal" novalidate="">

                        <div class="row">

                            <div class="col-xs-12 error" style="margin-top: 5px;">
                                <div class="input-group">
                                    <span class="input-group-addon">Nombre del Canal: </span>
                                    <input type="text" class="form-control"  name="nombrecanal" id="nombrecanal" ng-model="nombrecanal" placeholder=""
                                           ng-required="true" ng-maxlength="100">
                                </div>
                                <span class="help-block error"
                                      ng-show="formCanal.nombrecanal.$invalid && formCanal.nombrecanal.$touched">El nombre del Canal es requerido</span>
                                <span class="help-block error"
                                      ng-show="formCanal.nombrecanal.$invalid && formCanal.nombrecanal.$error.maxlength">La longitud máxima es de 100 caracteres</span>
                            </div>

                            <div class="col-xs-12" style="margin-top: 5px;">
                                <textarea id="observacionCanal" class="form-control" rows="3" ng-model="observacionCanal" placeholder="Observación"></textarea>
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



