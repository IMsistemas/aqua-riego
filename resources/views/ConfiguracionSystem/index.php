<!doctype html>
<html lang="es-ES" ng-app="softver-aqua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Configuracion</title>

    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/index.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/angucomplete-alt.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/style_generic_app.css') ?>" rel="stylesheet">

</head>

<body>
    <div ng-controller="configuracionsystemController">

        <div class="container-fluid">
            <div id="dvTab" style="margin-top: 5px;">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active tabs"><a href="#empresa" aria-controls="empresa" role="tab" data-toggle="tab"> Empresa</a></li>
                    <li role="presentation" class="tabs"><a href="#contabilidad" aria-controls="contabilidad" role="tab" data-toggle="tab"> Contabilidad</a></li>
                    <li role="presentation" class="tabs"><a href="#sri" aria-controls="sri" role="tab" data-toggle="tab"> SRI</a></li>
                    <li role="presentation" class="tabs"><a href="#especifica" aria-controls="especifica" role="tab" data-toggle="tab"> Especificas</a></li>
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade active in" id="empresa" style="padding-top: 10px;">

                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="contabilidad">

                        <div id="dvTab2" style="margin-top: 5px;">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active tabs"><a href="#cont_general" aria-controls="cont_general" role="tab" data-toggle="tab"><i class="fa fa-info-circle" style="font-size: 20px !important;"></i> General</a></li>
                                <li role="presentation" class="tabs"><a href="#cont_compras" aria-controls="cont_compras" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Compra</a></li>
                                <li role="presentation" class="tabs"><a href="#cont_venta" aria-controls="cont_venta" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Ventas</a></li>
                                <li role="presentation" class="tabs"><a href="#cont_notacredit" aria-controls="cont_notacredit" role="tab" data-toggle="tab"><i class="fa fa-user" style="font-size: 20px !important;"></i> Notas de Credito</a></li>
                            </ul>
                            <!-- Tab panels -->
                            <div class="tab-content" style="padding-top: 10px;">
                                <div role="tabpanel" class="tab-pane fade active in" id="cont_general">
                                        a
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="cont_compras">
                                        b
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="cont_venta">
                                        c
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="cont_notacredit">
                                        d
                                </div>

                            </div>
                        </div>

                    </div>



                    <div role="tabpanel" class="tab-pane fade" id="sri" style="padding-top: 10px;">

                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="especifica" style="padding-top: 10px;">

                    </div>


                </div>
            </div>
        </div>

    </div>
</body>


<script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>


<script src="<?= asset('app/lib/angular/ng-file-upload-shim.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/ng-file-upload.min.js') ?>"></script>


<script src="<?= asset('js/jquery.min.js') ?>"></script>
<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('js/moment.min.js') ?>"></script>
<script src="<?= asset('js/es.js') ?>"></script>
<script src="<?= asset('js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/angucomplete-alt.min.js') ?>"></script>
<script src="<?= asset('app/lib/angular/dirPagination.js') ?>"></script>

<script src="<?= asset('app/app.js') ?>"></script>
<script src="<?= asset('app/controllers/transportistaController.js') ?>"></script>


</html>












