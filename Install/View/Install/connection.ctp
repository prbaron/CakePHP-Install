<div class="hero-unit">
 	<h1><?php echo __("Step 3"); ?></h1>
 	<p><?php echo __("Database connection test"); ?></p>
 	<br/><strong><?php echo __("Progression"); ?> - &nbsp;&nbsp;&nbsp;&nbsp;50%</strong>
 	<div class="progress progress-striped progress-info">
		<div class="bar" style="width: 50%"></div>
	</div> <!-- .progress -->
</div> <!-- .hero-unit -->


<div class="row">
	<div class="span12">
		<?php echo $this->Form->create('Install', array(
				'url' 			=> array(
					'plugin'		=> 'install',
					'controller'	=> 'install',
					'action'		=> 'connection'), 
				'inputDefaults' => array(
					'label' 		=> false,
					'div'			=> array('class' => 'control-group'),
					'error'			=> array(
						'attributes'	=> array(
							'class'			=> 'help-inline',
				))),
				'class' 		=> 'form-horizontal'
			)); ?>
			
			
		<div class="control-group">
			<?php echo $this->Form->label('Install.host', __("Host"), array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $this->Form->input('host', array('default' => 'localhost')); ?>
				<p class="help-block"><?php echo __("Host IP address"); ?></p>
			</div> <!-- .controls -->
		</div> <!-- .control-group -->

		<div class="control-group">
			<?php echo $this->Form->label('Install.login', __("Login"), array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $this->Form->input('login', array('default' => 'root')); ?>
				<p class="help-block"><?php echo __("Database connection login"); ?></p>
			</div> <!-- .controls -->
		</div> <!-- .control-group -->			

		<div class="control-group">
			<?php echo $this->Form->label('Install.password', __("Password"), array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $this->Form->input('password'); ?>
				<p class="help-block"><?php echo __("Database connection password"); ?></p>
			</div> <!-- .controls -->
		</div> <!-- .control-group -->	

		<div class="control-group">
			<?php echo $this->Form->label('Install.database', __("Database"), array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $this->Form->input('database', array('default' => 'cakephp')); ?>
				<p class="help-block"><?php echo __("Database name"); ?></p>
			</div> <!-- .controls -->
		</div> <!-- .control-group -->	

		<div class="control-group">
			<?php echo $this->Form->label('Install.prefix', __("Prefix"), array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $this->Form->input('prefix'); ?>
				<p class="help-block"><?php echo __("Database prefix"); ?></p>
			</div> <!-- .controls -->
		</div> <!-- .control-group -->			

			<div class="form-actions">	
				<?php echo $this->Form->input(__("Connection"), array(
					'type' => 'submit', 
					'label' => false,
					'class' => 'btn btn-primary')); ?>
			</div> <!-- .form-actions -->
		<?php echo $this->Form->end();?>	
	</div> <!-- .span12 -->
</div> <!-- .row -->