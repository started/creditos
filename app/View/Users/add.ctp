<div class="col-md-6">
    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">Agregar Usuario</div>

        </div>
        <div class="panel-body">
            <?php echo $this->Form->create('User',array('inputDefaults' => array('div' => false ))); ?>
            <fieldset>
                <div class="form-group">
                <?php echo $this->Form->input('name', array('label'=>'Nombre','class'=>'form-control')); ?>
                </div> 
                <div class="form-group">    
                <?php echo $this->Form->input('username', array('label'=>'Usuario','class'=>'form-control')); ?>
                </div>
                <div class="form-group">
                <?php echo $this->Form->input('password', array('label'=>'Password','type'=>'password','class'=>'form-control')); ?>
                </div>
                <div class="form-group">
                <?php echo $this->Form->input('password_confirmation', array('label' =>'Repetir Password','type'=>'password','class'=>'form-control')); ?>
                </div>
                <div class="form-group">
                <?php echo $this->Form->input('email', array('label'=>'Email','class'=>'form-control')); ?>
                </div>
            </fieldset>
            <div>
                <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                <?php echo $this->Html->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-primary')); ?>
            </div>


        </div>

    </div>
</div>


