<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">Créditos</div>
        <?php // echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Crédito', array('action'=>'add'),array('class'=>'btn btn-success btn-xs','escape' => false)); ?>
    </div>
    <div class="panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>Id</th>
                    <!--<th>Estado</th>-->
                    <th>Producto</th>
                    <th>Precio Producto</th>
                    <th>Interés</th>
                    <th>Cuotas</th>
                    <th>Primera Cuota</th>
                    <th>Financiamiento</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php
//                debug($creditos);
                foreach ($creditos as $key => $credito):?>
                <tr class="<?php echo ($credito['Credit']['status']==1)? 'danger':'success';?>">
                    <td><?php echo $credito['Credit']['id']?></td> 
                    <!--<td><?php //echo $credito['Credit']['status']?></td>-->
                    <td><?php echo $credito['Credit']['product_name']?></td> 
                    <td><?php echo $credito['Credit']['product_price']?></td> 
                    <td><?php echo $credito['Credit']['interest']?></td>
                    <td><?php echo $credito['Credit']['term']?></td>
                    <td><?php echo $credito['Credit']['down_payment']?></td>
                    <td><?php echo $credito['Credit']['financing']?></td>
                    <td class="odd gradeX"><?php echo $credito['Credit']['date']?></td>
                    <td>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i> Ver estado', array('action'=>'view',$credito['Credit']['id']),array('class'=>'btn btn-default','escape' => false)); ?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>',array('action'=>'edit',$credito['Credit']['id']),array('class'=>'btn btn-primary','escape' => false)); ?>
                        <?php echo $this->Form->postLink('<i class="glyphicon glyphicon-remove"></i>',
                                array('action'=>'delete',$credito['Credit']['id']),array('class'=>'btn btn-danger','escape' => false),
                                array('confirm'=>'Realmente desea eliminar Credito '.$credito['Credit']['id'].'?')); ?>
                    </td>
                </tr>
                <?php
                endforeach;?>
            </tbody>
        </table>
    </div>
</div>

  			



