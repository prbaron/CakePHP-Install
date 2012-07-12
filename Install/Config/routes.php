<?php
/**
 * Routes configuration
 *
 * If you want to launch the plugin on /, on the first install,
 * just paste the line CakePlugin::routes() above your routes commands in app/Config/routes.php
 */
	if(!Configure::read('Database.installed')) {
		Router::connect('/install/:controller/:action', array('plugin' => 'install', 'controller' => 'install'));
		Router::connect('/*', array('plugin' => 'install', 'controller' => 'install'));
	}

