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

  <div class="container-fluid" ng-controller="Contabilidad" ng-cloak>
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
                        <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href="#" ng-click="GenereraFiltroPlanCuentas();" ><i class="glyphicon glyphicon-cog"></i> Generar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" ng-click="AgregarCuentaMadre();" ><i class="glyphicon glyphicon-plus"></i> Crear Cuenta Madre </a></li>
                          </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr class="bg-primary">
                                    <th colspan="5"></th>
                                </tr>
                                <tr class="bg-primary">
                                    <th style="width: 20%;"></th>
                                    <th ></th>
                                    <th style="width: 50%;">Detalle</th>
                                    <th style="width: 10%;">Codigo SRI</th>
                                    <!--<th>Balance</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="cuenta in CuentasContables" >
                                    <td>
                                        <button class="btn btn-primary btn-sm" ng-click="AgregarCuentahija(cuenta);"><i class="glyphicon glyphicon glyphicon-plus"></i></button>
                                        <button class="btn btn-warning btn-sm" ng-click="ModificarCuentaC(cuenta);"><i class="glyphicon glyphicon glyphicon-edit"></i></button>
                                        <button class="btn btn-danger btn-sm"  ng-click="BorrarCuentaC(cuenta);"><i class="glyphicon glyphicon glyphicon-trash"></i></button>
                                    </td>
                                    <td>{{cuenta.jerarquia}}</td>
                                    <td>{{cuenta.concepto}}</td>
                                    <td>{{cuenta.codigosri}}</td>
                                    <!--<td></td>-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!--Registro-->
            <div class="col-xs-6">
            <br/><br/><br/>
              <div class="row">
                <div class="col-xs-1">
                  <button class="btn btn-primary" ng-click="AddAsientoContable();">Agregar  Asiento contable <i class="glyphicon glyphicon-plus"></i></button>
                </div>
              </div>
            </div>
    </div>





<div class="modal fade" id="AddCCMadre" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Cuenta Madre</h4>
      </div>
      <div class="modal-body">
    
            <div class="row">
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Concepto: </span>
                      <input type="type" class="form-control   input-sm"  ng-model="ConceptoCCM" >
                      
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Codigo SRI: </span>
                      <input type="type" class="form-control   input-sm" ng-model="CodigoSRICCM">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Tipo Estado Financiero: </span>
                      <select class="form-control input-sm" ng-model="TipoestadoF">
                          <option value="E">Estado De Resultados</option>
                          <option value="B">Balance</option>
                      </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Tipo De Cueta: </span>
                      <select class="form-control input-sm" ng-model="TipoCuenta">
                          <option value="">Seleccione</option>
                          <option ng-show="TipoestadoF=='B'" ng-hide="TipoestadoF=='E'" value="A">Activos</option>
                          <option ng-show="TipoestadoF=='B'" ng-hide="TipoestadoF=='E'" value="P">Pasivos</option>
                          <option ng-show="TipoestadoF=='B'" ng-hide="TipoestadoF=='E'" value="PT">Patrimonio</option>
                          <option ng-show="TipoestadoF=='E'" ng-hide="TipoestadoF=='B'" value="I">Ingresos</option>
                          <option ng-show="TipoestadoF=='E'" ng-hide="TipoestadoF=='B'"value="C">Costos</option>
                          <option ng-show="TipoestadoF=='E'" ng-hide="TipoestadoF=='B'" value="C">Gastos</option>
                      </select>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-success" ng-click="GuardarCCMadre();">Guardar <i class="glyphicon glyphicon glyphicon-floppy-saved"></i></button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="AddCCNodo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Cuenta Contable</h4>
      </div>
      <div class="modal-body">
    
            <div class="row">
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Concepto: </span>
                      <input type="type" class="form-control   input-sm"  ng-model="ConceptoCCM" >
                      
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Codigo SRI: </span>
                      <input type="type" class="form-control   input-sm" ng-model="CodigoSRICCM">
                    </div>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-success" ng-click="GuardarCCNodo();">Guardar <i class="glyphicon glyphicon glyphicon-floppy-saved"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModifyCCNodo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modificar Cuenta Contable</h4>
      </div>
      <div class="modal-body">
    
            <div class="row">
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Concepto: </span>
                      <input type="type" class="form-control   input-sm"  ng-model="ConceptoCCM" >
                      
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                      <span class="input-group-addon">Codigo SRI: </span>
                      <input type="type" class="form-control   input-sm" ng-model="CodigoSRICCM">
                    </div>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-success" ng-click="GuardarModificacionNodo();">Guardar <i class="glyphicon glyphicon glyphicon-floppy-saved"></i></button>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="msm" style="z-index: 8000;" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary" id="titulomsm">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Mensaje</h4>
      </div>
      <div class="modal-body">
        <strong>{{Mensaje}}</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="msmBorarCC" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header btn-danger" id="titulomsm">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Mensaje de confirmacion</h4>
      </div>
      <div class="modal-body">
        <strong>Esta seguro de borrar</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-primary" ng-click="okBorrarCuenta();" >Aceptar <i class="glyphicon glyphicon glyphicon-ok"></i></button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="PlanContable" style="z-index: 5000;" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header btn-primary" id="titulomsm">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Plan de cuentas contables</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr class="btn-primary">
                  <th></th>
                  <th>Descripción</th>
                  <th>Codigo SRI</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="cuenta in aux_plancuentas">
                  <td>{{cuenta.jerarquia}}</td>
                  <td>{{cuenta.concepto}}</td>
                  <td>{{cuenta.codigosri}}</td>
                  <td>
                      <input ng-show="cuenta.madreohija=='1' " ng-hide="cuenta.madreohija!='1' " type="checkbox" name="" ng-click="AsignarCuentaContable(cuenta);">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-primary" ng-click="AsignarCuentaContable();" >Aceptar <i class="glyphicon glyphicon glyphicon-ok"></i></button>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="AddAsc" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Agregar Asiento Contable</h4>
      </div>
      <div class="modal-body">
      
      <div class="row">
        <div class="col-xs-4">
          <div class="input-group">
            <span class="input-group-addon">Fecha : </span>
            <input type="type" class="form-control datepicker  input-sm" id="FechaIASC" ng-model="FechaIASC">
          </div>
        </div>
        <div class="col-xs-6">
          <div class="input-group">
            <span class="input-group-addon">Transacción: </span>
            <select class="form-control" ng-model="tipotransaccion">
              <option value="">Seleccione</option>
              <option ng-repeat=" transaccion in listatipotransaccion" ng-value="transaccion.idtipotransaccion">{{transaccion.descripcion +" "+ transaccion.cont_tipoingresoegreso.descripcion}}</option>
            </select>
          </div>
        </div>


      </div>

      <div class="row">
        <div class="col-xs-4">
          <div class="input-group">
            <span class="input-group-addon">Numero De comprobante: </span>
            <input type="number" class="form-control   input-sm"  ng-model="NumeroIASC">
          </div>
        </div>

        <div class="col-xs-6">
          <div class="input-group">
            <span class="input-group-addon">Descripción: </span>
            <input type="type" class="form-control   input-sm"  ng-model="DescripcionASC">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-4">
          <button ng-click="AddIntemCotable()" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></button>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <table class="table table-bordered table-condensed">
            <thead>
              <tr class="bg-primary">
                <th></th>
                <th>Cuenta</th>
                <th>Debe</th>
                <th>Haber</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="registro in RegistroC">
                <td>
                  <button class="btn btn-danger" ng-click="BorrarFilaAsientoContable(registro);"><i class="glyphicon glyphicon-trash"></i></button>
                </td>
                <td>
                  <div class="input-group">
                    <input type="hidden" class="form-control datepicker  input-sm"  ng-model="registro.idplancuenta">
                    <input type="hidden" class="form-control datepicker  input-sm"  ng-model="registro.tipocuenta">
                    <input type="hidden" class="form-control datepicker  input-sm"  ng-model="registro.controlhaber">
                    <input type="type" class="form-control datepicker  input-sm"  ng-model="registro.concepto" readonly>
                    <span ng-click="BuscarCuentaContable(registro);" class="btn btn-info input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                  </div>
                </td>
                <td>
                    <input type="type" class="form-control datepicker  input-sm"  ng-model="registro.Debe" ng-keyup="SumarDebeHaber();">
                </td>
                <td>
                    <input type="type" class="form-control datepicker  input-sm"  ng-model="registro.Haber" ng-keyup="SumarDebeHaber();">
                </td>
                <td>
                    <input type="type" class="form-control datepicker  input-sm"  ng-model="registro.Descipcion">
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right"> Total: </th>
                <th>{{aux_sumdebe}}</th>
                <th>{{aux_sumhaber}}</th>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
        <button type="button" class="btn btn-success" ng-click="AsientoContable();">Guardar <i class="glyphicon glyphicon glyphicon-floppy-saved"></i></button>
      </div>
    </div>
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