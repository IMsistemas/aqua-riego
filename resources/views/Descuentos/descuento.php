<div ng-controller="descuentosController">
        <div   class="container">

             <div class="container" style="margin-top: 2%;">
            <fieldset>
                <legend style="padding-bottom: 10px;">
                    <button type="button" ng-hide="{{validar}}" class="btn btn-primary" style="float: right;" ng-click="toggle()">Generar</button>
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
                            <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='iddescuento'; reversa=!reversa;" >Mes </a>
                        </th>
                        <th >
                             <a href="" style="text-decoration:none; color:white; width: 10%; " ng-click="ordenarColumna='porcentaje'; reversa=!reversa;" >Porcentaje</a>
                        </th>
                        <th style="text-decoration:none; color:white; width: 40%; "  >Acciones</th>
                        </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="descuento in descuentos|filter:busqueda|orderBy:ordenarColumna:reversa">
                        <td >{{descuento.mes}}</td>
                        <td>{{descuento.porcentaje}}</td>
                        <td >
                            <a href="#" class="btn btn-warning " ng-click="toggle('edit', descuento.mes, descuento.porcentaje)">Editar</a>
                            <!--<a href="#" class="btn btn-danger " ng-click="showModalConfirm(canal.idcanal, canal.descripcioncanal)">Borrar Canal</a>-->
                        </td>
                        </td>
                    </tr>

                </tbody>
                    
            </table>
                <!--<legend style="padding-bottom: 10px;">
                    <button type="button" class="btn btn-primary" style="float: right;" ng-click="save('edit',descuento.anio)">Guardar</button>
                </legend>-->
            </fieldset>
            <!-- End of Table-to-load-the-data Part -->
            <!-- Modal (Pop up when detail button clicked) -->
            
             <div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{form_title}}+' '+{{anio}}</h4>
                        </div>
                        <div class="modal-body">
                            <form name="frmdescuento" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="t_codigo_calle" class="col-sm-4 control-label">Mes</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mes" name="mes" placeholder="" ng-model="mes" disable>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Porcentaje</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="porcentaje" name="porcentaje" placeholder=""  ng-model="porcentaje" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.porcentaje.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.porcentaje.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,{{anio}},mes,porcentaje)" ng-disabled="frmDescuento.$invalid">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="myModalGenerar" tabindex="-1" role="dialog" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{form_title}}</h4>
                        </div>
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="anio">{{ahora|date:'yyyy'}}</h4>
                        </div>
                        <div class="modal-body">
                            <form name="frmDescuento" class="form-horizontal" novalidate="">

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Enero</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="enero" name="enero" placeholder=""  ng-model="enero" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.enero.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.enero.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Febrero</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="febrero" name="febrero" placeholder=""  ng-model="febrero" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.febrero.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.febrero.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Marzo</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="marzo" name="marzo" placeholder=""  ng-model="marzo" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.marzo.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.marzo.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Abril</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="abril" name="abril" placeholder=""  ng-model="abril" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.abril.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.abril.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Mayo</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="mayo" name="mayo" placeholder=""  ng-model="mayo" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.mayo.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.mayo.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="t_nombre_calle" class="col-sm-4 control-label">Junio</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="junio" name="junio" placeholder=""  ng-model="junio" ng-required="true" ng-pattern="/^[0-9]+([.][0-9]+)?$/">
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.junio.$invalid ">El porcentaje es requerido<br></span>
                                        <span class="help-inline" 
                                        ng-show="frmDescuento.junio.$error.parttern">Sòlo se aceptan números<br></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, anio)" ng-disabled="frmDescuento.$invalid">Guardar</button>
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
