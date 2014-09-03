<div class="index">
    <h1>Profesores</h1>
    <table>
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('name',"Nombre"); ?></th>
            <th><?php echo $this->Paginator->sort('last_name',"Apellido"); ?></th>
            <th><?php echo $this->Paginator->sort('cv',"CV"); ?></th>
        </tr>
        <?php
        foreach ($teachers as $teacher):?>
        <tr>
            <td><?php echo h($teacher['Teacher']['id']); ?></td>
            <td><?php echo h($teacher['Teacher']['name']); ?></td>
            <td><?php echo h($teacher['Teacher']['last_name']); ?></td>
            <td><?php echo h($teacher['Teacher']['cv']); ?></td>
        </tr>
        <?php endforeach;
    
        ?>
    </table>
    <p>
        <?php echo $this->Paginator->counter(
                array('format' => 'Página {:page} de {:pages}, mostrando {:current} registros de {:count}')
                ); ?>
    </p>
    <div class="paging">
        <?php echo $this->Paginator->prev('<- anterior', array(),null,array('class'=>'prev disabled')) ;?>
        <?php echo $this->Paginator->numbers(array('separator'=>'')) ;?>
        <?php echo $this->Paginator->next('siguiente ->', array(),null,array('class'=>'next disabled')) ;?>
    </div>
</div>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
