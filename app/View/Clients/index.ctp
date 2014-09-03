<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">Clientes</div>
        <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Cliente', array('action'=>'add'),array('class'=>'btn btn-success btn-xs','escape' => false)); ?>
    </div>
    <div class="panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php
                foreach ($clientes as $key => $cliente):?>
                <tr class="odd gradeX">
                    <td><?php echo $cliente['Client']['id']?></td> 
                    <td><?php echo $cliente['Client']['name']?></td> 
                    <td><?php echo $cliente['Client']['last_name']?></td>
                    <td><?php echo $cliente['Client']['phone']?></td>
                    <td><?php echo $cliente['Client']['email']?></td>
                    <td>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-pencil"></i>',array('action'=>'edit',$cliente['Client']['id']),array('class'=>'btn btn-primary','escape' => false)); ?>
                        
                        <?php echo $this->Form->postLink('<i class="glyphicon glyphicon-remove"></i>',
                                array('action'=>'delete',$cliente['Client']['id']),
                                array('confirm'=>'Realmente desea eliminar cliente '.$cliente['Client']['name'].'?',
                                'class'=>'btn btn-danger','escape' => false)); ?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-eye-open"></i> Créditos', array('action'=>'../credits/list_credit',$cliente['Client']['id']),array('class'=>'btn btn-default','escape' => false)); ?>
                        <?php echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Crédito', array('action'=>'../credits/add',$cliente['Client']['id']),array('class'=>'btn btn-success','escape' => false)); ?>

                    </td>
                </tr>
                <?php
                endforeach;?>
            </tbody>
        </table>
    </div>
</div>

  			

