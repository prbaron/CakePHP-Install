<?php 
class Install extends InstallAppModel {
	/**
	 * no database for the Model
	 */
	var $useTable = false;
	
	
	/**
	 * Modify security keys in app/Config/core.php
	 *
	 * @access	public
	 * @return	string|boolean	the new salt key if ok, FALSE else.
	 */
	public function updateSecurityKeys() {
		/**
		 * we modify security key to be unique on each app
		 */
		App::uses('File', 'Utility');
		$file = new File(CONFIG. 'core.php');
		if (!class_exists('Security')) {
			require CAKE_CORE_INCLUDE_PATH .DS. 'Cake' .DS. 'Utility' .DS. 'security.php';
		}
		$salt = Security::generateAuthKey();
		$seed = mt_rand() . mt_rand();
		$contents = $file->read();
		$contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
		$contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
		
		if($file->write($contents)) { return $salt; }
		else { return false; }		
	}
	
	/**
	 * Modify the Database.installed variable in Install/Config/bootstrap.php
	 *
	 * @access	public
	 * @return	string|boolean	TRUE if ok, FALSE else
	 */
	public function writeInstallationVariable() {
		App::uses('File', 'Utility');
		$file = new File(PLUGIN_CONFIG. 'bootstrap.php');
		$contents = $file->read();
		debug($contents);
		$contents = preg_replace('/(?<=Configure::write\(\'Database.installed\', )([^\' ]+)(?=\))/', 'true', $contents);

		if($file->write($contents)) { return true; }
		else { return false; }		
	}

}