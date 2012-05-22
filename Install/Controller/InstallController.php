<?php 
define('CONFIG', APP. 'Config' .DS);
define('PLUGIN_CONFIG', APP. 'Plugin' .DS. 'Install' .DS. 'Config' .DS);

class InstallController extends InstallAppController {
	/**
	* Default configuration
	*/
	public $DEFAULT_CONFIG = array(
		'datasource' => 'Database/Mysql',
		'name' => 'default',
		'persistent'=> false,
		'host'=> 'localhost',
		'login'=> 'root',
		'password'=> 'root',
		'database'=> 'isea',
		'prefix'=> '',
		'encoding' => 'UTF8',
	);
	
	/**
	* beforeFilter
	*/
	public function beforeFilter() {
		parent::beforeFilter();

		$this->layout = 'install';
	}
	
	/**
	* Check wheter the installation file already exists
	*/
	protected function _check(){
		if(file_exists(CONFIG. 'installed.txt')) {
			$this->Session->setFlash(__("Website already configured"));
			$this->redirect('/');	
		}
	}
	
	/**
	* STEP 1 - CONFIGURATION TEST
	*/
	public function index() {
		$this->_check();
		$d['title_for_layout'] = __("Step 1 - Confuration test");
		$this->set($d);
	}


	
	/**
	* STEP 2 - DATABASE CREATION
	*/
	public function database() {
		$this->_check();
		$d['title_for_layout'] = __("Step 2 - Database creation");
		$this->set($d);
	}
	
	
	
	/**
	* STEP 3 - DATABASE CONNECTION TEST
	*/
	public function connection() {
		$this->_check();
		$d['title_for_layout'] = __("Step 3 - Database connection");
		
		if($this->request->is('post')) {
			// loads ConnectionManager class
			App::uses('ConnectionManager', 'Model');
			
			// loads the default configuration
			$config = $this->DEFAULT_CONFIG;
			
			// loads form data
			$data = $this->request->data['Install'];
			
			// replaces default config by form data
			foreach($data as $k => $v) {
				if(isset($data[$k])) {
					$config[$k] = $v;
				}
			}
			
			try {
				/**
				* Try to connect the database with the new configuration
				*/
				ConnectionManager::create('default', $config); 
				$db = ConnectionManager::getDataSource('default');
				if(!$db->isConnected()) {
					$this->Session->setFlash(__("Cannot connect to the database"), "Install.alert");
				} else {
					/**
					* We will create the true database.php file with our configuration
					*/
					App::uses('File', 'Utility');
					copy(PLUGIN_CONFIG.'database.php.install', CONFIG.'database.php');
					$file = new File(CONFIG. 'database.php', true);
					$content = $file->read();
					
					foreach($config as $k => $v) {
						$content = str_replace('{default_' .$k.  '}', $v, $content);
					}	
					
					if($file->write($content)) {
						$this->Session->setFlash(__("Connected to the database"), "Install.alert", array('type' => 'success'));	
						$this->redirect(array('action' => 'data'));
					} else {
						$this->Session->setFlash(__("database.php file cannot be modified"), "Install.alert");				
					}	
				}	
			} catch(Exception $e) {
				$this->Session->setFlash(__("Cannot connect to the database"), "Install.alert");
			}				
		} // post

		$this->set($d);
	} //function
	
	
	
	
	/**
	* STEP 4 - DATABASE CONSTRUCTION
	*/	
	public function data() {
		$this->_check();
		$d['title_for_layout'] = __("Step 4 - Database construction");
		
		if($this->request->is('post')) {
			App::uses('File', 'Utility');
			App::uses('CakeSchema', 'Model');
			App::uses('ConnectionManager', 'Model');
					
			$db = ConnectionManager::getDataSource('default');
	
			// connection to the database
			if(!$db->isConnected()) {
				$this->Session->setFlash(__("Cannot connect to the database"), "Install.alert");
			} else {
				// fetches all information of the tables of the Schema.php file (app/Config/Schema/Schema.php)
				$schema = new CakeSchema(array('name' => 'app'));
				$schema = $schema->load();
				
				/**
				* saves the table in the database
				*/				
				foreach($schema->tables as $table => $fields) {
					$create = $db->createSchema($schema, $table);
					try{
						$db->execute($create);
					} catch(Exception $e) {
						$this->Session->setFlash(__("<strong>" .$table. "</strong> table already exists.You have to choose another one."));
						$this->redirect(array('action' => 'database'));
					}
				}
				
				/**
				* fetches an array containing all entries for the database
				*/
				$dataObjects = App::objects('class', PLUGIN_CONFIG. 'data' .DS);
	
				foreach ($dataObjects as $data) {
					// loads all classes contained in app/Plugin/Install/Config/data/
					App::import('Install.Config/data', $data);
					
					// fetches all objects from the classes
					$classVars = get_class_vars($data);
					// fetches class name
					$modelAlias = substr($data, 0, -4);
					
					// fetches table name	
					$table = $classVars['table'];
					
					// fetches all entries
					$records = $classVars['records'];
					App::uses('Model', 'Model');
					$modelObject = new Model(array(
						'name'	=> $modelAlias,
						'table' => $table,
						'ds'	=> 'default',
					));
					
					/**
					* We will save each entry in the database
					*/
					if (is_array($records) && count($records) > 0) {
						foreach($records as $record) {
							$modelObject->create($record);
							$modelObject->save();
						}
					}
				}
				
				$this->redirect(array('action' => 'finish'));
			}	
		}
		
		$this->set($d);
	} // function



	/**
	* STEP 5 - INSTALLATION COMPLETE
	*/	
	public function finish() {
		$this->_check();
		$d['title_for_layout'] = __("Step 4 - Installation complete");

		/**
		* Changes the encryption keys to be unique for each application 
		*/
		App::uses('File', 'Utility');
		$file = new File(CONFIG. 'core.php');
		if (!class_exists('Security')) {
			require CAKE . 'Utility/Security.php';
		}
		$salt = Security::generateAuthKey();
		$seed = mt_rand() . mt_rand();
		$contents = $file->read();
		$contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
		$contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
		
		/**
		* Recreates the passwords for each user with the news encryption keys
		*/
		if($file->write($contents)) {
			$users = $this->Install->query('SELECT * from users');
			foreach($users as $k => $v) {
				$v['users']['password'] = Security::hash($v['users']['username'], null, $salt);
				$this->Install->save($v);
			}

			// copies the installed.txt file to app/config
			copy(PLUGIN_CONFIG.'installed.txt.install', CONFIG.'installed.txt');

		} else { return false; }

		$this->set($d);
	}
	
}
?>