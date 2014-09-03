<div>
    <h1>Lista de Cursos</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Description</th>
            <th>Profesor</th>
            
        </tr>
        
    <?php
    foreach ($courses as $course):?>
        <tr>
            <td><?php echo $course['Course']['id']; ?></td>
            <td><?php echo $course['Course']['name']; ?></td>
            <td><?php echo $course['Course']['description']; ?></td>
            <td><?php echo $this->Html->link( 
                    $course['Teacher']['name'],
                    array(
                        'controller'=>'teachers',
                        'action'=>'view',
                        $course['Teacher']['id'])); ?></td>
        </tr>
    <?php endforeach;

    ?>
    </table>
</div>
