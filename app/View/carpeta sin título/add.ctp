<div class="row">
    <div class="col-md-6">
        <div class="content-box-large">
            <div class="panel-heading">
                <div class="panel-title">Agregar Pago</div>

            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Payment',array('action' => 'add','inputDefaults' => array('div' => false ))); ?>
                <fieldset>
                    <div class="form-group">    
                        <?php echo $this->Form->input('amount', array('label'=>'Monto','class'=>'form-control', 'value' => $this->params['pass'][1] + $interes )); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('interest', array('label'=>'Interes','class'=>'form-control','value' => $interes)); ?>    
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->input('residue', array('label'=>'Saldo','class'=>'form-control','value' => $this->params['pass'][4])); ?>
                    </div>
                    <?php
                        echo $this->Form->input('date', array('type' => 'hidden', 'value' => (string)date('Y/m/d') ));
                        echo $this->Form->input('credit_id',array('type' => 'hidden','value' => $this->params['pass'][0]));
                    ?>    
                </fieldset>
                <div>
                    <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                    <?php echo $this->Html->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-primary')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-box-large">    
            <h4>Detalle de Crédito</h4>
            <?php // echo $this->Html->link('Agregar Credito', array('action'=>'add')); ?>
            <table id="user" class="table table-bordered table-striped" style="clear: both">
                 <tbody>

                    <?php
                    foreach ($creditos as $key => $credito):?>
                    <tr>
                        <td>Id</td>
                        <td><?php echo $credito['Credit']['id']?></td> 
                    </tr>
                    <tr>
                        <td>Precio Producto</td>
                        <td><?php echo $credito['Credit']['product_price']?></td> 
                    </tr>
                    <tr>
                        <td>Interés</td>
                        <td><?php echo $credito['Credit']['interest']?></td>
                    </tr>
                    <tr>
                        <td>Cuotas</td>
                        <td><?php echo $credito['Credit']['term']?></td>
                    </tr>
                    <tr>
                        <td>Primera Cuota</td>
                        <td><?php echo $credito['Credit']['down_payment']?></td>
                    </tr>
                    <tr>
                        <td>Financiamiento</td>
                        <td><?php echo $credito['Credit']['financing']?></td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td><?php echo $credito['Credit']['date']?></td>
                    </tr>
                    <?php
                    endforeach;?>
                </tbody> 
            </table>
        </div> 
    </div>
</div>
