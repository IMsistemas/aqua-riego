<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Aqua Riego-Tarifas</title>

        <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
        <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

        <style>
            td{
                vertical-align: middle !important;
            }

            .datepicker{
                color: #000 !important;
            }
        </style>

    </head>
    <body>

        <div class="col-xs-12" ng-controller="tarifaController" style="margin-top: 2%;">

        <div class="col-xs-12">
            <div class="col-sm-2 col-xs-12">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Año:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" name="s_anno" id="s_anno" ng-model="s_anno" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="t_tarifa" class="col-sm-4 control-label"><span style="float: right;">Tipo:</span></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="t_tarifa" id="t_tarifa"
                                ng-model="t_tarifa" ng-options="value.id as value.name for value in tarifas"
                                ng-change=""> </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12" style="margin-top: 10px;">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                    <tr>
                        <th colspan="2" class="text-center">AREA</th>
                        <th colspan="2" class="text-center">LITROS X SEGUNDO</th>
                        <th>USD</th>
                        <th colspan="2" class="text-center">
                            <button type="button" class="btn btn-info" id="btn_inform" ng-click="">
                                Generar Tarifa <i class="fa fa-cogs fa-lg" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-info" id="btn_edit" ng-click="" >
                                Nueva <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 15%;">Desde</th>
                        <th style="width: 15%;">Hasta</th>
                        <th style="width: 15%;">Desde</th>
                        <th style="width: 15%;">Hasta</th>
                        <th style="width: 15%;">x Litro</th>
                        <th>Observaciones</th>
                        <th style="width: 5%;">Fija</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control"></td>
                        <td><textarea rows="2" class="form-control"></textarea></td>
                        <td><input type="checkbox" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="form-control"></td>
                        <td><input type="text" class="form-control"></td>
                        <td></td>
                        <td></td>
                        <td><input type="text" class="form-control"></td>
                        <td><textarea rows="2" class="form-control"></textarea></td>
                        <td><input type="checkbox" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 text-right" style="margin-top: 10px">
            <button type="button" class="btn btn-success" id="btn-save" ng-click="">
                Guardar <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span>
            </button>
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
    <script src="<?= asset('app/controllers/tarifaController.js') ?>"></script>

</html>