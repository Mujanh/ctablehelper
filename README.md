#CTableHelper

CTableHelper is a HTML Helper that helps you create HTML tables. It is written in PHP
and is meant to be used with Anax-MVC.

##Installation
You can install the class ```CTableHelper``` with Composer and Packagist by adding the the ctablehelper
package to your composer.json file in your Anax-MVC:

```
"require": {
    "php": ">=5.4",
    "limu/ctablehelper": "dev-master"
},
```

##Setup

###Example file
In the webroot folder of ctablehelper, you will find an example file named
```TableExample.php```. Move this file into your webroot folder of your Anax-MVC.
It is a simple page controller for Anax-MVC and contains examples of
html tables the module can create.

###CSS file
Move ```ctablehelper.css``` from the ctablehelper/webroot/css folder to your css-folder
in your Anax-MVC webroot (Anax-MVC/webroot/css). This is an optional step, but neccessary if
you wish to use any of the premade table stylings.

##Usage

###Get Started
To include the class ```CTableHelper.php``` in your Anax-MVC project, use ```$di->set()```:

####In page controller
```
$di->set('table', '\Limu\HTMLTable\CTableHelper');
```

####In class/controller
```
$this->di->set('table', '\Anax\HTMLTable\CTableHelper');
```

###Create a table
To create a new HTML Table you will use the method ```createTable($headers, $data, $style = '')```.
The array ```$headers``` are the table headers you wish to use.
The multidimensional array (or object) ```$data``` contains the data that goes into the table cells. Each inner array represents one row in the table.
The optional string ```$style``` is which class name (and thus which styling) you wish to assign to the HTML table.

####Example (from ```TableExample.php```)
```
$tableHeaders = ['My header', 'Another header', 'Last header'];

$cellData = [
    ['data row 1 cell 1', 'data row 1 cell 2', 'data row 1 cell 3'],
    ['data row 2 cell 1', 'data row 2 cell 2', 'data row 2 cell 3'],
    ['data row 3 cell 1', 'data row 3 cell 2', 'data row 3 cell 3'],
    ['data row 4 cell 1', 'data row 4 cell 2', 'data row 4 cell 3'],
];

$app->table->createTable($tableHeaders, $cellData, 'light');
```

####Note
It is possible to use an empty array for ```$headers``` if you wish to not use
any table headers. However, if you choose to use headers, the number of headers must
be the same as the number of arrays in ```$data```, making the columns and headers match in numbers.
Likewise, all rows must contain the same number of cells. If these criterias are not met, the table
will not be created but an error message will be produced instead.



###Styling
If you wish to use any of the default stylings, you need to import ```ctablehelper.css```
to your ```style.css``` in Anax-MVC or add the module's stylesheet with ```$app->theme->addStylesheet('css/ctablehelper.css');``` in
your page controller. Have a look at the ```TableExample.php``` to see the different styling options available, but please remember that
you will only see the different stylings if you have moved the ```ctablehelper.css``` to your Anax-MVC css-folder.
If you want to use your own styling, simply add a class name of your choice as a third argument to the method
```createTable($headers, $data, $style = '')``` and style as you like.
