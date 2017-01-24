<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva Guía de remisión</title>

	<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
	
	<div ng-controller="guiaremisionController">
		<div class="col-xs-12">
			<fieldset>
				<legend>Datos Guía de Remisión</legend>

				<div class="col-sm-6 col-xs-12">
					<div class="input-group">
		                <span class="input-group-addon">Nro. Guía de Remisión: </span>
		                <span class="input-group-btn" style="width: 15%;">
		                    <input type="text" class="form-control" id="t_establ" name="t_establ" />
		                </span>
		                <span class="input-group-btn" style="width: 15%;" >
		                    <input type="text" class="form-control" id="t_pto" name="t_pto" />
		                </span>
		                <input type="text" class="form-control" id="t_secuencial" name="t_secuencial" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12">
					<div class="input-group">                        
		                <span class="input-group-addon">Punto Partida: </span>
		                <input type="text" class="form-control" />
		            </div> 
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Identificación Transportista: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Transportista: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Nro. Placa: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Ruta: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>	

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Fecha Inicio Transporte: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Fecha Fin Transporte: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Motivo Traslado: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Código Establecimiento: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Documento Aduanero: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

			</fieldset>


			<fieldset>
				<legend>Datos Factura</legend>

				<div class="col-sm-6 col-xs-12">
					<div class="input-group">                        
		                <span class="input-group-addon">Identificación Destinatario: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12">
					<div class="input-group">                        
		                <span class="input-group-addon">Razón Social Destinatario: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Nro Documento Venta: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Nro Autorización Venta: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Fecha Venta: </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

				<div class="col-sm-6 col-xs-12" style="margin-top: 5px;">
					<div class="input-group">                        
		                <span class="input-group-addon">Destino (Pto Llegada): </span>
		                <input type="text" class="form-control" />
		            </div>
				</div>

			</fieldset>

			<fieldset>
				<legend>Datos Productos Factura Venta</legend>

				<div class="col-xs-12">
					<table class="table table-responsive table-striped table-hover table-condensed">
						<thead class="bg-primary">
							<tr>
								<td>Nro.</td>
								<td>Linea</td>
								<td>Código</td>
								<td>Detalle</td>
								<td>Cantidad</td>							
							</tr>
						</thead>
						<tbody>
							<tr dir-paginate="item in mercaderia | orderBy:sortKey:reverse | itemsPerPage:10 | filter : t_busqueda" ng-cloak>
								<td>{{mercaderia.cont_itemventa.iditemventa}}<br></td>
								<td>{{mercaderia.cont_categoria.nombrecategoria}}</td>
								<td>{{mercaderia.cont_catalogitem.codigoproducto}}</td>
								<td>{{mercaderia.cont_catalogitem.nombreproducto}}</td>
								<td>{{mercaderia.cont_itemventa.cantidad}}</td>
							</tr>
							<tr>
								<td><br></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<dir-pagination-controls
		               	max-size="5"
		               	direction-links="true"
		               	boundary-links="true" >
		            </dir-pagination-controls>
				</div>

			</fieldset>

			<fieldset>
				<legend>Datos Disposición Mercancía</legend>
				
				<div class="col-xs-12 text-right">
					<button type="button" class="btn btn-primary">
		                <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> 
		            </button>
				</div>

				<div class="col-xs-12" style="margin-top: 5px;">
					<table class="table table-responsive table-striped table-hover table-condensed">
						<thead class="bg-primary">
							<tr>
								<td>Cantidad</td>
								<td>Tipo Empaque</td>
								<td>Peso(kg)</td>
								<td>Largo(cm)</td>
								<td>Ancho(cm)</td>
								<td>Altura(kg)</td>
								<td>P. Volumetrico(cm)</td>
								<td>Descripcion</td>							
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
								<td><input type="text" class="form-control" /></td>
							</tr>
						</tbody>
					</table>
				</div>

			</fieldset>


			
			



			<div class="col-xs-12 text-right" style="margin-top: 10px;">
				<button type="button" class="btn btn-default">
	                Cancelar <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span> 
	            </button>
				<button type="button" class="btn btn-success">
	                Guardar <span class="glyphicon glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> 
	            </button>
			</div>

		</div>
	</div>


		

</body>
</html>