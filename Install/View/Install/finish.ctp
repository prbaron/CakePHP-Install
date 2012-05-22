<div class="hero-unit">
	<h1><?php echo __("Step 4"); ?></h1>
	<p><?php echo __("Installation complete!"); ?></p>
	<br/><strong><?php echo __("Progression"); ?>) - &nbsp;&nbsp;&nbsp;&nbsp;100%</strong>
	<div class="progress progress-striped progress-info">
  		<div class="bar" style="width: 100%"></div>
	</div> <!-- .progress -->
</div> <!-- .hero-unit -->


<div class="row">
	<div class="span12">
		<p><?php echo __("Your database has been correctly installed, you can now configure your website"); ?></p>
		
		<div class="well">
			<p>
				<strong><?php echo __("Admin panel"); ?> : </strong> <?php echo $this->Html->link(Router::url('/admin', true), Router::url('/admin', true)); ?> 
				<br/>
				<strong><?php echo __("Login"); ?> :</strong> admin
				<br/>
				<strong><?php echo __("Password"); ?> :</strong> admin		
			</p>
		</div> <!-- .well -->
		
		<?php echo $this->Html->link(__("Go to the admin panel"), Router::url('/admin', true), array('class' => 'btn btn-primary')); ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->