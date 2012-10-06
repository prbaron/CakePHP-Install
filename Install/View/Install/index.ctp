<?php 
	$check = true;
?>

<div class="hero-unit">
	<h1><?php echo __("Configuration tests"); ?></h1>
</div> <!-- .hero-unit -->	

<div class="row">
	<div class="span12">
		<h2><?php echo __("Tests")?></h2>
		<?php			
			if (is_writable(TMP)) {
				$class = "success";
				$message = __("The TMP folder is writable");
			} else {
				$check = false;
				$class = "error";
				$message = __("The TMP folder is not writable");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';
		?>
		
		<?php
			if (is_writable(APP.'config')) {
				$class = "success";
				$message = __("The Config folder is writable");				
			} else {
				$check = false;
				$class = "error";
				$message = __("The Config folder is not writable");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';		
		?>
		
		<?php			
			if (version_compare(PHP_VERSION, '5.2.8', '>=')) {
				$class = "success";
				$message = __("PHP version is higher than minimal version required (".PHP_VERSION." > 5.2.8)");		
			} else {
				$check = false;				
				$class = "error";
				$message = __("PHP version is lower than minimal version required (".PHP_VERSION." < 5.2.8)");	
			}
			
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '<p></div>';
		?>
	</div> <!-- .span12 --> 
</div> <!-- .row -->

<div class="row">
	<div class="span12">
		<?php if($check): ?>
			<p><?php echo __("Your configuration passed all tests successfully. What do you want to do?"); ?></p>
			<div class="row" style="margin-top: 60px;">
				<div class="span6">
					<h2>Create new database</h2>
					<p>You want to create a new database and create the tables and entries associated.</p>
					
					<?php echo $this->Form->create('Install'); ?>
						<?php echo $this->Form->input('create', array(
							'type'  => 'hidden',
							'value' => 1
						)); ?>
						<div class="form-actions">
							<?php echo $this->Form->input("Create database", array(
								'label' => false,
								'type'  => 'submit',
								'class' => 'btn btn-primary'
							)); ?>
						</div>				
					<?php echo $this->Form->end();?>
				</div> <!-- .span -->
				
				<div class="span6">
					<h2>Connect to existing database</h2>
					<p>The database and tables are already created, you just want to connect your application.</p>
					
					<?php echo $this->Form->create('Install');?>
						<?php echo $this->Form->input("connect", array(
							'type'  => 'hidden',
							'value' => 1
						)); ?>
						<div class="form-actions">
							<?php echo $this->TB->input("Connect database", array(
								'label' => false,
								'type'  => 'submit',
								'class' => 'btn btn-primary'
							)); ?>
						</div>				
					<?php echo $this->Form->end();?>
				</div> <!-- .span -->
			</div> <!-- .row -->
		<?php else : ?>
			<div class="alert alert-error">
				<p><?php echo __("You configuration does not correspond to the minimal required. Please update it and retry."); ?></p>
			</div> <!-- .alert -->	
		<?php endif; ?>	
	</div> <!-- .span12 -->
</div> <!-- .row -->
