<div class="hero-unit">
 	<h1><?php echo __("Step 2"); ?></h1>
 	<p><?php echo __("Database creation")?></p>
 	<br/><strong><?php echo __("Progression"); ?> - &nbsp;&nbsp;&nbsp;&nbsp;25%</strong>
 	<div class="progress progress-striped progress-info">
	 	<div class="bar " style="width: 25%"></div>
	</div> <!-- .progress -->
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Database creation in PhpMyAdmin");?></h2>
		<h3><?php echo __("Step 2.1 : Connection to PhpMyAdmin"); ?></h3>
		<p><?php echo __("To connect to PhpMyAdmin, you have to type the following url : ");?>
			<?php echo $this->Html->link("http://".$_SERVER['SERVER_NAME']."/phpMyAdmin/"); ?>.</p>
		<p><?php echo __("Type your login and password"); ?></p>
		
		<h3><?php echo __("Step 2.2 : Database creation"); ?></h3>
		<p><?php echo __("Please, clic on the Database tab."); ?></p>
		<?php echo $this->Html->image('Install.capture-1.jpg', array('class' => 'img-center')); ?>
		
		<p>
			<?php echo __("You just have to type the database name, here we will choose <strong>cakephp</strong>"); ?>
			<?php echo $this->Html->image('Install.capture-2.jpg', array('class' => 'img-center')); ?>
		
		<p><?php echo __("That's all!");?></p>

	</div> <!-- .span12 -->
</div> <!-- .row -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Database connection test"); ?></h2>
		<?php echo $this->Html->link(__("Step 3 - Database connection test"), array(
							'plugin'		=> 'install',
							'controller'	=> 'install',
							'action'		=> 'connection'), array('class' => 'btn btn-primary')); ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->