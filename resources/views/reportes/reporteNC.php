<!DOCTYPE html>
<html lang="es-ES" ng-app="softver-aqua">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Retencion Compras</title>

    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/angucomplete-alt.css') ?>" rel="stylesheet">

    <style>
        .dataclient{
            font-weight: bold;
        }
    </style>
</head>

<body>

<div ng-controller="reporteNCController">

    <div class="col-xs-12">

        <h4>Reporte de Notas de Créditos</h4>

        <hr>

    </div>

    <div class="col-xs-12" style="margin-top: 5px;">

        <div class="col-sm-6 col-xs-8">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="busqueda" placeholder="BUSCAR..." ng-model="busqueda" ng-keyup="initLoad()">
                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
            </div>
        </div>

        <div class="col-sm-3 col-xs-2">
            <div class="input-group">
                <span class="input-group-addon">Fecha Inicio:</span>
                <input type="text" class="datepicker form-control" name="fechainicio" id="fechainicio" ng-model="fechainicio" ng-blur="initLoad()">
            </div>
        </div>

        <div class="col-sm-3 col-xs-2">
            <div class="input-group">
                <span class="input-group-addon">Fecha Fin:</span>
                <input type="text" class="datepicker form-control" name="fechafin" id="fechafin" ng-model="fechafin" ng-blur="initLoad()">
            </div>
        </div>


        <div class="col-xs-12" style="font-size: 12px !important;">

            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th>NO.</th>
                        <th>CLIENTE</th>
                        <th style="width: 8%;">FECHA INGRESO</th>
                        <th style="width: 11%;">NO FACTURA</th>
                        <th style="width: 6%;">SUBTOTAL C/I</th>
                        <th style="width: 6%;">SUBTOTAL S/I</th>
                        <th style="width: 6%;">SUBTOTAL 0%</th>
                        <th style="width: 6%;">SUBTOTAL NO/OBJ</th>
                        <th style="width: 6%;">SUBTOTAL EXENTO</th>
                        <th style="width: 6%;">IVA</th>
                        <th style="width: 6%;">ICE</th>
                        <th style="width: 6%;">DESCUENTO</th>
                        <th style="width: 9%;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in list | filter : busqueda" ng-cloak">

                        <td>{{$index + 1}}</td>
                        <td>{{item.razonsocial}}</td>
                        <td class="text-center">{{item.fecharegistroncf}}</td>
                        <td class="text-center">{{item.numdocumentonotacredit}}</td>
                        <td class="text-right">$ {{item.subtotalconimpuestoncf}}</td>
                        <td class="text-right">$ {{item.subtotalsinimpuestoncf}}</td>
                        <td class="text-right">$ {{item.subtotalceroncf}}</td>
                        <td class="text-right">$ {{item.subtotalnoobjivancf}}</td>
                        <td class="text-right">$ {{item.subtotalexentivancf}}</td>
                        <td class="text-right">$ {{item.ivancf}}</td>
                        <td class="text-right">$ {{item.icencf}}</td>
                        <td class="text-right">$ {{item.totaldescuento}}</td>
                        <td class="text-right" style="font-weight: bold;">$ {{item.valortotalncf}}</td>

                    </tr>
                </tbody>
                <tfoot class="bg-primary">
                    <tr>
                        <th colspan="4" class="text-right">TOTALES</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalsubconimp}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalsubsinimp}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalsubcero}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalsubnoobj}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalsubex}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totaliva}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totalice}}</th>
                        <th class="text-right btn-warning" style="color: #000;">{{totaldesc}}</th>
                        <th class="text-right btn-danger" style="font-weight: bold;">{{total}}</th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

</div>

</body>

<script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/dirPagination.js') ?>"></script>
<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('js/menuLateral.js') ?>"></script>
<script src="<?= asset('js/moment.min.js') ?>"></script>
<script src="<?= asset('js/es.js') ?>"></script>
<script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>

<script src="<?= asset('app/lib/angular/ng-file-upload-shim.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/ng-file-upload.min.js') ?>"></script>

<script src="<?= asset('app/lib/angular/angucomplete-alt.min.js') ?>"></script>
<script src="<?= asset('app/app.js') ?>"></script>

<script src="<?= asset('app/controllers/reporteNCController.js') ?>"></script>
</html>

