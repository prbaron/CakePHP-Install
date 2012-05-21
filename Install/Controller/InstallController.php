<?php 
define('CONFIG', APP. 'Config' .DS);
define('PLUGIN_CONFIG', APP. 'Plugin' .DS. 'Install' .DS. 'Config' .DS);

class InstallController extends InstallAppController {
	
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
	* Cette fonction test si le fichier d'installation existe déjà afin de ne pas réinstaller la base
	*/
	protected function _check(){
		if(file_exists(CONFIG. 'installed.txt')) {
			$this->Session->setFlash(__("Website already configured"));
			$this->redirect('/');	
		}
	}
	
	/**
	* ETAPE 1 - TEST DE LA CONFIGURATION
	*
	* Nous allons tester si les configurations minimales sont ok pour continuer
	*/
	public function index() {
		$this->_check();
		$d['title_for_layout'] = __("Step 1 - Confuration test");
		$this->set($d);
	}


	
	/**
	* ETAPE 2 - CREATION DE LA BASE DE DONNEES
	*
	* Nous allons afficher les instructions pour créer la BDD
	*/
	public function database() {
		$this->_check();
		$d['title_for_layout'] = __("Step 2 - Database creation");
		$this->set($d);
	}
	
	
	
	/**
	* ETAPE 3 - TEST DE LA CONNEXION A LA BASE DE DONNEES
	*
	* Nous allons tester la connexion à la base de données
	*/
	public function connection() {
		$this->_check();
		$d['title_for_layout'] = __("Step 3 - Database connection");
		// si on soumet le formulaire
		if($this->request->is('post')) {
			// on charge la classe ConnectionManager
			App::uses('ConnectionManager', 'Model');
			
			// on charge la configuration par défaut
			$config = $this->DEFAULT_CONFIG;
			
			// on charge les données du formulaire
			$data = $this->request->data['Install'];
			
			// on réécrit la config par défaut avec les données du formulaire
			foreach($data as $k => $v) {
				if(isset($data[$k])) {
					$config[$k] = $v;
				}
			}
			
			try {
				ConnectionManager::create('default', $config); 
				$db = ConnectionManager::getDataSource('default');
				if(!$db->isConnected()) {
					$this->Session->setFlash(__("Cannot connect to the database"));
				} else {
					App::uses('File', 'Utility');
					copy(PLUGIN_CONFIG.'database.php.install', CONFIG.'database.php');
					$file = new File(CONFIG. 'database.php', true);
					$content = $file->read();
					
					foreach($config as $k => $v) {
						$content = str_replace('{default_' .$k.  '}', $v, $content);
					}	
					
					if($file->write($content)) {
						$this->Session->setFlash(__("Connected to the database"));						
						$d['connection'] = 1;
						$this->set($d);
					} else {
						$this->Session->setFlash(__("database.php file cannot be modified"));				
					}	
				}	
			} catch(Exception $e) {
				$this->Session->setFlash(__("Cannot connect to the database"));
			}				
		} // post

		$this->set($d);
	} //function
	
	
	
	
	/**
	* ETAPE 3.5 - CONSTRUCTION DE LA BASE DE DONNEES
	*
	* Nous allons construire la base de données
	*	- création des tables
	*	- création des entrées par défaut dans les tables
	*
	* Cette étape n'a pas de vue associées. 
	* Elle se redirige vers finish si tout est correcte.
	* Elle se rediriger vers databse si il y a une erreur
	*/	
	public function data() {
		$this->_check();
		App::uses('File', 'Utility');
		App::uses('CakeSchema', 'Model');
		App::uses('ConnectionManager', 'Model');
				
		$db = ConnectionManager::getDataSource('default');

		// test pour être sur de se connecter à la BDD
		if(!$db->isConnected()) {
			$this->Session->setFlash(__("Cannot connect to the database"));
		} else {
			// Récupère les informations des tables du fichier Schema.php situé dans app/Config/Schema/
			$schema = new CakeSchema(array('name' => 'app'));
			$schema = $schema->load();
			
			// enregistre les tables dans la base de données
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
			* récupère un tableau contenant les objets que le Controller App connait
			* ex: FloorData, UserData, ...
			*/
			$dataObjects = App::objects('class', PLUGIN_CONFIG. 'data' .DS);

			foreach ($dataObjects as $data) {
				// charge les classes contenues dans app/Plugin/Install/Config/data/
				App::import('Install.Config/data', $data);
				
				// récupère les objets contenus dans les classes
				$classVars = get_class_vars($data);
				// récupère le nom de la classe
				$modelAlias = substr($data, 0, -4);
				
				// récupère le nom de la table
				$table = $classVars['table'];
				
				// récupère toutes les entrées
				$records = $classVars['records'];
				App::uses('Model', 'Model');
				$modelObject = new Model(array(
					'name'	=> $modelAlias,
					'table' => $table,
					'ds'	=> 'default',
				));
				
				// Pour chaque entrée, nous allons l'enregistrer dans la BDD
				if (is_array($records) && count($records) > 0) {
					foreach($records as $record) {
						$modelObject->create($record);
						$modelObject->save();
					}
				}
			}
			
			$this->redirect(array('action' => 'finish'));
		}
	} // function



	/**
	* ETAPE 4 - FINI
	*
	* Nous allons créer le fichier d'installation et indiquer à l'utilisateur que l'installation est finie
	*/	
	public function finish() {
		$this->_check();
		$d['title_for_layout'] = __("Step 4 - Installation complete");
		
		// on copie le fichier installed.txt dans le dossier app/Config/
		copy(PLUGIN_CONFIG.'installed.txt.install', CONFIG.'installed.txt');
		
		/**
		* Nous allons modifier les clés de cryptage afin qu'elles soient uniques à chaque application
		*/
		App::uses('File', 'Utility');
		$file = new File(CONFIG. 'core.php');
		if (!class_exists('Security')) {
			require LIBS . 'security.php';
		}
		$salt = Security::generateAuthKey();
		$seed = mt_rand() . mt_rand();
		$contents = $file->read();
		$contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
		$contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
		
		/**
		* on recrée les mots de passe avec les nouvelles clés de cryptage
		*/
		if($file->write($contents)) {		
			
			App::import('Model', 'User');
			$User = new User();
			
			$users = $User->find('all');

			foreach($users as $k => $v) {
				$v['User']['password'] = Security::hash($v['User']['username'], null, $salt);
				$User->save($v);
			}

		} else { return false; }

		$this->set($d);
	}
	
}
?>