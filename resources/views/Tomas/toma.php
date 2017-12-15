

<div class="container" ng-controller="tomasController">
    <div class="container" style="margin-top: 2%;">
        <fieldset>
            <legend style="padding-bottom: 10px;">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="toggle('add', 0, 0)">Agregar</button>
            </legend>
            <div class="col-xs-6">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control input-sm" id="search-list-trans" placeholder="BUSCAR..." ng-model="busqueda">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>

            </div>
            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed" >
                    <thead class="bg-primary">
                    <tr>
                        <th>
                            <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='idtoma'; reversa=!reversa;" >Código </a>
                        </th>
                        <th >
                            <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='descripciontoma'; reversa=!reversa;" >Nombre</a>
                        </th>
                        <th style="text-decoration:none; color:white; width: 40%; "  >Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="toma in tomas|filter:busqueda|orderBy:ordenarColumna:reversa">
                        <td>{{toma.idtoma}}</td>
                        <td>{{toma.descripciontoma}}</td>
                        <td >
                            <a href="#" class="btn btn-warning " ng-click="toggle('edit', toma.idtoma, toma.descripciontoma)">Editar Toma</a>
                            <a href="#" class="btn btn-danger " ng-click="showModalConfirm(toma.idtoma, toma.descripciontoma)">Borrar Toma</a>
                            <a href="#" class="btn btn-info" ng-click="toModuloDerivacion(toma.idtoma, toma.descripciontoma);">Ver Derivaciones</a>
                        </td>
                        </td>
                    </tr>

                    </tbody>

                </table>
        </fieldset>
        <!-- End of Table-to-load-the-data Part -->
        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{form_title}}</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmToma" class="form-horizontal" novalidate="">

                            <!--<div class="form-group">
                                <label for="t_codigo_calle" class="col-sm-4 control-label">Codigo la Toma</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="idtoma" name="idtoma" placeholder="" ng-model="idtoma" disable>
                                </div>
                            </div>-->

                            <div class="form-group">
                                <label for="t_nombre_calle" class="col-sm-4 control-label">Nombre de la Toma</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="descripciontoma" name="descripciontoma" placeholder=""  ng-model="descripciontoma" ng-required="true" ng-maxlength="32" >
                                    <span class="help-inline"
                                          ng-show="frmToma.descripciontoma.$invalid ">El nombre de la Toma es requerido<br></span>
                                    <span class="help-inline"
                                          ng-show="frmToma.descripciontoma.$error.maxlength">La longitud máxima es de 32 caracteres<br></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="t_nombre_calle" class="col-sm-4 control-label">Nombre del barrio</label>
                                <div class="col-sm-8">
                                    <select class="form-control" ng-model="idbarrio" ng-options="barrio as barrio.nombrebarrio for barrio in barrios track by barrio.idbarrio">
                                        <option value="">Elige Barrio</option>
                                        `                                       </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, idtoma,idbarrio)" ng-disabled="frmToma.$invalid">Guardar</button>
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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmDelete">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Realmente desea eliminar el Toma: <span style="font-weight: bold;">{{toma_seleccionado}}</span></span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="destroyToma()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
