<?php 
//    echo $this->Form->create('Credit',array('action' => 'edit'));
//    echo $this->Form->input('product_price', array('label'=>'Precio Producto'));
//    echo $this->Form->input('interest', array('label'=>'Interés'));
//    echo $this->Form->input('term', array('label'=>'Plazos'));
//    echo $this->Form->input('down_payment', array('label'=>'Cuota Inicial'));
//    echo $this->Form->input('financing', array('type' => 'hidden'));
//    echo $this->Form->input('date', array('type' => 'hidden'));
//    echo $this->Form->end('Guardad Credito');
?>

<div class="col-md-6">
    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">Editar Crédito</div>
        </div>
        <div class="panel-body">
            <?php echo $this->Form->create('Credit',array('action' => 'edit', 'inputDefaults' => array('div' => false ))); ?>
            <fieldset>
            <div class="form-group">    
                <?php echo $this->Form->input('product_name', array('label'=>'Producto','class'=>'form-control')); ?>
            </div>
            <div class="form-group">    
            <?php echo $this->Form->input('product_price', array('label'=>'Precio Producto','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('interest', array('label'=>'Interés','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('term', array('label'=>'Plazos','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('down_payment', array('label'=>'Cuota Inicial','class'=>'form-control')); ?>
            </div>
            <?php echo $this->Form->input('financing', array('type'=>'hidden')); ?>    
            <?php echo $this->Form->input('date', array('type' => 'hidden')); ?>
            <?php // echo $this->Form->input('client_id',array('type' => 'text','type'=>'hidden','value' => $this->params['pass'][0])); ?>
            </fieldset>
            <div>
                <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                <?php echo $this->Html->link('Cancelar',array('action'=>'list_credit'),array('class'=>'btn btn-primary')); ?>
            </div>
        </div>

    </div>
</div>