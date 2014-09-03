<h1>Lista de Estudiantes</h1>
<?php echo $this->Html->link('Agregar Estudiante', array('action'=>'add')); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Acciones</th>
    </tr>
<?php
    foreach ($estudiantes as $key => $estudiante):?>
    <tr>
        <td><?php echo $estudiante['Student']['id']?></td> 
        <td><?php echo $estudiante['Student']['name']?></td> 
        <td><?php echo $estudiante['Student']['last_name']?></td>
        <td>
            <?php echo $this->Html->link('Editar',array('action'=>'edit',$estudiante['Student']['id'])); ?>
            <?php echo $this->Form->postLink('Eliminar',
                    array('action'=>'delete',$estudiante['Student']['id']),
                    array('confirm'=>'Realmente desea eliminar estudiante '.$estudiante['Student']['name'].'?')); ?>
        </td>
    </tr>
    <?php
    endforeach;
    
?>
</table>

