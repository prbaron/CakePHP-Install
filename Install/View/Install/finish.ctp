<div class="hero-unit">
	<h1><?php echo __("Step 5"); ?></h1>
	<p><?php echo __("Installation complete!"); ?></p>
	<br/><strong><?php echo __("Progression"); ?>) - &nbsp;&nbsp;&nbsp;&nbsp;100%</strong>
	<div class="progress progress-striped progress-info">
  		<div class="bar" style="width: 100%"></div>
	</div> <!-- .progress -->
</div> <!-- .hero-unit -->


<div class="row">
	<div class="span12">
		<p><?php echo __("Your database has been correctly installed, you can now configure your website"); ?></p>
		<p><?php echo $this->Html->link(Router::url('/', true), Router::url('/', true), array('class' => 'btn btn-primary')); ?></p>
		
		<div class="alert alert-block">
			<h4 class="alert-heading">Don't change your salt and seed keys !</h4>
			<p>The plugin already did it. It has also rehashed the passwords using the new keys.</p>
		</div>
	</div> <!-- .span12 -->
</div> <!-- .row -->