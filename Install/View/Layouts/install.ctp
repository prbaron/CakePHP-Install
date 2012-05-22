<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Install | <?php echo $title_for_layout; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css(array('Install.bootstrap.min', 'Install.style'));

	echo $this->fetch('meta');
	echo $this->fetch('css');
?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a href="#" class="brand">INSTALLATION</a>
				
				<div class="nav-collapse">
					<ul class="nav">
						<?php $active = $this->params['action']; ?>

						<li class="<?php echo $active=="index" ? 'active':''; ?>"><a href="">Step 1</a></li>
						<li class="<?php echo $active=="database" ? 'active':''; ?>"><a href="">Step 2</a></li>
						<li class="<?php echo $active=="connection" ? 'active':''; ?>"><a href="">Step 3</a></li>
						<li class="<?php echo $active=="data" ? 'active':''; ?>"><a href="">Step 4</a></li>
						<li class="<?php echo $active=="finish" ? 'active':''; ?>"><a href="">Step 5</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<!-- nocache -->
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>
		
		<hr>
		<footer>
			<p class="pull-right">Pierre Baron. &copy; 2012 - <?php echo date("Y"); ?>.</p>
			<p>
				Developped with the <?php echo $this->Html->link("CakePHP", "http://cakephp.org");?> Framework.<br/>
				Designed with <?php echo $this->Html->link("Twitter Bootstrap", "http://twitter.github.com/bootstrap/");?>.
			</p>
		</footer>	
	</div> <!-- /container -->
		

</body>
</html>
