<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">Créditos de <?php echo $this->Html->link($client['Client']['name']." ".$client['Client']['last_name'], array('controller' => 'clients','action'=>'edit', $client['Client']['id']),array('escape' => false)); ?></div>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Crédito', array('action'=>'add',$client['Client']['id']),array('class'=>'btn btn-success btn-xs','escape' => false)); ?>
        <?php echo $this->Html->link('Atrás', array('controller'=>'clients', 'action'=>'index'),array('style'=>'float:right','escape' => false)); ?>
    </div>
    
    <table id="user" class="table table-bordered table-striped" style="clear: both">
        <tbody>
            <tr>
               <td>Cliente</td>
               <td><?php echo $client['Client']['name']." ".$client['Client']['last_name']?></td> 
           </tr>
           <tr>
               <td>Direccion</td>
               <td><?php echo $client['Client']['address'];?></td> 
           </tr>
           <tr>
               <td>Telefono</td>
               <td><?php echo $client['Client']['phone'];?></td> 
           </tr>
           <tr>
               <td>Email</td>
               <td><?php echo $client['Client']['email'];?></td> 
           </tr>
        </tbody> 
    </table>
    
    <div class="panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Precio Producto</th>
                    <th>Interés</th>
                    <th>Cuotas</th>
                    <th>Primera Cuota</th>
                    <th>Financiamiento</th>
                    <th>Fecha</th>
                    <th>Accioness</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($client['Credit'] as $key => $credito):?>
                <tr class="odd gradeX <?php echo ($credito['status']==1)? 'danger':'success';?>">
                    <td><?php echo $credito['id']?></td> 
                    <td><?php echo $credito['product_name']?></td> 
                    <td><?php echo $credito['product_price']?></td> 
                    <td><?php echo $credito['interest']?></td>
                    <td><?php echo $credito['term']?></td>
                    <td><?php echo $credito['down_payment']?></td>
                    <td><?php echo $credito['financing']?></td>
                    <td><?php echo $credito['date']?></td>
                    <td>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i> Ver estado',
                                                    array('action'=>'view',$credito['id']),
                                                    array('class'=>'btn btn-default','escape' => false)); ?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>',
                                                    array('action'=>'edit',$credito['id']),
                                                    array('class'=>'btn btn-primary','escape' => false)); ?>
                        <?php echo $this->Form->postLink('<i class="glyphicon glyphicon-remove"></i>',
                                                        array('action'=>'delete',$credito['id']),
                                                        array('class'=>'btn btn-danger','escape' => false),
                                                        array('confirm'=>'Realmente desea eliminar Credito '.$credito['id'].'?')); ?>
                        
                    </td>
                </tr>
                <?php
                endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


