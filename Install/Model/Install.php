<?php
/**
 *
 * Model for Install plugin
 *
 *
 * @author		Pierre Baron <prbaron22@gmail.com>
 *
 * @link		http://www.pierrebaron.fr
 * @package		app.Plugin.Install.Model
 * @since		October 2012
 * @version		1.1
 */
class Install extends InstallAppModel {
	/**
	 * no database for the Model
	 *
	 * @ignore
	 */
	var $useTable = false;
	
	/**
	 * Validation rules for Install plugin
	 *
	 * @access	public
	 * @return	void
	 */
	public $validate = array(
		'host' 	=> array(
			'rule' 		=> 'notEmpty',
			'message' 	=> "Please, enter a host"
		),
		'login' => array(
			'rule' 		=> 'notEmpty',
			'message'	=> "Please, enter your login",
		),
		'database' => array(
			'rule'		=> 'notEmpty',
			'message'	=> "Please, enter the database name"	
		)
	);
	
	/**
	 * Modify security keys in app/Config/core.php
	 *
	 * @access	public
	 * @param	string	the key to change
	 * @param	string	the new value
	 * @return	string|boolean	the new value if OK, FALSE else.
	 */
	public function changeConfiguration($key, $value, $path = '') {
		/**
		 * we modify security key to be unique on each app
		 */
		if($path == '') $path = CONFIG.'core.php';
		
		App::uses('File', 'Utility');
		$file = new File($path);
		$contents = $file->read();
		$contents = preg_replace('/(?<=Configure::write\(\''.$key.'\', \')([^\' ]+)(?=\'\))/', $value, $contents);
		
		if($file->write($contents)) { return $value; }
		else { return false; }		
	}
}