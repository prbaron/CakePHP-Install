<?php 
class AppSchema extends CakeSchema {
	var $name = 'App';
	
	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	} 
	
	
	var $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL,	'length' => '10', 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => '50'),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL),		
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL)		
	);
	
	var $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => '10', 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => '50', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => '50', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => '20', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL)
	);
}
?>