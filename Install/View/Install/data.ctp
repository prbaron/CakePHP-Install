<div class="hero-unit">
 	<h1><?php echo __("Step 4"); ?></h1>
 	<p><?php echo __("Database construction")?></p>
 	<br/><strong><?php echo __("Progression"); ?> - &nbsp;&nbsp;&nbsp;&nbsp;75%</strong>
 	<div class="progress progress-striped progress-info">
	 	<div class="bar " style="width: 75%"></div>
	</div> <!-- .progress -->
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Database connection test"); ?></h2>
		
		<p><?php echo __("We are successfully connected to the database, clic on the link below to construct it."); ?></p>
		
		<?php echo $this->Form->postLink(__("Construct the database"), array(
							'plugin'		=> 'install',
							'controller'	=> 'install',
							'action'		=> 'data'), array('class' => 'btn btn-primary')); ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->