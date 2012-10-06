<div class="hero-unit">
 	<h1><?php echo __("Database connection test"); ?></h1>
</div> <!-- .hero-unit -->


<div class="row">
	<div class="span12">
		<?php echo $this->Form->create('Install', array(
				'class' => 'form-horizontal'
			)); ?>
			
			<?php echo $this->TB->input('host', array(
				'label' 	=> __('Host'),
				'default'	=> 'localhost',
				'help_block'=> __("Host IP address")
			)); ?>
			
			<?php echo $this->TB->input('login', array(
				'label' 	=> __('Login'),
				'default'	=> 'root',
				'help_block'=> __("Database connection login")
			)); ?>
	
			<?php echo $this->TB->input('password', array(
				'label' 	=> __('Password'),
				'default'	=> '',
				'help_block'=> __("Database connection password"),
				'type' 		=> 'password'
			)); ?>
						
			<?php echo $this->TB->input('database', array(
				'label' 	=> __('Database'),
				'default'	=> 'cakephp',
				'help_block'=> __("Database name")
			)); ?>
			
			<?php echo $this->TB->input('prefix', array(
				'label' 	=> __('Prefix'),
				'default'	=> '',
				'help_block'=> __("Database prefix")
			)); ?>
		
			<div class="form-actions">	
				<?php echo $this->Form->input(__("Connection"), array(
					'type' => 'submit', 
					'label' => false,
					'class' => 'btn btn-primary')); ?>
			</div> <!-- .form-actions -->
			
		<?php echo $this->Form->end();?>	
	</div> <!-- .span12 -->
</div> <!-- .row -->