<div class="col-md-6">
    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">Agregar Crédito</div>
        </div>
        <div class="panel-body">
            <?php echo $this->Form->create('Credit',array('action' => 'add', 'inputDefaults' => array('div' => false ))); ?>
            <fieldset>
            <div class="form-group">    
                <?php echo $this->Form->input('Credit.product_name', array('label'=>'Producto','class'=>'form-control')); ?>
            </div>
            <div class="form-group">    
                <?php echo $this->Form->input('Credit.product_price', array('label'=>'Precio de Producto','class'=>'form-control','min'=>'0')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('Credit.interest', array('label'=>'Interés (%)','class'=>'form-control','min'=>'0','max'=>'20')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('Credit.term', array('label'=>'Plazos','class'=>'form-control','min'=>'1','max'=>'10')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('Credit.down_payment', array('label'=>'Cuota Inicial','class'=>'form-control','min'=>'0')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('Credit.fine', array('label'=>'Multa (%)','class'=>'form-control','min'=>'0','max'=>'20')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->date('Credit.date', array('label'=>'Fecha','class'=>'form-control')); ?>
            </div>
            <?php echo $this->Form->input('Credit.sale_price', array('type'=>'hidden')); ?> 
            <?php echo $this->Form->input('Credit.financing', array('type'=>'hidden')); ?>    
            <?php //echo $this->Form->input('Credit.date', array('type' => 'hidden')); ?>
            <?php echo $this->Form->input('Credit.first_payment', array('type' => 'hidden')); ?>
            <?php echo $this->Form->input('Credit.client_id',array('type' => 'text','type'=>'hidden','value' => $this->params['pass'][0])); ?>
            </fieldset>
            <div>
                <?php //echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                <?php //echo $this->Html->link('Cancelar',array('action'=>'../clients/index'),array('class'=>'btn btn-primary')); ?>
            </div>
        </div>

    </div>
</div>

<div class="col-md-6">
    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">Garante</div>

        </div>
        <div class="panel-body">
            <?php
//                echo $this->Form->create('Guarant',array('inputDefaults' => array('div' => false )));
            ?>
            <fieldset>
            <div class="form-group">    
            <?php echo $this->Form->input('Guarantor.name', array('label'=>'Nombre','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('Guarantor.last_name', array('label'=>'Apellido','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('Guarantor.address', array('label'=>'Direccion','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('Guarantor.phone', array('label'=>'Teléfono','class'=>'form-control')); ?>
            </div>
            <div class="form-group">
            <?php echo $this->Form->input('Guarantor.email', array('label'=>'E-mail','class'=>'form-control')); ?>
            </div>    

            </fieldset>
            <div>
                <?php //echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
                <?php //echo $this->Html->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-primary')); ?>
            </div>


        </div>

    </div>
</div>
<div class="col-md-12">
    <div class="content-box-large">
        <div>
            <?php echo $this->Form->end(array('label' => 'Guardar','class'=>'btn btn-primary','div' => false)); ?>
            <?php echo $this->Html->link('Cancelar',array('action'=>'../clients/index'),array('class'=>'btn btn-primary')); ?>
        </div>
    </div>
</div>


