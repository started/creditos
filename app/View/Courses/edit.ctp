<h1>Editar Credito</h1>
<?php 
    echo $this->Form->create('Credit',array('action' => 'edit'));
    echo $this->Form->input('product_price', array('label'=>'Precio Producto'));
    echo $this->Form->input('interest', array('label'=>'Interés'));
    echo $this->Form->input('term', array('label'=>'Plazos'));
    echo $this->Form->input('down_payment', array('label'=>'Cuota Inicial'));
    echo $this->Form->input('financing', array('type' => 'hidden'));
    echo $this->Form->input('date', array('type' => 'hidden'));
    echo $this->Form->end('Guardad Credito');
?>
