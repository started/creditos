<?php
//    echo $this->Form->create('Client',array('action' => 'edit'));
//    echo $this->Form->input('name', array('label'=>'Nombre'));
//    echo $this->Form->input('last_name', array('label'=>'Apellido'));
//    echo $this->Form->input('address', array('label'=>'Direccion'));
//    echo $this->Form->input('phone', array('label'=>'Teléfono'));
//    echo $this->Form->input('email', array('label'=>'E-mail'));
//    echo $this->Form->input('id',array('type'=>'hidden'));
//    echo $this->Form->end('Guardar Cliente');
?>
<div class="col-md-6">
<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">Editar Cliente</div>

    </div>
    <div class="panel-body">
        <?php
            echo $this->Form->create('Client',array('action' => 'edit', 'inputDefaults' => array('div' => false )));
        ?>
        <fieldset>
        <div class="form-group">    
        <?php echo $this->Form->input('name', array('label'=>'Nombre','class'=>'form-control')); ?>
        </div>
        <div class="form-group">
        <?php echo $this->Form->input('last_name', array('label'=>'Apellido','class'=>'form-control')); ?>
        </div>
        <div class="form-group">
        <?php echo $this->Form->input('address', array('label'=>'Direccion','class'=>'form-control')); ?>
        </div>
        <div class="form-group">
        <?php echo $this->Form->input('phone', array('label'=>'Teléfono','class'=>'form-control')); ?>
        </div>
        <div class="form-group">
        <?php echo $this->Form->input('email', array('label'=>'E-mail','class'=>'form-control')); ?>
        </div>
        <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
        
        </fieldset>
        <div>
            <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
            <?php echo $this->Html->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-primary')); ?>
        </div>
        
        
    </div>
    
</div>
</div>