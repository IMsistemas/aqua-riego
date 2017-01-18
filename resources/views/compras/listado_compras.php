
    <div ng-controller="comprasproductoController">
    
    <div class="container1" ng-show="listado">       

        <div class="col-xs-12" style="margin-top: 2%; margin-bottom: 2%">

            <div class="col-sm-4 col-xs-6">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                           ng-model="search" ng-change="searchByFilter()">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-3">
                <div class="form-group has-feedback">
                    <select class="form-control" name="proveedor" id="proveedor" ng-model="proveedorFiltro"
                      ng-change="searchByFilter()">
                        <option value="">Proveedor</option>
						<option ng-repeat="item in proveedoresFiltro"						       
						        value="{{item.idproveedor}}">{{item.razonsocialproveedor}}     
						</option>                        
                        </select>                    
                </div>
            </div>
            
            <div class="col-sm-2 col-xs-3">
                <div class="form-group has-feedback">
                    <select class="form-control" name="estado" id="estado" ng-model="estadoFiltro"
                        ng-change="searchByFilter()">
                        <option value="">Estado</option>
						<option ng-repeat="item in estados"						       
						        value="{{item.id}}">{{item.nombre}}     
						</option>                        
                        </select>                    
                </div>
            </div>
 

            <div class="col-sm-4 col-xs-6">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="openForm(0)">
                   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </div>

            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <thead class="bg-primary">
                    <tr>
                        <th style="text-align: center;" ng-click="sort('codigocompra')">
                        Código
                         <span class="glyphicon sort-icon" ng-show="sortKey=='codigocompra'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th style="text-align: center;" ng-click="sort('fecharegistrocompra')">
                        Fecha Ingreso
                        <span class="glyphicon sort-icon" ng-show="sortKey=='fecharegistrocompra'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th style="text-align: center;" ng-click="sort('razonsocialproveedor')">
                        Proveedor
                        <span class="glyphicon sort-icon" ng-show="sortKey=='razonsocialproveedor'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>     
                        <th style="text-align: center;">Subtotal</th>   
                        <th style="text-align: center;">IVA</th> 
                        <th style="text-align: center;" ng-click="sort('totalcompra')">
                        Total
                         <span class="glyphicon sort-icon" ng-show="sortKey=='totalcompra'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th style="text-align: center;" ng-click="sort('estapagada')">
                        Estado
                         <span class="glyphicon sort-icon" ng-show="sortKey=='estapagada'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>                 
                        <th style="width: 10%;">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr dir-paginate="item in compras|orderBy:sortKey:reverse|itemsPerPage:10" >
                        <td style="text-align: center;">{{item.codigocompra}}</td>
                        <td>{{formatoFecha(item.fecharegistrocompra)}}</td>
                        <td>{{item.razonsocialproveedor}}</td>
                        <td>{{ sumar(item.subtotalnoivacompra,item.subtotalivacompra) }}</td>
                        <td>{{item.ivacompra  }}</td>
                        <td>{{item.totalcompra}}</td>                      
                        <td>{{(item.estapagada)?'Pagado':'No Pagado'}}</td>
                        <td>
                            <button type="button" class="btn btn-info" ng-click="openForm(item.codigocompra)"
                                    data-toggle="tooltip" data-placement="bottom" title="Ver" >
                                <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-danger" ng-click="showModalConfirm(item.codigocompra,0)"
                                    data-toggle="tooltip" data-placement="bottom" title="Anular"  ng-disabled="item.estaanulada==1">
                                <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                            </button>
                                                        
                        </td>
                    </tr>
                    </tbody>
                </table>
                <dir-pagination-controls
			       max-size="5"
			       direction-links="true"
			       boundary-links="true" >
			    </dir-pagination-controls>

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

        <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmAnular">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Está seguro que desea Anular la compra seleccionada?</span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="anularCompra()">Anular</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoEmpleado">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Información Empleado No {{empleado.idempleado}} </h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 text-center">
                       			<img ng-src="{{ rutafoto }}" onerror="defaultImage(this)" class="img-thumbnail" style="width:150px" >                            
                        </div>
                        <div class="row text-center">
                            <div class="col-xs-12 text-center" style="font-size: 18px;">{{empleado.nombres}} {{empleado.apellidos}}</div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Cargo: </span>{{empleado.nombrecargo}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Empleado desde: </span>{{formatoFecha(empleado.fechaingreso)}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Teléfonos: </span>{{empleado.telefonoprincipaldomicilio}} / {{empleado.telefonosecundariodomicilio}}
                            </div>
                            
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Celular: </span>{{empleado.celular}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Dirección: </span>{{empleado.direcciondomicilio}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Email: </span>{{empleado.correo}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <!-- Formulario -->
    
    
    
	<div class="col-xs-12" ng-show="!listado" style="padding-top: 30px">
<div>			
				
				<div ng-show="guardado" style="float: right">
				<div style="float: left">
				<a href="#id" ng-click="excel()" data-toggle="tab">
					<img ng-src="img/excel.png" style="height: 40px" >
					</a>
				</div>
				<div style="float: left">
				<a href="#id" ng-click="pdf()" data-toggle="tab">
					<img ng-src="img/pdf.png" style="height: 40px" >
					</a>
				</div>
				<div style="float: left" >
				<a href="#id" ng-click="imprimir()" data-toggle="tab" >
					<img ng-src="img/impresora.png" style="height: 40px" >
					</a>
				</div>
					
				</div>

			</div>



			<ul class="nav nav-tabs">
				<li class="active"><a href="#id1" data-toggle="tab">Ingreso</a></li>
				<li ><a href="#id2" ng-show="false" data-toggle="tab" >Retencion</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="id1">
				<div class="container1" style="padding-top: 20px;">
				<form class="form-horizontal" name="formCompra" id="formCompra"  novalidate="" >
		<div class="form-group col-xs-12">
			
				<div class="form-group col-xs-6">
				<div class="form-group col-xs-12">
						<label class="control-label">Datos Proveedor</label>
			</div>
					<div class="col-md-6 col-xs-12">
		              <div class="input-group date datepicker">
		                <label class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i> Fecha Registro</label>
		                <input type="text" class="form-control input-sm" id="fecharegistrocompra" ng-model="compra.fecharegistrocompra" >
		                <label class="input-group-addon"  ><i class="fa fa-calendar"></i></label>
		              </div>
		          </div>
						
					<div class="col-md-6 col-xs-12">
		              <div class="input-group">
		                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Registro Compra No: </span>
		                <input type="text" class="form-control input-sm" value="{{('000000'+compra.codigocompra).slice(-7)}}" readonly >
		              </div>
		          </div>
		          
		          <div class="col-xs-12">
		          	<div class="input-group">
		                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> RUC/CI: </span>
		                <input type="hidden" id="idproveedor" name="idproveedor" ng-model="compra.idproveedor">
						<input type="text" class="form-control" name="ci" ng-model="ci"
									ng-keyup="loadProveedor()"
									id="ci" ng-required="true"
									ng-maxlength="13"
									ng-pattern="/[0-9]+$/"
									ng-disabled="impreso"
									> 
	              </div>
	              <span class="help-block error"
									ng-show="formCompra.ci.$invalid && formCompra.ci.$touched">El Ruc/CI es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.ci.$invalid && formCompra.ci.$error.maxlength">La
									longitud máxima es de 13 caracteres.</span> <span
									class="help-block error"
									ng-show="formCompra.ci.$invalid && formCompra.ci.$error.pattern">El Ruc/CI no es válido.</span>
									<span class="help-block error" ng-show="mensaje">El Proveedor no Existe.</span>
	              </div>
		           <div class="col-xs-12">
				          <div class="input-group">
			                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Razon Social</span>
			                <input type="text" class="form-control input-sm" id="razon" readonly >
			            </div>
		            </div>
		            <div class="col-xs-12">
				          <div class="input-group">
			                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Dirección</span>
			                <input type="text" class="form-control input-sm" id="direccion" readonly >
			            </div>
		            </div>
		            <div class="col-xs-12">
				          <div class="input-group">
			                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Teléfono</span>
			                <input type="text" class="form-control input-sm" id="telefono" readonly >
			            </div>
		            </div>
		            
		            <div class="col-md-6 col-xs-12">
				          <div class="input-group">
			                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Iva</span>
			                <input type="text" class="form-control input-sm" id="iva" readonly >
			            </div>
		            </div>   
						
					 <div class="col-md-6 col-xs-12">
			              <div class="input-group" >
			                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt "></i></span>		                
			                
			                <select ng-disabled="impreso" class="form-control" name="bodega" id="bodega" ng-model="compra.codigocomprbante" ng-required="true" >
                               						<option value="">Bodega</option>
													<option ng-repeat="item in bodegas"						       
													        value="{{item.idbodega}}">{{ item.namebodega }}     
													</option> 
												</select>		                
			              </div>
			              <span class="help-block error" ng-show="formCompra.bodega.$invalid && formCompra.bodega.$touched">La Bodega es requerida</span>              
			          </div>	          
		          </div>
				<div class="form-group col-xs-6">	
				
				<div class="form-group col-xs-12">
					<label class="control-label">Datos Documento</label>
				</div>				
				<div class="col-xs-12">				
				 <div class="row" >
                	<div class="col-xs-5" >
	                  <div class="input-group" >
	                  <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-filter"></i> No. Documento</span>
	                    <input type="text" class="form-control" name="numero1" ng-model="numero1"									
										id="numero1" ng-required="true"
										ng-minlength="3"
										maxlength="3"
										ng-pattern="/[0-9]+$/"
										
										ng-disabled="guardado"
										> <span class="help-block error"
										ng-show="formCompra.numero1.$invalid && formCompra.numero1.$touched">El Establecimineto es requerido</span> 
										<span class="help-block error"
										ng-show="formCompra.numero1.$invalid && formCompra.numero1.$error.minlength">La
										longitud mínima es de 3 caracteres.</span> <span
										class="help-block error"
										ng-show="formCompra.numero1.$invalid && formCompra.numero1.$error.pattern">El Establecimineto no es válido.</span>
	                  </div>
	                </div>
                <div class="col-xs-2" style="padding: 0px;">
                  <div class="input-group">
                    <input type="text" class="form-control" name="numero2" ng-model="numero2"									
									id="numero2" ng-required="true"
									ng-minlength="3"
									maxlength="3"
									ng-pattern="/[0-9]+$/"
									
									ng-disabled="guardado"
									> <span class="help-block error"
									ng-show="formCompra.numero2.$invalid && formCompra.numero2.$touched">El Facturero es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.numero2.$invalid && formCompra.numero2.$error.minlength">La
									longitud mínima es de 3 caracteres.</span> <span
									class="help-block error"
									ng-show="formCompra.numero2.$invalid && formCompra.numero2.$error.pattern">El Facturero no es válido.</span>
                  </div>
                </div>
                <div class="col-xs-5" >
                  <div class="input-group">
                    <input type="text" class="form-control" name="numero3" ng-model="numero3"									
									id="numero3" ng-required="true"
									ng-maxlength="8"
									maxlength="8"
									
									ng-pattern="/[0-9]+$/"
									style="width: 100px;"
									ng-disabled="guardado"
									> <span class="help-block error"
									ng-show="formCompra.numero3.$invalid && formCompra.numero3.$touched">El número es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.numero3.$invalid && formCompra.numero3.$error.minlength">La
									longitud mínima es de 8 caracteres.</span> <span
									class="help-block error"
									ng-show="formCompra.numero3.$invalid && formCompra.numero3.$error.pattern">El número no es válido.</span>
                  </div>
                </div>
              </div>				
				</div>
				<div class="col-xs-12">	
					<div class="input-group date datepicker">
		                <label class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i> Fecha Emisión:</label>
		                
							<input type="text" class="form-control " name="fechaemisionfacturaproveedor"
									id="fechaemisionfacturaproveedor" 
									ng-model="compra.fechaemisionfacturaproveedor"									
									>
		                <label class="input-group-addon"  ><i class="fa fa-calendar"></i></label>
		              </div>
				</div>
				<div class="col-xs-12">
				
				<div class="input-group" >
	                <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-tag"></i> Autorizacion</span>
	                <input type="text" class="form-control" name="autorizacionfacturaproveedor" ng-model="compra.autorizacionfacturaproveedor"									
									id="autorizacionfacturaproveedor" ng-required="true"
									ng-maxlength="37"
									maxlength="37"
									ng-pattern="/[0-9]+$/"
									ng-disabled="impreso"
									> 
	             </div>
	             <span class="help-block error"
									ng-show="formCompra.autorizacionfacturaproveedor.$invalid && formCompra.autorizacionfacturaproveedor.$touched">La Autorización es requerida</span> 
									<span class="help-block error"
									ng-show="formCompra.autorizacionfacturaproveedor.$invalid && formCompra.autorizacionfacturaproveedor.$error.maxlength">La
									longitud máxima es de 37 caracteres.</span> <span
									class="help-block error"
									ng-show="formCompra.autorizacionfacturaproveedor.$invalid && formCompra.autorizacionfacturaproveedor.$error.pattern">La Autorización no es válida.</span>
	       </div>
	       
	       <div class="col-xs-12">
	       			 <div class="input-group" >
			                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt "></i></span>	             			                
			                <select ng-disabled="impreso" class="form-control" name="codigosustento" id="codigosustento" ng-model="compra.codigosustento" ng-required="true" >
                               	<option value="">Sustento Tributario</option>
								<option ng-repeat="item in sustentotributario"						       
											 value="{{item.codigosustento}}">{{item.codigosustento}} - {{ item.nombresustento }}     
								</option> 
							</select>               
			           </div>	 
			          <span class="help-block error" ng-show="formCompra.codigosustento.$invalid && formCompra.codigosustento.$touched">El Sustento Tributario es requerido</span>                     
	       </div>
	       <div class="col-xs-12">
	       <div class="input-group" >
			    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt "></i></span>	             			                
			    <select ng-disabled="impreso" class="form-control" name="tipocomprobante" id="tipocomprobante" ng-model="compra.codigocomprbante" ng-required="true" >
                	<option value="">Tipo Comprobante</option>
					<option ng-repeat="item in tiposComprobante"						       
					        value="{{item.codigocomprbante}}">{{item.codigocomprbante}} - {{ item.nombretipocomprobante }}     
					</option> 
				</select>                 
		</div>	
		<span class="help-block error" ng-show="formCompra.tipocomprobante.$invalid && formCompra.tipocomprobante.$touched">El Tipo Comprobante es requerido</span>              
		</div>							
	       
</div>

					
					<div class="form-group col-xs-12">
						<label class="control-label">Detalle Compra</label>
					</div>
					<div class="form-group col-xs-12">
					
		                <button type="button" class="btn btn-primary" style="float: right;" ng-click="addDetalle()" ng-disabled="impreso">
		                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		                </button>
		           </div>
		           <div class="form-group col-xs-12">
					<table class="table table-responsive table-striped table-hover table-condensed">
                    <thead class="bg-primary">
                    <tr>
                        <th style="width: 15%;">Cod. Prod</th>
                         <th>Detalle</th>
                        <th style="width: 7%;">Cant.</th>                       
                        <th style="width: 10%;">PVP Unitario</th>
                        <th style="width: 7%;">Descuento</th>
                        <th style="width: 7%;">IVA</th>
                        <th style="width: 7%;">ICE</th>
                        <th style="width: 5%;">Total</th>
                        <th style="width: 5%;">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="item in detalle">
                    
                        <td>
		                 <div>
                                            <angucomplete-alt 
                                            	  id="codigoproducto{{$index}}"									            
									              pause="400"
									              selected-object="item.productoObj"									              
									              remote-url="{{url}}compras/getCodigoProducto/"
									              title-field="codigoproducto"
									              description-field="twitter"									              
									              minlength="1"
									              input-class="form-control form-control-small"
									              match-class="highlight"
									              field-required="true"
									              input-name="codigoproducto{{$index}}"
									              disable-input="impreso"
									              text-searching="Buscando Producto"
									              text-no-results="Producto no encontrado"
									              initial-value="item.producto"
									               />
                                            </div>
                                            <span class="help-block error"
                                                      ng-show="formCompra.codigoproducto{{$index}}.$invalid && formCompra.codigoproducto{{$index}}.$touched">El producto es requerido.</span>                                                                                   
						 </td>
                    </td>
                    <td>
                    		<label class="control-label" ng-show="!read">{{ item.productoObj.originalObject.nombreproducto }}</label> 
                    		<label class="control-label" ng-show="read">{{ item.producto.nombreproducto }}</label> 
                    </td>
                    <td>              
		               		<input type="text" class="form-control" name="cantidad{{$index}}" id="cantidad{{$index}}" ng-disabled="impreso"
		                      ng-model="item.cantidadtotal" ng-required="true" ng-maxlength="5" ng-pattern="/[0-9]+$/" ng-change="calcular()">
		                      <span class="help-block error"
									ng-show="formCompra.cantidad{{$index}}.$invalid && formCompra.cantidad{{$index}}.$touched">La Cantidad es requerida</span> 
									<span class="help-block error"
									ng-show="formCompra.cantidad{{$index}}.$invalid && formCompra.cantidad{{$index}}.$error.maxlength">La
									longitud máxima es de 5 números.</span> <span
									class="help-block error"
									ng-show="formCompra.cantidad{{$index}}.$invalid && formCompra.cantidad{{$index}}.$error.pattern">La Cantidad no es válida.</span>		                          
		            
                    </td>
                    
                    <td>
                    	<input type="text" class="form-control" name="unitario{{$index}}" id="unitario{{$index}}" ng-disabled="impreso"
		                      ng-model="item.precioUnitario" ng-required="true" ng-maxlength="8" ng-pattern="/^\d+(?:\.\d{1,2})?$/" ng-change="calcular()">
		                      <span class="help-block error"
									ng-show="formCompra.unitario{{$index}}.$invalid && formCompra.unitario{{$index}}.$touched">El Precio Unitario es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.unitario{{$index}}.$invalid && formCompra.unitario{{$index}}.$error.maxlength">La
									longitud máxima es de 7 números.</span> <span
									class="help-block error"
									ng-show="formCompra.unitario{{$index}}.$invalid && formCompra.unitario{{$index}}.$error.pattern">El Precio Unitario no es válido.</span>
                    </td>
                     <td>
                    	<input type="text" class="form-control" name="descuento{{$index}}" id="descuento{{$index}}" ng-disabled="impreso"
		                      ng-model="item.descuento" ng-required="true" ng-maxlength="5" ng-pattern="/^\d+(?:\.\d{1,2})?$/" ng-change="calcular()">
		                      <span class="help-block error"
									ng-show="formCompra.descuento{{$index}}.$invalid && formCompra.descuento{{$index}}.$touched">El IVA es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.descuento{{$index}}.$invalid && formCompra.descuento{{$index}}.$error.maxlength">La
									longitud máxima es de 4 números.</span> <span
									class="help-block error"
									ng-show="formCompra.descuento{{$index}}.$invalid && formCompra.descuento{{$index}}.$error.pattern">El IVA no es válido.</span>
                    </td>
                    <td>
                    	<input type="text" class="form-control" name="iva{{$index}}" id="iva{{$index}}" ng-disabled="impreso"
		                      ng-model="item.iva" ng-required="true" ng-maxlength="5" ng-pattern="/^\d+(?:\.\d{1,2})?$/" ng-change="calcular()">
		                      <span class="help-block error"
									ng-show="formCompra.iva{{$index}}.$invalid && formCompra.iva{{$index}}.$touched">El IVA es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.iva{{$index}}.$invalid && formCompra.iva{{$index}}.$error.maxlength">La
									longitud máxima es de 4 números.</span> <span
									class="help-block error"
									ng-show="formCompra.iva{{$index}}.$invalid && formCompra.iva{{$index}}.$error.pattern">El IVA no es válido.</span>
                    </td>
                    <td>
                    	<input type="text" class="form-control" name="ice{{$index}}" id="ice{{$index}}" ng-disabled="impreso"
		                      ng-model="item.ice" ng-required="true" ng-maxlength="5" ng-pattern="/^\d+(?:\.\d{1,2})?$/" ng-change="calcular()">
		                      <span class="help-block error"
									ng-show="formCompra.ice{{$index}}.$invalid && formCompra.ice{{$index}}.$touched">El ICE es requerido</span> 
									<span class="help-block error"
									ng-show="formCompra.ice{{$index}}.$invalid && formCompra.ice{{$index}}.$error.maxlength">La
									longitud máxima es de 4 números.</span> <span
									class="help-block error"
									ng-show="formCompra.ice{{$index}}.$invalid && formCompra.ice{{$index}}.$error.pattern">El ICE no es válido.</span>
                    </td>
                    <td><label class="control-label">{{ item.total }} </label></td>    
                    <td>
                    	<button type="button" class="btn btn-danger" ng-click="delDetalle($index)" ng-disabled="(detalle.length ==1)||impreso">
                               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </td>                
                    </tr>
                    </tbody>
                </table>
					</div>			
				
					<div class="form-group col-xs-12">
						
							<div class="col-md-6 col-xs-12">		
							<div class="col-xs-12">				
						       <div class="input-group" >
								    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-list-alt "></i></span>	             			                
								    <select class="form-control" name="idformapago" id="idformapago" ng-model="compra.idformapago" ng-required="true" ng-disabled="impreso"
						                                             ng-options="item.idformapago as item.nombreformapago for item in formaPagoDocumento">
																	  <option value="">Forma Pago</option>
																		</select>             
								</div>	
								<span class="help-block error"
							                                                      ng-show="formCompra.idformapago.$invalid && formCompra.idformapago.$touched">La Forma Pago es requerida</span>								
							
							</div>
								<div class="col-md-12" style="height: 265px;">						
								</div>

							<div class="col-md-12">	
	
							<button type="button" class="btn btn-primary" id="btn-save" ng-click="save()" ng-disabled="(formCompra.$invalid || impreso || anulado )">
	                            Guardar 
	                        </button>
	                        <button type="button" class="btn btn-primary" id="btn-anular" ng-click="showModalConfirm()" ng-disabled="(impreso || anulado)"  ng-show="false">
	                            Anular 
	                        </button>
	                        <button type="button" class="btn btn-primary" id="btn-retencion" ng-click="activarPestana()" ng-disabled="(!guardado||retencion || anulado)" ng-show="false">
	                            Retención 
	                        </button>	
	                        <button type="button" class="btn btn-primary" id="btn-pago" ng-click="pagarCompra()" ng-disabled="( pagado || anulado)" ng-show="false">
	                            Pagar 
	                        </button>	
	                        <button class="btn btn-success" ng-click="InicioList();"> Regresar</button>			
							</div>
						</div>
						
						
						<div class="col-md-6 col-xs-12">
						<div class="col-md-12">
						<div class="col-md-3">								
						</div>					
						<div class="col-md-6">
							<label > Subtotal Con Impuesto:</label>
						</div>
						<div class="col-md-3">
							<input type="text" ng-model="compra.subtotalivacompra" name="subtotal" id="subtotal" readonly="readonly" class="form-control">
						</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > Subtotal 0%:</label>
							</div>
							<div class="col-md-3">
							<input type="text" ng-model="compra.subtotalnoivacompra" name="subtotal0" id="subtotal0" readonly="readonly" class="form-control">
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > Subtotal no Objeto de IVA:</label>
							</div>
							<div class="col-md-3">
							<input type="text" ng-model="compra.subtotalnoobjetoiva" name="noobjeto" id=""noobjeto"" readonly="readonly" class="form-control">
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > Subtotal exento de IVA:</label>
							</div>
							<div class="col-md-3">
							<input type="text" ng-model="compra.subtotalexentoiva" name="excento" id=""excento"" readonly="readonly" class="form-control">
							</div>
						</div>
						
						
						<div class="col-md-12">
						<div class="col-md-3">
							</div>
							<div class="col-md-6">
						<label >Total  Descuento:</label>
						</div>
						<div class="col-md-3">
							<input type="text" ng-model="compra.descuentocompra" name="descuentoF" id="descuetnoF" readonly="readonly" class="form-control">
						</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > ICE:</label>
							</div>
							<div class="col-md-3">
								
								<input type="text" class="form-control" name="iceF" ng-model="compra.iceF"									
										id="iceF" ng-required="true"
										ng-maxlength="5"
										maxlength="5"
										ng-pattern="/^\d+(?:\.\d{1,2})?$/"
										ng-change="calcular()"
										ng-disabled="impreso"
										> 
										<span class="help-block error"
										ng-show="formCompra.otros.$invalid && formCompra.iceF.$touched">El Valor ICE es requerido.</span> 
										<span class="help-block error"
										ng-show="formCompra.otros.$invalid && formCompra.iceF.$error.maxlength">La
										longitud máxima es de 7 números.</span> <span
										class="help-block error"
										ng-show="formCompra.otros.$invalid && formCompra.iceF.$error.pattern">El Valor ICE no es válido.</span>
										
								
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > IVA:</label>
							</div>
							<div class="col-md-3">
								
								<input type="text" class="form-control" name="ivaF" ng-model="compra.oivaF"									
										id="ivaF" ng-required="true"
										ng-maxlength="5"
										maxlength="5"
										ng-pattern="/^\d+(?:\.\d{1,2})?$/"
										ng-change="calcular()"
										ng-disabled="impreso"
										> 
										<span class="help-block error"
										ng-show="formCompra.ivaF.$invalid && formCompra.ivaF.$touched">El Valor IVA es requerido.</span> 
										<span class="help-block error"
										ng-show="formCompra.ivaF.$invalid && formCompra.ivaF.$error.maxlength">La
										longitud máxima es de 7 números.</span> <span
										class="help-block error"
										ng-show="formCompra.ivaF.$invalid && formCompra.ivaF.$error.pattern">El Valor IVA no es válido.</span>
										
								
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > IRBPNR:</label>
							</div>
							<div class="col-md-3">
								
								<input type="text" class="form-control" name="irbpnr" ng-model="compra.irbpnr"									
										id="irbpnr" ng-required="true"
										ng-maxlength="5"
										maxlength="5"
										ng-pattern="/^\d+(?:\.\d{1,2})?$/"
										ng-change="calcular()"
										ng-disabled="impreso"
										> 
										<span class="help-block error"
										ng-show="formCompra.irbpnr.$invalid && formCompra.irbpnr.$touched">El Valor IRBPNR es requerido.</span> 
										<span class="help-block error"
										ng-show="formCompra.irbpnr.$invalid && formCompra.irbpnr.$error.maxlength">La
										longitud máxima es de 7 números.</span> <span
										class="help-block error"
										ng-show="formCompra.irbpnr.$invalid && formCompra.irbpnr.$error.pattern">El Valor IRBPNR no es válido.</span>
										
								
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="col-md-3">
							</div>
							<div class="col-md-6">
							<label > PROPINA:</label>
							</div>
							<div class="col-md-3">
								
								<input type="text" class="form-control" name="propina" ng-model="compra.propina"									
										id="propina" ng-required="true"
										ng-maxlength="5"
										maxlength="5"
										ng-pattern="/^\d+(?:\.\d{1,2})?$/"
										ng-change="calcular()"
										ng-disabled="impreso"
										> 
										<span class="help-block error"
										ng-show="formCompra.propina.$invalid && formCompra.iceF.$touched">El Valor PROPINA es requerido.</span> 
										<span class="help-block error"
										ng-show="formCompra.propina.$invalid && formCompra.iceF.$error.maxlength">La
										longitud máxima es de 7 números.</span> <span
										class="help-block error"
										ng-show="formCompra.propina.$invalid && formCompra.iceF.$error.pattern">El Valor PROPINA no es válido.</span>
										
								
							</div>
						</div>

						
						<div class="col-md-12">
						<div class="col-md-3">
							</div>
							<div class="col-md-6">
						<label > Total:</label>
						</div>
						<div class="col-md-3">
						<input type="text" ng-model="compra.totalcompra" name="total" id="total" readonly="readonly" class="form-control">
						</div>
						</div>
					</div>				
					</div>
					</form>
					</div>

				</div>
				
			</div>
		</div>
		
		

							
		
		
		
	<div class="modal fade" tabindex="-1" role="dialog" id="modalMessage1">
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
        
        <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmAnular1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <span>Está seguro que desea anular la compra?</span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btn-save" ng-click="anularCompra()">Anular</button>
                    </div>
                </div>
            </div>
        </div>	
		
	</div>


</div>