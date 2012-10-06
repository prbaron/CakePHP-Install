<div class="hero-unit">
	<h1><?php echo __("Installation complete!"); ?></h1>
</div> <!-- .hero-unit -->


<div class="row">
	<div class="span12">
		<p><?php echo __("Your database has been correctly installed, you can now configure your website"); ?></p>
		<?php if(CakeSession::read('Install.salt') && CakeSession::read('Install.seed')) : ?>
			<div class="alert alert-block alert-info">
				<h4 class="alert-heading">Don't change your salt and seed keys !</h4>
				<p>The plugin already did it. It has also rehashed the passwords using the new keys.</p>
			</div>
		<?php else : ?>
			<?php if(!CakeSession::read('Install.salt')): ?>
				<div class="alert alert-info">
					You have to change your salt key!
				</div>
			<?php endif; ?>
			<?php if(!CakeSession::read('Install.seed')): ?>
				<div class="alert alert-info">
					You have to change your seed key!
				</div>
			<?php endif; ?>
		<?php endif;?>
	</div> <!-- .span12 -->
</div> <!-- .row -->

<div class="row">
	<div class="span12">
		<?php echo $this->Form->create('Install');?>
			<div class="form-actions">
				<?php echo $this->Form->input("Go to website", array(
					'type'  => 'submit',
					'label' => false,
					'class' => 'btn btn-primary'
				)); ?>
			</div>	
		<?php echo $this->Form->end();?>
	</div> <!-- .span -->
</div> <!-- .row-->