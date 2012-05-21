## Install-CakePHP-Plugin
The Install plugin allows you to install your tables and entries with a GUI.

## Installation
1. First, Copy the **Install** folder in _app/plugin_.
2. In your _app/Config/bootstrap.php_ file, you have to load the plugin by adding this line : 

```php
    <?php CakePlugin::load('Install'); ?>
```
3. In your _app/Config/routes.php_, add the following lines at the beginning of the file : 

```php
  <?php
    if (!file_exists(APP. 'Config' .DS. 'installed.txt')) {
        CakePlugin::load('Install');
        Router::connect('/', array('plugin' => 'install', 'controller' => 'install'));
    }
  ?>  
```

4. Copy the _Schema.php_ file to _app/Config/Schema_.
5. You can now install your database, tables and default entries

## Configuration
You probably want to add tables and/or entries to your plugin, here the steps :

### Tables
The tables are coded in the _app/Config/Schema/Schema.php_ file.
The variable name should be the name of your table. You add all your fields in the array.

### Entries
The entries are coded in the _app/Plugin/Install/Config/data/_ folder. You have to create a file for each table. 
The name of the file has to be the model name followed by Data (for exemples, the table is 'categories' so the file name
is CategoryData.php).

each entry has to be in the $records array. You add the fields as keys and the values are your entries. Don't forget to 
fill all the fields

## Credits
Install-CakePHP-Plugin is a 2.x version of the Croogo Install Plugin.
Pierre Baron.

Pierre Baron is a software and home automation Engineer specialized in web and mobile development.

