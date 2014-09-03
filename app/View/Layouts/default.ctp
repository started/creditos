<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
<!--    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
	<?php
		echo $this->Html->meta('icon');

//		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                echo $this->Html->css('bootstrap.min');
                echo $this->Html->css('styles');
                echo $this->Html->css('forms');
                echo $this->Html->css('buttons');
                echo $this->Html->css('/vendors/datatables/dataTables.bootstrap');
                echo $this->Html->script('jquery');
                echo $this->Html->script('jquery-ui');
                echo $this->Html->script('bootstrap.min');
                echo $this->Html->script('/vendors/datatables/js/jquery.dataTables.min');
                echo $this->Html->script('/vendors/datatables/dataTables.bootstrap');
                echo $this->Html->script('custom');
                echo $this->Html->script('tables');
//                echo $this->Html->script('forms');
                
	?>
</head>
<body>
    <div class="header">
        <div class="container">
           <div class="row">
              <div class="col-md-5">
                 <!-- Logo -->
                 <div class="logo">
                     <h1><?php echo $this->Html->link($this->Html->image('beymaf.png'), '/', array('escape' => false)); ?></h1>
                 </div>
              </div>
              <div class="col-md-5">
                 <div class="row">
                   <div class="col-lg-12">
<!--                     <div class="input-group form">
                          <input type="text" class="form-control" placeholder="Search...">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Search</button>
                          </span>
                     </div>-->
                   </div>
                 </div>
              </div>
              <div class="col-md-2">
                 <div class="navbar navbar-inverse" role="banner">
                     <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                       <ul class="nav navbar-nav">
                         <li class="dropdown">
                           <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
                                <?php if($logged_in): ?>
                                    <?php //echo $current_user['username']; ?>
                                    <?php echo $this->Html->link($current_user['username'].'<b class="caret"></b>',array('controller'=>'users','action'=>'login'),array('class' => 'dropdown-toggle', 'data-toggle'=>'dropdown','escape' => false )); ?>
                                <?php else: ?>
                                    <?php echo $this->Html->link('Ingresar',array('controller'=>'users','action'=>'login'),array('class' => 'dropdown-toggle', 'data-toggle'=>'dropdown' )); ?>
                                <?php endif; ?>
                               <!--<b class="caret"></b>-->
                           <!--</a>-->
                           <ul class="dropdown-menu animated fadeInUp">
                             <li><a href="profile.html">Profile</a></li>
                             <li><?php echo $this->Html->link('Salir',array('controller'=>'users','action'=>'logout')); ?></li>
                           </ul>
                         </li>
                       </ul>
                     </nav>
                 </div>
              </div>
           </div>
        </div>
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-md-2">
                <div class="sidebar content-box" style="display: block;">
                    <ul class="nav">
                        <?php
                            $url = $this->Html->url();
//                            echo $url;
//                            $active = $this->request->here == $url? true: false;
                        ?>
                        <!-- Main menu -->
                        <li <?php echo ($url == '/creditos/')? "class='current'" : ''; ?>><?php echo $this->Html->link('<i class="glyphicon glyphicon-home"></i> Dashboard','/', array('escape' => false)); ?></li>
                        <li <?php echo ($url == '/creditos/clients')? "class='current'" : '';  ?> ><?php echo $this->Html->link('<i class="glyphicon glyphicon-user"></i> Clientes', array('controller' => 'clients', 'action'=>'index'),array('escape' => false)); ?></li>
                        <li <?php echo ($url == '/creditos/credits')? "class='current'" : '';  ?> ><?php echo $this->Html->link('<i class="glyphicon glyphicon-calendar"></i> Créditos', array('controller' => 'credits', 'action'=>'index'),array('escape' => false)); ?></li>
                        <li <?php echo ($url == '/creditos/users')? "class='current'" : '';  ?> ><?php echo $this->Html->link('<i class="glyphicon glyphicon-user"></i> Usuarios', array('controller' => 'users', 'action'=>'index'),array('escape' => false)); ?></li>

                    </ul>
                </div>
            </div>
            
            <div class="col-md-10">
                <!--<div class="row">-->
        
		<!--<div id="content">-->

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		<!--</div>-->
		
                <!--</div>-->
            </div>
        </div>
    </div>
<!--    <footer>
        <div class="container">

           <div class="copy text-center">
                <?php /*echo $this->Html->link(
                        $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
                        'http://www.cakephp.org/',
                        array('target' => '_blank', 'escape' => false)
                    );*/
                ?>
           </div>

        </div>
    </footer>-->
	<?php // echo $this->element('sql_dump'); ?>
</body>
</html>
