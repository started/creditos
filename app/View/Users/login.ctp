<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title_page; ?></title>
    <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php echo $this->Html->css('bootstrap.min');?>
    <!-- styles -->
    <?php echo $this->Html->css('styles');?>
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><?php echo $this->Html->link($this->Html->image('beymaf.png'), '/', array('escape' => false)); ?></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Login</h6>
                                        <?php echo $this->Session->flash('auth'); ?>
                                        <?php echo $this->Form->create('User',array('inputDefaults' => array('div' => false ))); ?>
                                        <?php echo $this->Form->input('username',array('label'=>false,'class'=>'form-control','placeholder'=>'Usuario'));
                                        echo $this->Form->input('password',array('label'=>false,'class'=>'form-control','placeholder'=>'Contraseña')); ?>
<!--			                <input class="form-control" type="text" placeholder="E-mail address">
			                <input class="form-control" type="password" placeholder="Password">-->
			                <div class="action">
			                    <!--<a class="btn btn-primary signup" href="index.html">Login</a>-->
                                            <?php echo $this->Form->end(array('label' => 'Ingresar','class'=>'btn btn-primary','div' => false)); ?>
			                </div>                
			            </div>
			        </div>
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <?php echo $this->Html->script('jquery'); ?>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php echo $this->Html->script('bootstrap.min');?>
    <?php echo $this->Html->script('custom'); ?>
  </body>
</html>



<?php //echo $this->Session->flash('auth'); ?>
<?php //echo $this->Form->create('User'); ?>
    
<?php //echo $this->Form->input('username'); 
      //echo $this->Form->input('password');?>
    
<?php //echo $this->Form->end(__('Login')); ?>
