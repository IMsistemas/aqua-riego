<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aqua Riego-Solicitud</title>

        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

    </head>
    <body>

        <div class="col-xs-12" ng-controller="solicitudController" style="margin-top: 2%;">
            <div class="col-xs-12">
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="search" placeholder="BUSCAR..."
                               ng-model="search" ng-change="">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="t_estado" class="col-sm-4 control-label">Estado:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="t_estado" id="t_estado" ng-model="t_estado"> </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button type="button" class="btn btn-primary" ng-click="toggle('add', 0)">
                        Nuevo <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <div class="col-xs-12">
                <table class="table table-responsive table-striped table-hover table-condensed">
                    <thead class="bg-primary">
                        <tr>
                            <th>Nro. Solicitud</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="solicitud in solicitudes" ng-cloak>
                            <td>{{solicitud.idsolicitud}}</td>
                            <td>{{solicitud.fechasolicitud}}</td>
                            <td>{{solicitud.apellido + ' ' + solicitud.nombre}}</td>
                            <td>{{solicitud.direcciondomicilio}}</td>
                            <td>{{solicitud.telefonoprincipaldomicilio}}</td>
                            <td>{{solicitud.estaprocesada}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </body>

    <script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
    <script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
    <script src="<?= asset('js/jquery.min.js') ?>"></script>
    <script src="<?= asset('js/bootstrap.min.js') ?>"></script>

    <script src="<?= asset('js/moment.min.js') ?>"></script>
    <script src="<?= asset('js/es.js') ?>"></script>
    <script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

    <script src="<?= asset('app/app.js') ?>"></script>
    <script src="<?= asset('app/controllers/solicitudController.js') ?>"></script>

</html>