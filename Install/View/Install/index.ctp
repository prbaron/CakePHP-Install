<?php 
	$check = true;
?>

<div class="hero-unit">
	<h1><?php echo __("Step 1"); ?></h1>
	<p><?php echo __("Configuration test"); ?></p>
	<br/><strong><?php echo __("Progression"); ?> - &nbsp;&nbsp;&nbsp;&nbsp;0%</strong>
	<div class="progress progress-striped progress-info">
	 	<div class="bar" style="width: 0%"></div>
	</div> <!-- .progress -->
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
		<h2><?php echo __("Installation"); ?></h2>
		<?php if($check): ?>
			<p><?php echo __("Your configuration passed all tests successfully. You can now start creating the database"); ?></p>
			<p>
				<?php echo $this->Html->link(__("Step 2 - Create database"), array('action' => 'database'), array('class' => 'btn btn-primary')); ?>
			</p>
		<?php else : ?>
			<div class="alert alert-error">
				<p><?php echo __("You configuration does not correspond to the minimal required. Please update it and retry."); ?></p>
			</div> <!-- .alert -->	
		<?php endif; ?>	
	</div> <!-- .span12 -->
</div> <!-- .row -->
