<?php
/**
 *
 * Controller for Install plugin
 *
 *
 * @author		Pierre Baron <prbaron22@gmail.com>
 *
 * @link		http://www.pierrebaron.fr
 * @package		app.Plugin.Install.Controller
 * @since		October 2012
 * @version		1.1
 */
class InstallController extends InstallAppController {
	/**
	 * Default configuration
	 *
	 * @access	public
	 * @return	void
	 */
	public $DEFAULT_CONFIG = array(
		'datasource' => 'Database/Mysql',
		'name'       => 'default',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'root',
		'password'   => 'root',
		'database'   => 'cakephp',
		'prefix'     => '',
		'encoding'   => 'UTF8',
	);
	
	/**
	 * beforeFilter
	 *
	 * @access	public
	 * @return	void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->layout = 'install';
	}
	
	/**
	 * Check wheter the installation file already exists
	 *
	 * @access	public
	 * @return	void
	 */
	protected function _check(){
		if(Configure::read('Database.installed') == 'true') {
			$this->Session->setFlash(__("Website already configured"));
			$this->redirect('/');	
		}
	}
	
	/**
	 * STEP 1 - CONFIGURATION TEST
	 *
	 * @access	public
	 * @return	void
	 */
	public function index() {
		$this->_check();
		$d['title_for_layout'] = __("Configuration test");
		$this->set($d);
		
		if($this->request->is('post')) {
			if(isset($this->request->data['Install']['create'])) {
				CakeSession::write('Install.create', true);
				$this->redirect(array('action' => 'database'));
			} else {
				CakeSession::write('Install.create', false);
				$this->redirect(array('action' => 'connection'));
			}
		}
	}


	
	/**
	 * STEP 2 - DATABASE CREATION
	 *
	 * @access	public
	 * @return	void
	 */
	public function database() {
		$this->_check();
		$d['title_for_layout'] = __("Database creation");
		$this->set($d);
	}
	
	
	
	/**
	 * STEP 3 - DATABASE CONNECTION TEST
	 *
	 * @access	public
	 * @return	void
	 */
	public function connection() {
		$this->_check();
		$d['title_for_layout'] = __("Database connection");
		if (!file_exists(CONFIG.'database.php')) {
			rename(CONFIG.'database.php.default', CONFIG.'database.php');
		}
	
		if($this->request->is('post')) {
			$this->Install->set($this->request->data);
			if(!$this->Install->validates()) {
				$this->Session->setFlash(__("Incomplete form, please fill all required fiealds"), "Install.alert");
				return false;
			}
			
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
						$create = CakeSession::read('Install.create');
						if($create) {
							$this->redirect(array('action' => 'data'));
						} else {
							$this->redirect(array('action' => 'finish'));
						}
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
	 *
	 * @access	public
	 * @return	void
	 */	
	public function data() {
		$this->_check();
		$d['title_for_layout'] = __("Database construction");
		
		if($this->request->is('post')) {
			App::uses('File', 'Utility');
			App::uses('CakeSchema', 'Model');
			App::uses('ConnectionManager', 'Model');
					
			$db = ConnectionManager::getDataSource('default');
	
			// connection to the database
			if(!$db->isConnected()) {
				$this->Session->setFlash(__("Cannot connect to the database"), "Install.alert");
			} else {
				copy(PLUGIN_CONFIG.'Schema/Schema.php.install', CONFIG.'Schema/Schema.php');

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
						/*$this->Session->setFlash(__("<strong>" .$table. "</strong> table already exists.You have to choose another one."), "Install.alert");
						$this->redirect(array('action' => 'database')); */
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
				if (!class_exists('Security')) {
					require CAKE_CORE_INCLUDE_PATH .DS. 'Cake' .DS. 'Utility' .DS. 'security.php';
				}
				if($this->request->data['Install']['salt'] == 1) {
				
					$salt = $this->Install->changeConfiguration('Security.salt', Security::generateAuthKey());
					if($salt) {		
						$users = $this->Install->query('SELECT * from users');
			
						foreach($users as $k => $v) {
							$v['users']['password'] = Security::hash($v['users']['username'], null, $salt);
							$this->Install->save($v);
						}
						
						CakeSession::write('Install.salt', true);
			
					} else { 
						$this->Session->setFlash(__("Error when generating new salt key"), 'Install.alert');	
						return false; 
					}
				} else {
						CakeSession::write('Install.salt', false);
				}
				
				if($this->request->data['Install']['seed'] == 1) {
					$this->Install->changeConfiguration('Security.cipherSeed', mt_rand() . mt_rand());
					CakeSession::write('Install.seed', true);
				} else {
					CakeSession::read('Install.seed', false);
				}
				$this->redirect(array('action' => 'finish'));
			}	
		}
		
		$this->set($d);
	} // function



	/**
	 * STEP 5 - INSTALLATION COMPLETE
	 *
	 * @access	public
	 * @return	void
	 */	
	public function finish() {
		$this->_check();
		$d['title_for_layout'] = __("Installation complete");
		$path = PLUGIN_CONFIG.'bootstrap.php';
		if(!$this->Install->changeConfiguration('Database.installed', 'true', $path)){
			$this->Session->setFlash(__("Cannot modify Database.installed variable in app/Plugin/Install/Config/bootstrap.php"), 'Install.alert');
		}
		
		if($this->request->is('post')) {
			CakeSession::delete('Install.create');
			CakeSession::delete('Install.salt');
			CakeSession::delete('Install.seed');
			
			$this->redirect('/');
		}
	
		$this->set($d);
	}
	
}