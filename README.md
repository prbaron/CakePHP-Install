## Install-CakePHP-Plugin

/!\ THIS PLUGIN IS NO LONGER UNDER DEVELOPMENT ! /!\ It should work on 2.5.x but I do not garantee it.

The Install plugin allows you to install your tables and entries with a GUI such as the Wordpress installation process.

You want to recreate the easy installation process from Wordpress to your cakephp app? This plugin is for you!

The Install plugin allows you to install your tables and entries with a GUI such as the Wordpress installation process.You want to recreate the easy installation process from Wordpress to your cakephp app? This plugin is for you!

### Installation

  - Download the code from <a href="https://github.com/prbaron/CakePHP-Install">https://github.com/prbaron/CakePHP-Install</a>.
  - Copy the **Install** folder to __app/Plugin/__.
  - Add the following code to **app/Config/bootstrap.php**

```
CakePlugin::load(array(
    'Install' => array('bootstrap' => true, 'routes' => true)
));
```

  - Go to http://localhost/{your_cakephp_app}/install/
  - You can now install your database, tables and default entries

### Configuration
You probably want to add tables and/or entries to your plugin, here the steps :

#### Tables
The tables are coded in the __app/plugin/Install/Config/Schema/Schema.php.install__ file. The variable name should be the name of your table. You add all your fields in the array.

```
var $posts = array(
	'id'       => array('type' => 'integer',  'null' => false, 'default' => NULL, 'length' => '10', 'key' => 'primary'),
	'title'    => array('type' => 'string',   'null' => false, 'default' => NULL, 'length' => '50'),
	'body'     => array('type' => 'text',     'null' => false, 'default' => NULL),		
	'created'  => array('type' => 'datetime', 'null' => false, 'default' => NULL),
	'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL)		
);
```

#### Entries
The entries are coded in the __app/Plugin/Install/Config/data/__ folder. You have to create a file for each table. The name of the file has to be the model name followed by Data (for exemples, the table is 'categories' so the file name is CategoryData.php).

each entry has to be in the $records array. You add the fields as keys and the values are your entries. Do not forget to fill all the fields.

```
<?php
/**
 * Entries for the model Post
 */
class PostData {
	/**
	 * name of the table
	 */
	public $table = 'posts';
	
	/**
	 * the entries
	 */
	public $records = array(
		array(
			'id'        => '1',
			'title'     => 'The Title',
			'body'      => 'This is the post body',
			'created'   => '2012-03-01 12:00:00',
			'modified'  => '2012-03-01 12:00:00'
		)
	);
}		
```

### Credits
CakePHP-Install is based on the Croogo Install Plugin.
