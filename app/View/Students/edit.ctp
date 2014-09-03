<h1>Editar Estudiante</h1>
<?php
    echo $this->Form->create('Student',array('action' => 'edit'));
    echo $this->Form->input('name');
    echo $this->Form->input('last_name');
    echo $this->Form->input('id',array('type'=>'hidden'));
    echo $this->Form->end('Guardar estudiante');
?>
