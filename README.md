## Install-CakePHP-Plugin
The Install plugin allows you to install your tables and entries with a GUI such as the Wordpress installation process.

You want to recreate the easy installation process from Wordpress to your cakephp app? This plugin is for you!

You can see screenshots in the website: http://prbaron.github.com/Install-CakePHP-Plugin/

## Installation
1. Copy the **Install** folder to _app/Plugin/_.
2. Go to http://localhost/{your_cakephp_app}/install/
3. You can now install your database, tables and default entries

## Configuration
You probably want to add tables and/or entries to your plugin, here the steps :

### Tables
The tables are coded in the _app/plugin/Install/Config/Schema/Schema.php.install_ file.
The variable name should be the name of your table. You add all your fields in the array.

### Entries
The entries are coded in the _app/Plugin/Install/Config/data/_ folder. You have to create a file for each table. 
The name of the file has to be the model name followed by Data (for exemples, the table is 'categories' so the file name
is CategoryData.php).

each entry has to be in the $records array. You add the fields as keys and the values are your entries. Don't forget to 
fill all the fields

## Credits
Install-CakePHP-Plugin is a 2.x version of the Croogo Install Plugin.

Pierre Baron. <prbaron22@gmail.com>

Pierre Baron is a software and home automation Engineer specialized in web and mobile development.

