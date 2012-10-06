<div class="hero-unit">
 	<h1><?php echo __("Database construction")?></h1>
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Database connection test"); ?></h2>
		
		<p><?php echo __("We are successfully connected to the database, clic on the link below to construct it."); ?></p>							
		<?php echo $this->Form->create('Install', array(
			'class' => 'form-horizontal'
		));?>
			
			<?php echo $this->Form->input('salt', array(
				'label' => 'Regenerate new salt key',
				'type'  => 'checkbox',
				'value' => 1
			)); ?>
			
			<?php echo $this->Form->input('seed', array(
				'label' => 'Regenerate new seed key',
				'type'  => 'checkbox',
				'value' => 1
			)); ?>
			
			<div class="form-actions">
				<?php echo $this->Form->input("Connect database", array(
					'type'  => 'submit',
					'label' => false,
					'class' => 'btn btn-primary'
				)); ?>
			</div>	
		<?php echo $this->Form->end();?>
	</div> <!-- .span12 -->
</div> <!-- .row -->