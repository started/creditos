<?php
$monthText = array( '01' =>'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
?>
<div class="content-box-large">
    <div class="panel-heading">
        <div class="panel-title">
            Créditos por pagar <?php echo $monthText[$month] ." - ". $year; ?>
        </div>
        <?php //echo $this->Html->link('<i class="glyphicon glyphicon-plus"></i> Crédito', array('action'=>'add'),array('class'=>'btn btn-success btn-xs','escape' => false)); ?>
        
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6">
        <?php echo $this->Form->create(null,array('url' => 'month', 'inputDefaults' => array('div' => false ))); ?>
        <div class="row">
            <div class="col-md-4">
                <?php echo $this->Form->input('month', array('type'=>'select', 'label'=>false, 'options' => $monthText, 'class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $this->Form->input('year', array('type'=>'select', 'label'=>false, 'options' => array(date('Y') => date('Y'),date('Y')+1,date('Y')+2,date('Y')+3,date('Y')+4), 'class' => 'form-control')); ?>
            </div>
            <div class="col-md-4">
                <?php echo $this->Form->end(array('label' => 'Ver','class'=>'btn btn-primary','div' => false)); ?>
            </div>
        </div>
            
        <div class="col-md-6"></div>
    </div> 
    <div class="panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Estado</th>
                    <th>Producto</th>
                    <th>Precio Producto</th>
                    <th>Interés</th>
                    <th>Cuotas</th>
                    <!--<th>Primera Cuota</th>-->
                    <th>Financiamiento</th>
                    <th>Fecha</th>
                    <th>Siguiente Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php
//                debug($creditos);
                foreach ($creditos as $key => $credito):?>
                <tr class="<?php echo ($credito['Credit']['status']==1)? 'danger':'success';?>">
                    <td><?php echo $credito['Credit']['id']?></td> 
                    <td><?php echo $credito['Credit']['status']?></td>
                    <td><?php echo $credito['Credit']['product_name']?></td> 
                    <td><?php echo $credito['Credit']['product_price']?></td> 
                    <td><?php echo $credito['Credit']['interest']?></td>
                    <td><?php echo $credito['Credit']['term']?></td>
                    <!--<td><?php //echo $credito['Credit']['down_payment']?></td>-->
                    <td><?php echo $credito['Credit']['financing']?></td>
                    <td class="odd gradeX"><?php echo $credito['Credit']['date']?></td>
                    <td>
                    <?php
                        if(empty($credito['Payment'])):
                            echo $credito['Credit']['first_payment'];
                        else:
                            $lastPayment = count($credito['Payment'])-1;
                            echo $credito['Payment'][$lastPayment]['next_payment'];
                        endif;        
                    ?> 
                    </td>
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

  			



