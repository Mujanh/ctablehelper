<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php';


$di->set('table', '\Limu\HTMLTable\CTableHelper');


$app->router->add('', function() use ($app) {

    $tableHeaders = ['My header', 'Another header', 'Last header'];

    $cellData = [
        ['datarow1 cell 1', 'datarow1 cell 2', 'datarow1 cell 3'],
        ['datarow2 cell 1', 'datarow2 cell 2', 'datarow2 cell 3'],
        ['datarow3 cell 1', 'datarow3 cell 2', 'datarow3 cell 3'],
        ['datarow4 cell 1', 'datarow4 cell 2', 'datarow4 cell 3'],
    ];

    $app->theme->setTitle("Example Tables from CTableHelper");
    $app->theme->addStylesheet('css/ctablehelper.css');

    $nostyle = "<h2>No styling</h2>" . $app->table->createTable($tableHeaders, $cellData);
    $contentLight = "<h2>Styling: light</h2>" . $app->table->createTable($tableHeaders, $cellData, 'light');
    $contentDark = "<h2>Styling: dark</h2>" . $app->table->createTable($tableHeaders, $cellData, 'dark');
    $contentOddeven = "<h2>Styling: oddeven</h2>" . $app->table->createTable($tableHeaders, $cellData, 'oddeven');
    $contentColorful = "<h2>Styling: colorful</h2>" . $app->table->createTable($tableHeaders, $cellData, 'colorful');

    $app->views->add('default/page', [
        'title' => "Example Tables from CTableHelper",
        'content' => $nostyle . $contentLight . $contentDark . $contentOddeven . $contentColorful,
    ]);

});


$app->router->handle();
$app->theme->render();
