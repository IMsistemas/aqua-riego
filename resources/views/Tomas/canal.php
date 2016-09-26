<div ng-controller="canalesController">
        <div   class="container">

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
                            <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='idcanal'; reversa=!reversa;" >Código </a>
                        </th>
                        <th >
                             <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='descripcioncanal'; reversa=!reversa;" >Nombre</a>
                        </th>
                        <th style="text-decoration:none; color:white; width: 40%; "  >Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="canal in canales|filter:busqueda|orderBy:ordenarColumna:reversa">
                        <td>{{canal.idcanal}}</td>
                        <td>{{canal.descripcioncanal}}</td>
                        <td >
                            <a href="#" class="btn btn-warning " ng-click="toggle('edit', canal.idcanal, canal.descripcioncanal)">Editar Canal</a>
                            <a href="#" class="btn btn-danger " ng-click="showModalConfirm(canal.idcanal, canal.descripcioncanal)">Borrar Canal</a>
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
                            <form name="frmCanal" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="t_codigo_calle" class="col-sm-4 control-label">Codigo del Canal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="idcanal" name="idcanal" placeholder="" ng-model="idcanal" disable>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Nombre del Canal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="descripcioncanal" name="descripcioncanal" placeholder=""  ng-model="descripcioncanal" ng-required="true" ng-maxlength="32" >
                                        <span class="help-inline" 
                                        ng-show="frmCanal.descripcioncanal.$invalid ">El nombre del Canal es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmCanal.descripcioncanal.$error.maxlength">La longitud máxima es de 32 caracteres<br></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, idcanal)" ng-disabled="frmCanal.$invalid">Guardar</button>
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
                        <span>Realmente desea eliminar el Canal: <span style="font-weight: bold;">{{canal_seleccionado}}</span></span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="destroyCanal()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>




        </div>
    </div>
