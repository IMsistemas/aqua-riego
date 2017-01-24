<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Guía de Remisión </title>

	<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>	

	<div ng-controller="guiaremisionController">
		<div class="col-sm-4 col-xs-6">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                           ng-model="search" ng-change="searchByFilter()">
                    <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                </div>
        </div>
        <div class="col-sm-8 col-xs-6">
                <button type="button" class="btn btn-primary" style="float: right;" ng-click="openForm(0)">
                   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
        </div>

		<div class="col-xs-12" style="margin-top: 5px;">
			<table class="table table-responsive table-striped table-hover table-condensed">
				<thead class="bg-primary">
					<tr>
						<td>Nro.</td>
						<td>Cliente</td>
						<td>Nro. Guia de Remision</td>
						<td>Nro. Factura Venta</td>
						<td>Accion</td>							
					</tr>
				</thead>
				<tbody>
					<tr dir-paginate="item in guiaremision | orderBy:sortKey:reverse | itemsPerPage:10 | filter : search" ng-cloak>
						<td>{{item.cont_guiaremision.idguiremision}}</td>
						<td>{{item.cont_cliente.lastname+" "+item.cliente.name}}</td>
						<td>{{item.cont_guiaremision.nrodocumentoguiaremision}}</td>
						<td>{{item.cont_documentoventa.numeroautorizacionventa}}</td>
						<td>
							<button type="button" class="btn btn-warning">
				                <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span> 
				            </button>
				            <button type="button" class="btn btn-danger">
				                <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span> 
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

</body>
</html>