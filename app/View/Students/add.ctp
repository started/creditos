<h1>Agregar Estudiante</h1>
<?php

    echo $this->Form->create('Student');
    echo $this->Form->input('name', array('label'=>'Nombre'));
    echo $this->Form->input('last_name', array('label'=>'Apellido'));
    echo $this->Form->end('Guardar estudiante');
?>
