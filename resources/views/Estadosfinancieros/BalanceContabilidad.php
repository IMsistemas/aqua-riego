

	<div class="container-fluid" ng-controller="ReportBalanceContabilidad" ng-init="" ng-cloak>

        <div class="col-xs-12">

            <h4>Estados Financieros</h4>

            <hr>

        </div>

        <div class="row" style="margin-bottom: 10px;">

          <div class="col-md-3 col-xs-4">
            <div class="input-group">
                <span class="input-group-addon">Generar: </span>
                <select class="form-control" name="cmb_generar" id="cmb_generar" ng-model="cmb_generar">
                  <option value="1" >Estados Cambios Patrimonio</option>
                  <!--<option value="2" >Estados Situación Financiera</option>-->
                  <option value="2" >Estados De Resultados</option>
                  <!--<option value="5" >Balance General</option>-->
                  <option value="5" >Estados Situación Financiera</option>
                  <option value="3" >Libro Diario</option>
                  <option value="4" >Libro Mayor</option>
                  <option value="6" >Balance De Comprobación</option>
                </select>
            </div>
          </div>

          <div class="col-md-2 col-xs-3">
            <div class="input-group">
                <span class="input-group-addon">Fecha Inicio: </span>
                <input type="text" class="form-control datepicker" name="txt_fechaI" id="txt_fechaI" ng-model="txt_fechaI" />
            </div>
          </div>

          <div class="col-md-2 col-xs-3">
            <div class="input-group">
                <span class="input-group-addon">Fecha Fin: </span>
                <input type="text" class="form-control datepicker" name="txt_fechaF" id="txt_fechaF" ng-model="txt_fechaF" />
            </div>
          </div>

          <div class="col-md-2 col-xs-3">
            <div class="input-group">
                <span class="input-group-addon">Estado: </span>
                <select class="form-control" name="cmb_estado" id="cmb_estado" ng-model="cmb_estado">
                  <option value="1">Activas</option>
                  <option value="2">Anuladas</option>
                  <option value="3">Todas</option>
                </select>
            </div>
          </div>



          <div class="col-md-2 col-xs-3">
              <div class="btn-group" role="group" aria-label="...">
                  <button id="btn_generar" ng-click="genera_report();" class="btn btn-primary">
                      Generar <i class="glyphicon glyphicon glyphicon-cog"></i>
                  </button>
                  <button type="button" class="btn btn-info" ng-click="print_report();">
                      Imprimir <span class="glyphicon glyphicon glyphicon-print" aria-hidden="true"></span>
                  </button>
              </div>

          </div>

        </div>

        <!--Libro diario-->
        <div class="row" ng-hide="aux_render!='3' " ng-show=" aux_render=='3'">
          <div class="col-md-12 col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered" ng-repeat="libro in libro_diario">
              <thead class="bg-primary">
                <tr>
                  <!--<th colspan="9" class="text-center" >{{titulo_head_report}}</th>-->
                  <th colspan="6" class="text-center" >{{titulo_head_report}}</th>
                </tr>
                <tr>
                  <th>TIPO : {{libro.cont_tipotransaccion.descripcion+" ("+libro.cont_tipotransaccion.siglas+") "}}</th>
                  <th colspan="4" class="text-center">ASIENTO NO.: {{libro.idtransaccion}}</th>
                  <th>FECHA: {{libro.fechatransaccion}}</th>
                </tr>
                <tr>
                  <!--<th></th>-->
                  <!--<th>Tipo</th>-->
                  <!--<th>Fecha</th>-->
                  <th style="width: 10%;">NUMERO</th>
                  <th style="width: 20%;">CUENTA</th>
                  <th style="width: 30%;">DESCRIPCION</th>
                  <th class="text-right" style="width: 15%;">DEBE</th>
                  <th class="text-right" style="width: 15%;">HABER</th>
                  <th style="width: 10%;">ESTADO</th>
                </tr>
              </thead>
              <tbody >
                <tr ng-repeat="reg in libro.cont_registrocontable">
                  <!--<td>{{$id+1}}</td>-->
                  <!--<td>{{reg.cont_transaccion.cont_tipotransaccion.siglas}}</td>-->
                  <!--<td>{{libro.cont_tipotransaccion.siglas}}</td>-->
                  <!--<td>{{reg.fecha}}</td>-->
                  <td>{{orden_plan_cuenta(reg.cont_plancuentas.jerarquia)}}</td>
                  <td>{{reg.cont_plancuentas.concepto}}</td>
                  <td>{{reg.descripcion}}</td>
                  <td class="text-right">{{formato_dinero(reg.debe_c,"$")}}</td>
                  <td class="text-right">{{formato_dinero(reg.haber_c,"$")}} </td>
                  <td ng-show="reg.estadoanulado" ng-hide="!reg.estadoanulado" class="bg-success">Activa</td>
                  <td ng-show="!reg.estadoanulado" ng-hide="reg.estadoanulado" class="bg-warning">Anulada</td>
                </tr>
              </tbody>
              <!--<tfoot>
                <tr class="bg-primary">-->
                  <!--<th colspan="6" class="text-right" >Total</th>-->
              <!--    <th colspan="4" class="" >{{libro.descripcion}}</th>
                  <th>{{aux_tot_libroD_debe}}</th>
                  <th>{{aux_tot_libroD_haber}}</th>
                  <th class="text-left" >Total</th>
                </tr>
              </tfoot>-->
            </table>
          </div>
          <div class="col-xs-12">
            <table class="table ">
              <thead>
                <tr>
                  <th style="width: 10%;"></th>
                  <th style="width: 20%;"></th>
                  <th style="width: 30%;" class="text-right">TOTAL</th>
                  <th class="text-right" style="width: 15%;">{{formato_dinero(aux_tot_libroD_debe,"$")}}</th>
                  <th class="text-right" style="width: 15%;">{{formato_dinero(aux_tot_libroD_haber,"$")}}</th>
                  <th style="width: 10%;"></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <!--Libro diario fin-->

        <!--libro mayor-->
        <div class="row" ng-hide="aux_render!='4' " ng-show=" aux_render=='4'">
          <div class="col-md-12 col-xs-12">
            <table class="table table-responsive table-striped table-hover table-condensed table-bordered ">
              <thead class="bg-primary">
                <tr>
                  <th colspan="10" class="text-center" >{{titulo_head_report}}</th>
                </tr>
                <tr>
                  <th colspan="10" class="text-center" >{{aux_cuenta_select.concepto}}</th>
                </tr>
                <tr>
                  <!--<th></th>-->
                  <th>TIPO</th>
                  <th>FECHA</th>
                  <th>NUMERO</th>
                  <th>CUENTA</th>
                  <th>DESCRIPCION</th>
                  <th>DEBE</th>
                  <th>HABER</th>
                  <th>SALDO</th>
                  <th>ESTADO</th>
                </tr>
              </thead>
              <tbody >
                <tr ng-repeat="regm in libro_mayor">
                  <!--<td>{{$id+1}}</td>-->
                  <td>{{regm.cont_transaccion.cont_tipotransaccion.siglas}}</td>
                  <td>{{regm.fecha}}</td>
                  <td>{{regm.idtransaccion}}</td>
                  <td>{{regm.cont_plancuentas.concepto}}</td>
                  <td>{{regm.descripcion}}</td>
                  <td class="text-right">{{formato_dinero(regm.debe_c,"$")}}</td>
                  <td class="text-right">{{formato_dinero(regm.haber_c,"$")}}</td>
                  <td class="text-right">{{formato_dinero(regm.saldo,"$")}}</td>
                  <td ng-show="regm.estadoanulado" ng-hide="!regm.estadoanulado" class="bg-success">Activa</td>
                  <td ng-show="!regm.estadoanulado" ng-hide="regm.estadoanulado" class="bg-warning">Anulada</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th class="text-right">TOTAL:</th>
                  <th class="text-right">{{formato_dinero(aux_total_debe_m,"$") }}</th>
                  <th class="text-right">{{formato_dinero(aux_total_haber_m,"$") }}</th>
                  <th class="text-right">{{formato_dinero((aux_total_debe_m - aux_total_haber_m),"$") }}</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!--libro mayor fin-->

        <!--estado de situacion finaciera-->
        <div class="row" ng-hide="aux_render!='10' " ng-show=" aux_render=='10'">

          <div class="row">
            <div class="col-md-6 col-xs-12">  <!--Balance-->
              <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
                <thead class="bg-primary">
                  <tr>
                    <th colspan="3" class="text-center">{{titulo_balance}}</th>
                  </tr>
                  <tr>
                    <th>CODIGO</th>
                    <th>CUENTA</th>
                    <th>BALANCE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="b in Balance_finaciero">
                    <td>{{b.aux_jerarquia}}</td>
                    <td>{{b.concepto}}</td>
                    <td class="text-right">{{b.balance}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6 col-xs-12">  <!--Estado De Resultados-->
              <table class="table">
                <thead class="bg-primary">
                  <tr>
                    <th colspan="3" class="text-center">{{titulo_resultados}}</th>
                  </tr>
                  <tr>
                    <th>CODIGO</th>
                    <th>CUENTA</th>
                    <th>BALANCE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="e in Estado_resultados_finaciero">
                    <td>{{e.aux_jerarquia}}</td>
                    <td>{{e.concepto}}</td>
                    <td class="text-right">{{e.balance}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-md-12">
              <table class="table table-bordered">
                <thead class="bg-primary">
                  <tr>
                    <th>T. ACTIVO</th>
                    <th>T. PASIVO</th>
                    <th>T. PATRIMONIO</th>
                    <th>T. UTILIDAD</th>
                    <th>CUADRE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>{{Balance_generado.total_activo}}</th>
                    <th>{{Balance_generado.total_pasivo}}</th>
                    <th>{{Balance_generado.total_patrimonio}}</th>
                    <th>{{Balance_generado.utilidad}}</th>
                    <th >{{Balance_generado.balance}}</th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
        <!--Fin estado de situacion finaciera-->

        <!--estado de cambios del patrimonio-->
        <div class="col-xs-12" ng-hide="aux_render!='1' " ng-show=" aux_render=='1'">
          <table class="table table-responsive table-striped table-hover table-condensed table-bordered">
            <thead class="bg-primary">
              <tr>
                <th colspan="6">{{titulo_head_report}}</th>
              </tr>
              <tr>
               <th></th>
               <th>CONCEPTO</th>
               <th class="text-right">SALDO {{aux_Fecha_I}}</th>
               <th class="text-right">INCREMENTO</th>
               <th class="text-right">DISMINUCION</th>
               <th class="text-right">SALDO {{aux_Fecha_F}}</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="cp in cambio_patrimonio">
                <td>{{$index+1}}</td>
                <td>{{cp.concepto}}</td>
                <td class="text-right">{{formato_dinero(cp.balance1,"$")}}</td>
                <td class="text-right">{{formato_dinero(cp.incremento,"$")}}</td>
                <td class="text-right">{{formato_dinero(cp.disminucion,"$")}}</td>
                <td class="text-right">{{formato_dinero(cp. balance2,"$")}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--estado de cambios del patrimonio-->

        <!--balance general-->
        <div class="row" ng-hide="aux_render!='5' " ng-show=" aux_render=='5'">
          <div class="col-xs-12">
            <table class="table table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th colspan="3" class="text-center">{{titulo_head_report}}</th>
                </tr>
                <tr>
                  <th>CODIGO</th>
                  <th>CUENTA</th>
                  <th>BALANCE</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="activo in list_activo">
                  <th>{{activo.aux_jerarquia}}</th>
                  <th>{{activo.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(activo.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Activo</th>
                  <th class="text-right">{{formato_dinero(total_activo,"$")}}</th>
                </tr>
                <tr><th colspan="3"></th></tr>

                <tr ng-repeat="pasivo in list_pasivo">
                  <th>{{pasivo.aux_jerarquia}}</th>
                  <th>{{pasivo.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(pasivo.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Pasivo</th>
                  <th class="text-right">{{formato_dinero(total_pasivo,"$")}}</th>
                </tr>
                <tr><th colspan="3"></th></tr>

                <tr ng-repeat="patrimonio in list_patrimonio">
                  <th>{{patrimonio.aux_jerarquia}}</th>
                  <th>{{patrimonio.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(patrimonio.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Patrimonio</th>
                  <th class="text-right">{{formato_dinero(total_patrimonio,"$")}}</th>
                </tr>


              </tbody>
            </table>
          </div>
          <div class="col-xs-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-right"> Total Pasivo + Total Patrimonio </th>
                  <th class="text-right"> {{ formato_dinero(aux_formula_patrimonial ,"$")}}</th>
                </tr>
              <tr>
                  <th class="text-right"> Total Ingresos - Total Egresos (Utilidad) </th>
                  <th class="text-right"> {{ formato_dinero(aux_utilidad_formula ,"$")}}</th>
              </tr>
                <tr>
                    <th class="text-right"> Cuadre Contable (Activo-(Pasivo + Patrimonio + Utilidad)) </th>
                    <th class="text-right"> {{ formato_dinero(aux_cuadre_contable,"$") }}</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <!--balance general-->

        <!--estado de resultados-->
        <div class="row" ng-hide="aux_render!='2' " ng-show=" aux_render=='2'">
          <div class="col-xs-12">
            <table class="table table-bordered">
              <thead class="bg-primary">
                <tr>
                  <th colspan="3" class="text-center">{{titulo_head_report}}</th>
                </tr>
                <tr>
                  <th>CODIGO</th>
                  <th>CUENTA</th>
                  <th>BALANCE</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="ingreso in list_ingreso">
                  <th>{{ingreso.aux_jerarquia}}</th>
                  <th>{{ingreso.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(ingreso.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Ingresos</th>
                  <th class="text-right">{{formato_dinero(total_ingreso,"$")}}</th>
                </tr>
                <tr><th colspan="3"></th></tr>

                <tr ng-repeat="costo in list_costo">
                  <th>{{costo.aux_jerarquia}}</th>
                  <th>{{costo.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(costo.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Costos</th>
                  <th class="text-right">{{formato_dinero(total_costo,"$")}}</th>
                </tr>
                <tr><th colspan="3"></th></tr>

                <tr ng-repeat="gasto in list_gasto">
                  <th>{{gasto.aux_jerarquia}}</th>
                  <th>{{gasto.concepto}}</th>
                  <th class="text-right">{{formato_dinero(Valida_numero(gasto.saldo),"$")}}</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-right">Total Gastos</th>
                  <th class="text-right">{{formato_dinero(total_gasto,"$")}}</th>
                </tr>


              </tbody>
            </table>
            <table class="table table-bordered">
              <tr>
                <th class="text-right">Total Ingresos - Total Gastos</th>
                <th class="text-right">{{formato_dinero((total_ingreso-total_gasto),"$")}}</th>
              </tr>
            </table>

            <table class="table table-bordered">
              <tr>
                <th class="text-right">Total Ingresos - Total Egresos </th>
                <th class="text-right">{{formato_dinero((total_ingreso-(total_costo + total_gasto)),"$")}}</th>
              </tr>
            </table>
          </div>
        </div>
        <!--estado de resultados-->

        <!--balance de comprobacion-->
        <div class="col-xs-12" ng-hide="aux_render!='6' " ng-show=" aux_render=='6'">
          <table class="table table-bordered">
            <thead class="bg-primary">
              <tr>
                <th colspan="2" class="text-center">CUENTA</th>
                <th colspan="2" class="text-center">SUMAS</th>
                <th colspan="2" class="text-center">SALDOS</th>
              </tr>
              <tr>
                <th>CODIGO</th>
                <th>CUENTA</th>
                <th>DEBE</th>
                <th>HABER</th>
                <th>DEBE</th>
                <th>HABER</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat=" ba in list_balance_comprobacion">
                <td>{{orden_plan_cuenta(ba.jerarquia)}}</td>
                <td>{{ba.concepto}}</td>
                <td class="text-right">{{formato_dinero(ba.debe,"$")}}</td>
                <td class="text-right">{{formato_dinero(ba.haber,"$")}}</td>
                <td class="text-right">{{formato_dinero(ba.saldo_debe,"$")}}</td>
                <td class="text-right">{{formato_dinero(ba.saldo_haber,"$")}}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right">{{formato_dinero(aux_total_debe_balance,"$")}}</th>
                <th class="text-right">{{formato_dinero(aux_total_haber_balance,"$")}}</th>
                <th class="text-right">{{formato_dinero(aux_total_sdebe_balance,"$")}}</th>
                <th class="text-right">{{formato_dinero(aux_total_shaber_balance,"$")}}</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!--balance de comprobacion-->

        <div class="modal fade"  id="WPrint" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header btn-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="WPrint_head"></h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-xs-12" id="bodyprint">

                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i> </button>
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
                    <div class="form-group  has-feedback">
                    <input type="text" class="form-control" id="" ng-model="FiltraCuenta" placeholder="Buscar" >
                    <span class="glyphicon glyphicon-search form-control-feedback" ></span>
                  </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <table class="table table-bordered table-condensed">
                      <thead>
                        <tr class="btn-primary">
                          <th></th>
                          <th>Descripción</th>
                          <th>Codigo </th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="cuenta in aux_plancuentas | filter:FiltraCuenta">
                          <td>{{cuenta.jerarquia}}</td>
                          <td>{{cuenta.concepto}}</td>
                          <td>{{cuenta.codigosri}}</td>
                          <td>
                              <input ng-show="cuenta.madreohija=='1' " ng-hide="cuenta.madreohija!='1' " type="radio" name="cuenta_contable" ng-click="select_cuenta(cuenta);">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar <i class="glyphicon glyphicon glyphicon-ban-circle"></i></button>
                <button type="button" class="btn btn-primary" ng-click="generar_libro_mayor();" >Aceptar <i class="glyphicon glyphicon glyphicon-ok"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" data-backdrop="static" data-keyboard="false" style="z-index: 9999999;" tabindex="-1" id="procesarinfomracion" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-body">

                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    <span > Procesando </span>
                  </div>
              </div>

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
            

	</div>