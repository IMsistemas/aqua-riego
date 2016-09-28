    <div ng-controller="clientesController">
        <div   class="container">

            <div class="container" style="margin-top: 2%;">
            <fieldset>
                <legend style="padding-bottom: 10px;">
                    <button type="button" class="btn btn-primary" style="float: right;" ng-show="false" ng-click="toggle('add', 0)">Agregar</button>
                </legend>
            <div class="col-xs-6">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control input-sm" id="search-list-trans" placeholder="BUSCAR..." ng-model="busqueda">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>

            </div>
            <div class="col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed"  width="100%" overflow-y="auto" _overflow="auto" margin="0 0 1em" >
                <thead class="bg-primary">
                    <tr>
                        <!--<th> 
                            <a href="#" style="text-decoration:none; color:white;" ng-click="ordenarColumna='documentoidentidad'; reversa=!reversa;">Profesión</a>
                        </th>
                        <th> 
                            <a href="#" style="text-decoration:none; color:white;" ng-click="ordenarColumna='documentoidentidad'; reversa=!reversa;">Actividad</a>
                        </th>-->
                        <th> 
                            <a href="#" style="text-decoration:none; color:white;" ng-click="ordenarColumna='documentoidentidad'; reversa=!reversa;">CI |RUC</a>
                        </th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='fechaingreso'; reversa=!reversa;">Fecha Ingreso</a>
                        </th>
                        <th style="text-decoration:none; color:white;" >Razón Social</th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='celular'; reversa=!reversa;">Celular</a>
                        </th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='correo'; reversa=!reversa;">Correo</a>
                        </th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='direccion'; reversa=!reversa;">Dirección Domicilio</a>
                        </th>
                        <!--<th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='telefonoprincipal'; reversa=!reversa;">Telef.Pral. Domicilio</a>
                        </th>
                        <!--<th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='telefonosecundario'; reversa=!reversa;">Telef.Sec. Domicilio</a>
                        </th>-->
                        <!--<th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='direccion'; reversa=!reversa;">Dirección Trabajo</a>
                        </th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='telefonoprincipal'; reversa=!reversa;">Telef.Pral. Trabajo</a>
                        </th>
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='telefonosecundario'; reversa=!reversa;">Telef.Sec. Trabajo</a>
                        </th>-->
                        <th> 
                            <a href="" style="text-decoration:none; color:white;" ng-click="ordenarColumna='telefonosecundario'; reversa=!reversa;">Estado</a>
                        </th>
                        <th style="text-decoration:none; color:white;"  class="text-center">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="cliente in clientes|filter:busqueda| orderBy:ordenarColumna:reversa">
                        <!--<td>{{cliente.idprofesion}}</td>
                        <td>{{cliente.idactividad}}</td>-->
                        <td>{{cliente.documentoidentidad}}</td>
>                        <td>{{cliente.fechaingreso|date}}</td>
                        <td>{{cliente.apellido+' '+cliente.nombre}}</td>      
                        <td>{{cliente.celular}}</td>  
                        <td>{{cliente.correo}}</td>
                        <td>{{cliente.direcciondomicilio}}</td>   
                        <!--<td>{{cliente.telefonoprincipaldomicilio}}</td>   
                        <td>{{cliente.telefonosecundariodomicilio}}</td>
                        <td>{{cliente.direcciontrabajo}}</td>   
                        <td>{{cliente.telefonoprincipaltrabajo}}</td>   
                        <td>{{cliente.telefonosecundariotrabajo}}</td>-->
                        <td><?php echo  ("{{cliente.estaactivo}}" =="true")? 'Activo' : 'Inactivo' ; ?></td>
                        <td >
                            <a href="#" class="btn btn-warning" ng-click="toggle('info', cliente.codigocliente)">Ver</a>    
                            <a href="#" class="btn btn-info" ng-click="toggle('edit', cliente.codigocliente)">Editar</a>                       
                        </td>
                        <!--<td >
                            <a href="#" class="btn btn-danger" ng-click="confirmDelete(cliente.documentoidentidad)">Borrar</a>
                        </td>-->
                    </tr>

                </tbody>
                    
            </table>
            </fieldset>

            <!-- End of Table-to-load-the-data Part -->
            <!-- Modal (Pop up when detail button clicked) -->



<div class="modal fade" tabindex="-1" role="dialog" id="modalInfoCliente">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-info">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Información del Cliente</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-xs-12 text-center">
                                            <img class="img-thumbnail" src="<?= asset('img/cliente.png') ?>" alt="">
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-xs-12 text-center" style="font-size: 18px;">{{cliente.nombre+' '+cliente.apellido}}</div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">CI/RUC: </span>{{cliente.documentoidentidad}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Fecha Ingreso: </span>{{cliente.fechaingreso|date}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Dirección del domicilio: </span>{{cliente.direcciondomicilio}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Telef Principal del domicilio: </span>{{cliente.telefonoprincipaldomicilio}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Telef Secundario del domicilio: </span>{{cliente.telefonosecundariodomicilio}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Correo: </span>{{cliente.correo}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Celular: </span>{{cliente.celular}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Dirección del trabajo: </span>{{cliente.direcciontrabajo}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Telef Principal del trabajo: </span>{{cliente.telefonoprincipaltrabajo}}
                                            </div>
                                            <div class="col-xs-12">
                                                <span style="font-weight: bold">Telef Secundario del trabajo: </span>{{cliente.telefonosecundariotrabajo}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
 
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                        <div class="col-md-6 col-xs-12">
                            <h4 class="modal-title" id="myModalLabel">{{form_title}}</h4>
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="fechaingreso" class="col-sm-5 control-label">Fecha de Ingreso:</label>
                                <div class="col-sm-6" style="padding: 0;">
                                   <label >{{cliente.fechaingreso | date : format : 'fullDate'}}</label>
                                </div>
                                <div class="col-sm-1 col-xs-12 text-right" style="padding: 0;">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        </div>
                        </div>

                        


                        <div class="modal-body">
                            <form name="frmClientes" class="form-horizontal" novalidate="">
                         <div class="row">
                        <fieldset>
                            <legend style="padding-bottom: 5px; padding-left: 20px">Datos Cliente</legend>
                                <div class="col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">CI/RUC:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control has-error" name="documentoidentidad" id="documentoidentidad"
                                                       ng-model="cliente.documentoidentidad" ng-required="true" ng-minlength ="10" ng-maxlength ="32" ng-pattern="/^[0-9]+$/">
                                                        <span class="help-inline" ng-show="frmClientes.documentoidentidad.$invalid">El documento del cliente es requerido <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.documentoidentidad.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.minlength">La longitud mínima es de 10 caracteres <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.maxlength">La longitud máxima es de 32 caracteres</span>
                                                       
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Profesión:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control has-error" name="documentoidentidad" id="documentoidentidad"
                                                       ng-model="cliente.documentoidentidad" ng-required="true" ng-minlength ="10" ng-maxlength ="32" ng-pattern="/^[0-9]+$/">
                                                        <span class="help-inline" ng-show="frmClientes.documentoidentidad.$invalid">El documento del cliente es requerido <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.documentoidentidad.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.minlength">La longitud mínima es de 10 caracteres <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.maxlength">La longitud máxima es de 32 caracteres</span>
                                                       
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Actividad:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control has-error" name="documentoidentidad" id="documentoidentidad"
                                                       ng-model="cliente.documentoidentidad" ng-required="true" ng-minlength ="10" ng-maxlength ="32" ng-pattern="/^[0-9]+$/">
                                                        <span class="help-inline" ng-show="frmClientes.documentoidentidad.$invalid">El documento del cliente es requerido <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.documentoidentidad.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.minlength">La longitud mínima es de 10 caracteres <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.documentoidentidad.$error.maxlength">La longitud máxima es de 32 caracteres</span>
                                                       
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Correo:</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="correo" id="correro"
                                                       ng-model="cliente.correo" ng-required="true" ng-maxlength="32">
                                                       <span class="help-inline" ng-show="frmClientes.correo.$invalid">El el correo del cliente es requerido <br></span>
                                                       <span class="help-inline" ng-show="frmClientes.correo.$error.maxlength">La longitud máxima es de 32 caracteres <br></span>
                                                        <span class="help-inline" ng-show="frmClientes.correo.$error.email">No es un correo valido <br></span>                                                        
                                            </div>
                                        </div>
                                     </div>

                                    
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Apellidos:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="apellido" id="apellido"
                                                       ng-model="cliente.apellido" ng-required="true" ng-maxlength ="32" ng-pattern="/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$/" >
                                                       <span class="help-inline" ng-show="frmClientes.apellido.$invalid">El apellido del cliente es requerido <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.apellido.$error.maxlength">La longitud máxima es de 32 caracteres <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.apellido.$error.pattern">Sólo se aceptan caracteres alfabeticos <br></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Nombres:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="nombre" id="nombre"
                                                       ng-model="cliente.nombre" ng-required="true" ng-maxlength ="32"   ng-pattern="/^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$/">
                                                        <span class="help-inline" ng-show="frmClientes.nombre.$invalid">El nombre del cliente es requerido <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.nombre.$error.maxlength">La longitud máxima es de 32 caracteres <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.nombre.$error.pattern">Sólo se aceptan caracteres alfanumericos <br></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Telf. Principal:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="telefonoprincipal" id="telefonoprincipal"
                                                       ng-model="telprincipaldomicilio" ng-required="true" ng-maxlength ="16" ng-pattern="/^[0-9]+$/">
                                                       <span class="help-inline" ng-show="frmClientes.telefonoprincipal.$invalid">El teléfono principal del cliente es requerido <br></span>
                                                       <span class="help-inline" 
                                                        ng-show="frmClientes.telefonoprincipal.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.telefonoprincipal.$error.maxlength">La longitud máxima es de 16 caracteres <br></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Telf. Secundario:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="telefonosecundario" id="telefonosecundario"
                                                       ng-model="telsecundariodomicilio" ng-required="true" ng-maxlength ="16"  ng-pattern="/^[0-9]+$/">
                                                       <span class="help-inline" ng-show="frmClientes.telefonosecundario.$invalid">El teléfono secundario del cliente es requerido <br></span>
                                                       <span class="help-inline" 
                                                        ng-show="frmClientes.telefonosecundario.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.telefonosecundario.$error.maxlength">La longitud máxima es de 16 caracteres <br></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Celular:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="celular" id="celular"
                                                       ng-model="celular" ng-required="true" ng-maxlength ="16" ng-pattern="/^[0-9]+$/">
                                                       <span class="help-inline" ng-show=" frmClientes.celular.$invalid">El celular del cliente es requerido <br></span>
                                                       <span class="help-inline" 
                                                        ng-show="frmClientes.celular.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show=" frmClientes.celular.$error.maxlength">La longitud máxima es de 16 caracteres <br></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Dirección:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="direccion" id="direccion"
                                                       ng-model="cliente.direcciondomicilio" ng-required="true" ng-maxlength ="32">
                                                       <span class="help-inline" ng-show="frmClientes.direccion.$invalid">El dirección del cliente es requerido <br></span>                         
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.direccion.$error.maxlength">La longitud máxima es de 32 caracteres <br></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </fieldset> 
                                <fieldset>
                                    <legend style="padding-bottom: 5px; padding-left: 20px">Datos del Trabajo</legend>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Dirección:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="direccion" id="direccion"
                                                       ng-model="cliente.direcciontrabajo" ng-required="true" ng-maxlength ="32">
                                                       <span class="help-inline" ng-show="frmClientes.direccion.$invalid">El dirección del cliente es requerido <br></span>                         
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.direccion.$error.maxlength">La longitud máxima es de 32 caracteres <br></span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Telef.Principal:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="telefonoprincipal" id="telefonoprincipal"
                                                       ng-model="telprincipaltrabajo" ng-required="true" ng-maxlength ="16" ng-pattern="/^[0-9]+$/">
                                                       <span class="help-inline" ng-show="frmClientes.telefonoprincipal.$invalid">El teléfono principal del cliente es requerido <br></span>
                                                       <span class="help-inline" 
                                                        ng-show="frmClientes.telefonoprincipal.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.telefonoprincipal.$error.maxlength">La longitud máxima es de 16 caracteres <br></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group error">
                                            <label class="col-sm-4 control-label">Telef. Secundario:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="telefonosecundario" id="telefonosecundario"
                                                       ng-model="telsecundariotrabajo" ng-required="true" ng-maxlength ="16"  ng-pattern="/^[0-9]+$/">
                                                       <span class="help-inline" ng-show="frmClientes.telefonosecundario.$invalid">El teléfono secundario del cliente es requerido <br></span>
                                                       <span class="help-inline" 
                                                        ng-show="frmClientes.telefonosecundario.$error.pattern">Sólo se permiten números <br></span>
                                                        <span class="help-inline" 
                                                        ng-show="frmClientes.telefonosecundario.$error.maxlength">La longitud máxima es de 16 caracteres <br></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>          
                            </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, codigocliente)" ng-disabled="frmClientes.$invalid">Guardar</button>
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
        </div>
    </div>

