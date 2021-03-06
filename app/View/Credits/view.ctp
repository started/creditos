<?php
    $saldoPlan   = $credit['Credit']['financing'];
    $saldo       = $credit['Credit']['financing'];
    $saldo       = round($saldo,1);
    $pagototal   = $credit['Credit']['down_payment'];
    $pagoPorMes  = $credit['Credit']['financing'] / $credit['Credit']['term'];
    $pagoPorMes  = round($pagoPorMes,1);
    $precioVenta = $credit['Credit']['down_payment'];
    
    $residuo = (float)$credit['Credit']['financing'];
    
    $pagoAnticipado = 0;
    if(count($credit['Payment']) > 0):
        $lastPayment = count($credit['Payment'])-1;
        $pagoAnticipado = $credit['Payment'][$lastPayment]['prepayment'];
        $datePaymentLimit = $credit['Payment'][$lastPayment]['next_payment'];
        $datePaymentLimitPrev = $credit['Payment'][$lastPayment]['date_payment'];
        $saldo = $credit['Payment'][$lastPayment]['residue'];
        $residuo = (float)$credit['Payment'][$lastPayment]['residue'];
    else:
        $datePaymentLimit = $credit['Credit']['first_payment'];
        $datePaymentLimitPrev = $credit['Credit']['date'];
        $saldo = $credit['Credit']['financing'];
        
    endif;
    
    $cuota =  number_format($credit['Credit']['financing']/$credit['Credit']['term'],1,'.','');
    
    $cuotaTotal = number_format($cuota+$interes-$pagoAnticipado,2,'.','');
    
    $montoTotal = number_format($cuotaTotal+$multa,2,'.','');
    
    
?>

<?php 
    $countPago = $cuota ;
    $countInteres = $interes;
    $countDiasTranscurridos = $diasTranscurridos;
    $countMulta = $multa;
    $countDiasTranscurridosMulta = $diasTranscurridosMulta;
    $subtotalInteres = $cuota + $interes;
    $countSubtotalInteres = $subtotalInteres;
    
    
    
    foreach ($pagosSiguientesCredito as $key => $pago):

        $countPago = $countPago + $cuota;
        $countInteres = $countInteres + $pago['interes'];
        $countDiasTranscurridos = $countDiasTranscurridos + $pago['diasTranscurridos'];
        $countMulta = $countMulta + $pago['multa'];
        $countDiasTranscurridosMulta = $countDiasTranscurridosMulta + $pago['diasTranscurridosMulta'];
        $countSubtotalInteres = $countSubtotalInteres + ($cuota + $pago['interes']);
        
    endforeach;
    
    $totalTotal = $countPago + $countInteres + $countMulta;

?>
<style>
    #form-pagar,
    #ref-cuotas,
    #pagos-realizados{
        display: none;
    }
    #cancelar-pagar{
        display: none;
    }
</style>
<script>
    $(document).ready(function(){
        $('#btn-detalle').on('click',function(){
            $('#detalle').siblings('.vista').slideUp("slow");
            $('#detalle').slideDown( "slow" );
        });
        $('#btn-pagar').on('click',function(){
            $('#form-pagar').siblings('.vista').slideUp("slow");
            $('#form-pagar').slideDown( "slow" );
        });
        $('#btn-pagos').on('click',function(){
            $('#pagos-realizados').siblings(".vista").slideUp("slow");
            $('#pagos-realizados').slideDown( "slow" );
        });
        $('#btn-cuotas').on('click',function(){
            $('#ref-cuotas').siblings('.vista').slideUp("slow");
            $('#ref-cuotas').slideDown( "slow" );
        });
        $('#cancelar-pagar').on('click',function(event){
            event.preventDefault();
            $('#form-pagar').slideUp( "slow" );
            $(this).hide();
        });
        var interesMulta = <?php echo $multa;?>;
        //var pagoTotal = $("#PaymentAmount").val();
        var pagoTotal = <?php echo $montoTotal; ?>;
        var sin_multa = pagoTotal - interesMulta;
        console.log(pagoTotal);
        var pagoTotal = $("#PaymentAmount").val();
        $("#PaymentException").change(function() {
            if(!$(this).prop('checked')){
                $("#PaymentAmount").val(pagoTotal);
            }
            else{
                $("#PaymentAmount").val(sin_multa); 
            }
        });
        
        if($('.message').lenght()>0){
            $('.message').addClass('alert alert-success');
        }
    });
</script>
<div class="row">
    
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="panel-heading">
                <button id="btn-detalle" class="btn btn-primary"><i class="glyphicon glyphicon-list"></i> Detalle de Crédito</button>
                <?php if($residuo > 1): ?>
                    <button id="btn-pagar" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Pagar Cuota</button>
                <?php endif; ?>
                <button id="btn-pagos" class="btn btn-primary"><i class="glyphicon glyphicon-list-alt"></i> Pagos Realizados</button>
                <button id="btn-cuotas" class="btn btn-primary"><i class="glyphicon glyphicon-eye-open"></i> Plan de Cuotas</button>
            </div>
            <div id="detalle" class="vista">
                <h4><i class="glyphicon glyphicon-file"></i>Detalle de Crédito <?php echo ($credit['Credit']['status'] == 0)? 'Deuda Saldada':'';?></h4>
                <table id="user" class="table table-bordered table-striped" style="clear: both">
                     <tbody>
                        <tr>
                            <td>Producto</td>
                            <td><?php echo $credit['Credit']['product_name']?></td> 
                        </tr>
                        <tr>
                            <td>Precio Producto</td>
                            <td><?php echo $credit['Credit']['product_price']?></td> 
                        </tr>
                        <tr>
                            <td>Precio Venta Producto</td>
                            <td><?php echo $credit['Credit']['sale_price']?></td> 
                        </tr>
                        <tr>
                            <td>Interés (%)</td>
                            <td><?php echo $credit['Credit']['interest']?></td>
                        </tr>
                        <tr>
                            <td>Multa (%)</td>
                            <td><?php echo $credit['Credit']['fine']?></td>
                        </tr>
                        <tr>
                            <td>Cuotas</td>
                            <td><?php echo $credit['Credit']['term']; ?></td>
                        </tr>
                        <tr>
                            <td>Cuota Inicial</td>
                            <td><?php echo $credit['Credit']['down_payment']?></td>
                        </tr>
                        <tr>
                            <td>Financiamiento</td>
                            <td><?php echo $credit['Credit']['financing']?></td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td><?php echo $credit['Credit']['date']?></td>
                        </tr>
                        <tr>
                            <td>Primer Pago</td>
                            <td><?php echo $credit['Credit']['first_payment']?></td>
                        </tr>
                        <?php if($credit['Guarantor']['name'] != ""): ?>
                        <tr>
                            <td>Garante</td>
                            <td><?php echo $credit['Guarantor']['name']." ".$credit['Guarantor']['last_name']?></td>
                        </tr>
                        <tr>
                            <td>Teléfono Garante</td>
                            <td><?php echo $credit['Guarantor']['phone']?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody> 
                </table>
            </div>
            
            <div id="form-pagar" class="vista">
                <div class="panel-body">
                    <?php echo $this->Form->create('Payment',array('action' => 'add','inputDefaults' => array('div' => false ), 'class' => 'form-horizontal')); ?>
                    <fieldset>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Cuota</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <span class="form-control">
                                            <?php echo $cuota; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Interés por <?php echo $diasTranscurridos ?> día(s) transcurridos</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <span class="form-control"><?php echo $interes ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Pago Anticipado</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <span class="form-control"><?php echo $pagoAnticipado; ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Saldo</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                        <span class="form-control"><?php echo $saldo; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group has-warning">
                            <label>Cuota total</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                <span class="form-control" id="cuota-total">
                                    <?php echo $cuotaTotal; ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>Fecha limite Pago Anterior</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <span class="form-control"><?php echo $datePaymentLimitPrev; ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Fecha Actual</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <span class="form-control"><?php echo date('Y-m-d'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Fecha limite de Pago</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <span class="form-control"><?php echo $datePaymentLimit; ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label>Fecha Siguiente de Pago</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                        <span class="form-control"><?php echo $siguientePago; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Multa por <i><?php echo $diasTranscurridosMulta ?></i> día(s) transcurrido(s)</label>
                                    <span class="form-control"><?php echo $multa ?></span>
                                </div>
                                <div class="col-sm-6">
                                    <div class="checkbox" style="margin: 20px 0 0 0">
                                        <?php echo $this->Form->input('exception', array('label'=>'No cobrar multa', 'type' => 'checkbox')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group has-success">
                            <label>Monto total a pagar</label>
                            <!--<button class="btn btn-primary" >Pagar todo</button>-->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                <?php echo $this->Form->input('amount', array('label'=> false,'class'=>'form-control', 'value' => $montoTotal, 'min'=>$cuotaTotal, 'max'=>$totalTotal)); ?>
                            </div>
                        </div>
                        
                        <?php
                            echo $this->Form->input('credit_id',array('type' => 'hidden','value' => $credit['Credit']['id']));
                            echo $this->Form->input('interest', array('type' => 'hidden', 'value' => $interes));
                            echo $this->Form->input('days_elapsed',array('type' => 'hidden','value' => $diasTranscurridos));
                            echo $this->Form->input('residue', array('type' => 'hidden', 'value' => ""));
                            echo $this->Form->input('date', array('type' => 'hidden', 'value' => (string)date('Y-m-d')));
                            echo $this->Form->input('date_payment', array('label'=>false, 'type' => 'hidden','value' => $datePaymentLimit ));
                            echo $this->Form->input('fine',array('type' => 'hidden','value' => $multa));
                            echo $this->Form->input('days_elapsed_fine',array('type' => 'hidden','value' => $diasTranscurridosMulta));
                            echo $this->Form->input('prepayment', array('type' => 'hidden', 'value' => ""));
                            echo $this->Form->input('next_payment', array('type' => 'hidden', 'value' => $siguientePago));
                        ?>
                        
                    </fieldset>
                    <div class="panel-body">
                        <h2>Pagos Siguientes</h2>
                        <table class="table table-striped">
                            <tr>
                                <th>Pago</th>
                                <th>Interés</th>
                                <th>Dias Transcurridos</th>
                                <th>SubTotal</th>
                                <th>Multa</th>
                                <th>Dias Transcurridos Multa</th>
                                <th>Total</th>
                                <th>Saldo</th>
                                <th>Fecha Limite</th>
                            </tr>
                            <tr>
                                <td><?php echo $cuota?></td> 
                                <td><?php echo $interes?></td>
                                <td><?php echo $diasTranscurridos?></td>
                                <td><?php $subtotalInteres = $cuota + $interes; echo $subtotalInteres ?></td>
                                <td><?php echo $multa?></td>
                                <td><?php echo $diasTranscurridosMulta?></td>
                                <td><?php echo $cuota + $interes + $multa ?></td>
                                <td><?php echo $saldo?></td>
                                <td><?php echo $datePaymentLimit?></td>
                            </tr>
                            <?php 
                                $countPago = $cuota ;
                                $countInteres = $interes;
                                $countDiasTranscurridos = $diasTranscurridos;
                                $countMulta = $multa;
                                $countDiasTranscurridosMulta = $diasTranscurridosMulta;
                                $countSubtotalInteres = $subtotalInteres;
                            ?>    
                            <?php foreach ($pagosSiguientesCredito as $key => $pago): ?>
                            <tr>
                                <td><?php echo $cuota?></td> 
                                <td><?php echo $pago['interes']?></td>
                                <td><?php echo $pago['diasTranscurridos']?></td>
                                <td><?php echo $cuota + $pago['interes']?></td>
                                <td><?php echo $pago['multa']?></td>
                                <td><?php echo $pago['diasTranscurridosMulta']?></td>
                                <td><?php echo $cuota + $pago['interes'] + $pago['multa'] ?></td>
                                <td><?php echo $pago['saldo']?></td>
                                <td><?php echo $pago['fechaLimitePagoActual']?></td>
                            </tr>
                            <?php 
                                $countPago = $countPago + $cuota;
                                $countInteres = $countInteres + $pago['interes'];
                                $countDiasTranscurridos = $countDiasTranscurridos + $pago['diasTranscurridos'];
                                $countMulta = $countMulta + $pago['multa'];
                                $countDiasTranscurridosMulta = $countDiasTranscurridosMulta + $pago['diasTranscurridosMulta'];
                                $countSubtotalInteres = $countSubtotalInteres + ($cuota + $pago['interes']);
                                
                            ?>
                            <?php endforeach; ?>
                            <tr>
                                <th>Pago Total</th>
                                <th>Interés Total</th>
                                <th>Dias Transcurridos</th>
                                <th>Total Subtotal</th>
                                <th>Multa Total</th>
                                <th>Dias Transcurridos Multa</th>
                                <th>TOTAL</th>
                            </tr>
                        
                            <tr>
                                <td><?php echo $countPago?></td>
                                <td><?php echo $countInteres?></td>
                                <td><?php echo $countDiasTranscurridos?></td>
                                <td><?php echo $countSubtotalInteres ?></td>
                                <td><?php echo $countMulta?></td>
                                <td><?php echo $countDiasTranscurridosMulta?></td>
                                <td><?php echo $countPago + $countInteres + $countMulta?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                        <?php echo $this->Html->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-primary')); ?>
                    </div>
                </div>
            </div>
            
            <div id="ref-cuotas" class="vista">
                <div class="panel-heading">
                    <div class="panel-title">Referencia de Cuotas</div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cuota</th>
                                <th>Interes Cuota</th>
                                <th class="total">Total Cuota</th>
                                <th class="pago-total">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i=0; $i < $credit['Credit']['term']; $i++): ?>
                                <tr>

                                    <?php 
                                    $interesActual  = $saldoPlan * ($credit['Credit']['interest']/100);
                                    $interesActual  = round($interesActual,1);
                                    $saldoPlan          = $saldoPlan - $pagoPorMes;
                                    $saldoPlan          = round($saldoPlan, 1);
                                    $pagototal      = $pagototal + ($interesActual + $pagoPorMes);
                                    $cuotaTotal     = $interesActual + $pagoPorMes;
                                    $cuotaTotal     = round($cuotaTotal,1);
                                    $precioVenta    = $precioVenta + $cuotaTotal;
                                    ?>

                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $pagoPorMes; ?></td>
                                    <td><?php echo $interesActual; ?></td>
                                    <td class="total"><?php echo $cuotaTotal; ?></td>
                                    <td class="saldo"> <?php echo $saldoPlan; ?> </td>
                                </tr>
                            <?php endfor; ?>    
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="pagos-realizados" class="vista">
                <div class="panel-heading">
                    <div class="panel-title">Pagos Realizados</div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Pago</th>
                            <th>Pre-Pago</th>
                            <th>Interés</th>
                            <th>Saldo</th>
                            <th>Multa</th>
                            <th>Se cobró <br> multa </th>
                            <th>Fecha</th>
                            <th>Fecha Limite</th>
                            <th>Siguiente Pago</th>
                        </tr>
                        <?php
                        foreach ($credit['Payment'] as $key => $pago):?>
                        <tr>
                            <td><?php echo $pago['id']?></td> 
                            <td><?php echo $pago['amount']?></td>
                            <td><?php echo $pago['prepayment']?></td> 
                            <td><?php echo $pago['interest']?></td>
                            <td><?php echo $pago['residue']?></td>
                            <td><?php echo $pago['fine']?></td>
                            <td><?php echo ($pago['exception']==0)? 'si':'no' ?></td>
                            <td><?php echo $pago['date']?></td>
                            <td><?php echo $pago['date_payment']?></td>
                            <td><?php echo $pago['next_payment']?></td>
                        </tr>
                        <?php
                        endforeach; ?>
                    </table>
                </div>
            </div>
        
        </div>
    </div>
    <div class="col-md-4">
        
    </div>
</div>

<?php
function diasPago($fechaCredito,$cuotas){
    $fechas = array();
    for($i = 1; $i <= $cuotas; ++$i){
        array_push($fechas, date("d-m-Y", strtotime($fechaCredito." +$i month")));
    }		
    return $fechas;
}

 function siguientePago($date) {
        return  date("Y-m-d", strtotime($date." + 30 day"));
    }
?>


