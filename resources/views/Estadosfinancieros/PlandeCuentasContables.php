<!DOCTYPE html>
<html ng-app="softver-aqua">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>Contabilidad</title>

    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/angucomplete-alt.css') ?>" rel="stylesheet">
</head>
<body>

	<div class="container-fluid" ng-controller="Contabilidad">
		<div class="row">
			<div class="col-xs-6">
                <h3><strong>Plan de cuentas</strong></h3>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="input-group">
                          <span class="input-group-addon">Generar: </span>
                          <select class="form-control input-sm" ng-model="GenerarPlanCuentasTipo">
                              <option value="E">Estado De Resultado</option>
                              <option value="B">Balance</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-xs-3" ng-show=" GenerarPlanCuentasTipo=='E' " ng-hide="GenerarPlanCuentasTipo=='B' ">
                        <div class="input-group">
                          <span class="input-group-addon">Fecha I.: </span>
                          <input type="type" class="form-control datepicker  input-sm" id="FechaI" ng-model="FechaI">
                        </div>
                    </div>
                    <div class="col-xs-3" ng-show=" GenerarPlanCuentasTipo=='E' ||  GenerarPlanCuentasTipo=='B' " >
                        <div class="input-group">
                          <span class="input-group-addon">Fecha F.: </span>
                          <input type="type" class="form-control datepicker  input-sm" id="FechaF" ng-model="FechaF">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <button class="btn btn-primary btn-sm" ng-click="GenereraFiltroPlanCuentas();" >Generar <i class="glyphicon glyphicon-cog"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="4"></th>
                                </tr>
                                <tr class="bg-primary">
                                    <th></th>
                                    <th>Detalle</th>
                                    <th>Codigo SRI</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!--Registro-->
            <div class="col-xs-6">
            </div>
		</div>
	</div>


    <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>

    <script src="<?= asset('app/lib/angular/ng-file-upload-shim.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/ng-file-upload.min.js') ?>"></script>

    <script src="<?= asset('app/lib/angular/dirPagination.js') ?>"></script>

    <script src="<?= asset('js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset('js/menuLateral.js') ?>"></script>
    <script src="<?= asset('js/moment.min.js') ?>"></script>
    <script src="<?= asset('js/es.js') ?>"></script>
    <script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= asset('app/lib/angular/angucomplete-alt.min.js') ?>"></script>


    <script src="<?= asset('app/app.js') ?>"></script>
    <script src="<?= asset('app/controllers/EstadosFinancieros.js') ?>"></script>
</body>
</html>