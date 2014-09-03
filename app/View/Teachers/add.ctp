<div class="add">
    <?php echo $this->Form->create('Teacher'); ?>
    <fieldset>
        <legend>Agregar Profesor</legend>
        <?php echo $this->Form->input('name',array('label'=>'Nombre')); ?>
        <?php echo $this->Form->input('last_name',array('label'=>'Apellido')); ?>
        <?php echo $this->Form->input('cv'); ?>
        <?php echo $this->Form->end('Guardar'); ?>
        
        
    </fieldset>
</div>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
