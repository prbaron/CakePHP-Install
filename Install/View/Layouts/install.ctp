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
				<a href="#" class="brand">CakePHP-Install</a>
				
				<div class="nav-collapse pull-right">
					<ul class="nav">
						<li><a href="http://www.pierrebaron.fr">Plugin by Pierre Baron</a></li>
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
