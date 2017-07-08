<div ng-controller="recaudacionController">

	<div class="col-xs-12" style="margin-top: 2%;">

		<div class="col-xs-6">
			<div class="form-group has-feedback">
				<input type="text" class="form-control input-sm" id="search-list-trans" placeholder="BUSCAR..." ng-model="busqueda">
	             <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
	         </div>
		</div>

		<form class="form-inline">

			<button type="button" id="btnNuevaSol" class="btn btn-primary" style="float: right;" ng-click="generate();" ng-hide="estaVacio">Generar</button>

			<div class="form-group">
				<label for="comboYear">Año</label>
				<select class="form-control" id="comboYear" ng-model="yearSeleccionado" >
				<option value="">Seleccione año</option>
					<option ng-repeat="cuenta in cuentas" value="" >{{cuenta.fechaperiodo | date:'yyyy'}}</option>
				</select>
			</div>
			<div class="form-group">
				<label for="comboMes">Mes</label>
				<select class="form-control" id="comboMes" ng-model="mesSeleccionado" >
					<option value="">Seleccione mes</option>
				    <option ng-repeat="cuenta in cuentas" value="" >{{cuenta.fechaperiodo | date:'MMM'}}</option>
				</select>
			</div>


		</form>

		<div class="col-xs-12">
			<table class="table table-responsive table-striped table-hover table-condensed">
				<thead class="bg-primary">
					<tr>
                        <th style="width: 5%;" >PERIODO</th>
                        <th>CLIENTE</th>
                        <th style="width: 10%;" >TARIFA</th>
                        <th style="width: 10%;" >JUNTA</th>
                        <th style="width: 10%;" >CANAL</th>
                        <th style="width: 10%;" >TOMA</th>
                        <th style="width: 5%;" >ESTADO</th>
                        <th style="width: 5%;" >TOTAL</th>
						<th style="width: 15%;" >ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="cuenta in cuentas | filter: busqueda | orderBy:columna:reversa" >
						<td>{{cuenta.fechapago | date:'MMM yyyy'}}</td>
						<td>{{cuenta.razonsocial}}</td>
						<td>{{cuenta.nombretarifa}}</td>
						<td>{{cuenta.namebarrio}}</td>
						<td>{{cuenta.nombrecanal}}</td>
						<td>{{cuenta.namecalle}}</td>
						<td>{{cuenta.estapagada}}</td>
						<td>{{cuenta.total | currency}}</td>
						<td>

						</td>
					</tr>
				</tbody>
			</table>
		</div>


    </div>

    <!-- ==============================================MODALES=========================================================================== -->

    <!-- ==============================================MODAL INGRESO ==================================================================== -->

    <div class="modal fade" id="ingresarValores" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nueva cuenta</h4>
                    Período: {{cuenta.fechaperiodo | date:'MMM yyyy'}}
                </div>

                <div class="modal-body">
                    <form name="formularioOtrosRubros" class="form-horizonal" novalidate="">
                        <fieldset>
                            <legend>Datos suministro</legend>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">No. suministro: </span>{{cuenta.suministro.numerosuministro}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Cliente: </span>{{cuenta.suministro.cliente.apellido+" "+suministro.cliente.nombre}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Barrio: </span>{{cuenta.suministro.calle.barrio.nombrebarrio}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Dirección: </span>{{cuenta.suministro.direccionsuministro}}
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Rubros</legend>
                        </fieldset>
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary">
                            <tr>
                                <th>Rubro</th>
                                <th>Valor</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-info">
                                <td><b>Valores Mes</b></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Consumo mes</td>
                                <td>{{cuenta.valorconsumo}}</td>
                            </tr>
                            <tr>
                                <td>Excedente Mes</td>
                                <td>{{cuenta.valorexcedente}}</td>
                            </tr>

                            <tr>
                                <td>Valores atrasados</td>
                                <td>{{cuenta.valormesesatrasados}}</td>
                            </tr>
                            <tr class="bg-info">
                                <td class="bg-info"><b>Otros valores</b></td>
                                <td></td>
                            </tr>

                            <tr ng-repeat="rubroVariableCuenta in rubrosVariablesCuenta track by $index">
                                <td>{{rubroVariableCuenta.nombrerubrovariable}}</td>
                                <td><input type="text" id="{{rubroVariableCuenta.nombrerubrovariable}}" class="form-control rubrosVariables" ng-model="rubroVariableCuenta.pivot.costorubro" ng-value="rubroVariableCuenta.costorubro | currency"></td>
                            </tr>
                            <tr ng-repeat="rubroFijoCuenta in rubrosFijosCuenta">
                                <td>{{rubroFijoCuenta.nombrerubrofijo}}</td>
                                <td><input type="text" id="{{rubroFijoCuenta.nombrerubrofijo}}" class="form-control rubrosFijos" ng-model="rubroFijoCuenta.pivot.costorubro " ng-value="rubroFijoCuenta.costorubro | currency"></td>
                            </tr>
                            <tr>
                                <td><b>Total</b></td>
                                <td>{{totalCuenta | currency}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="guardarOtrosRubros(cuenta.idcuenta);">Guardar</button>
                    <button class="btn btn-success" ng-hide="cuenta.estapagada" ng-click="pagarFactura(cuenta.idcuenta);">
                        Pagar</button>
                    <button class="btn btn-success" ng-show="cuenta.estapagada" ><i class="fa fa-print" aria-hidden="true" ng-click="generarPDF(cuenta.numerocuenta);"></i>Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==============================================MODAL CONFIRMACION ==================================================================== -->


    <div class="modal fade" tabindex="-1" role="dialog" id="modalConfirmacion">
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


    <!-- ==============================================MODAL ERROR ==================================================================== -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalError">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Error</h4>
                </div>
                <div class="modal-body">
                    <span>{{messageError}}</span>
                </div>
            </div>
        </div>
    </div>



</div>

<!-- <div class="modal fade" tabindex="-1" role="dialog" id="modalInfoCuenta">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-info">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Periodo: {{cuenta.fechaperiodo | date:'MMM yyyy'}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 text-center">
                            <img class="img-thumbnail" src="" alt="">
                        </div>
                        <div class="row text-center">
                            <div class="col-xs-12 text-center" style="font-size: 18px;">{{cuenta.suministro.cliente.apellido+" "+cuenta.suministro.cliente.nombre}}</div>
                            <div class="col-xs-12 text-center" style="font-size: 16px;">{{}}</div>

                            <div class="col-xs-12">
                                <span style="font-weight: bold">No. suministro:</span>{{cuenta.suministro.numerosuministro}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">m<sup>3</sup> consumidos: </span>{{}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">m<sup>3</sup> excedidos: </span>{{}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Meses atrasados: </span>{{}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Otros valores: </span>{{}}
                            </div>
                            <div class="col-xs-12">
                                <span style="font-weight: bold">Total Consumo: </span>{{cuenta.total}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


	</div> -->

