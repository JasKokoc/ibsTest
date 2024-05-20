<?php
include($_SERVER['DOCUMENT_ROOT']."/local/modules/notebookshop/include/vendor/autoload.php");

ini_set('error_reporting', 0);
ini_set('display_errors', 0);


//TODO: на локале демо битры не тянет классы с композера
CModule::AddAutoloadClasses(
    '',
    [
        'Module\Notebook\NotebookTable' => '/local/modules/notebookshop/lib/NotebookTable.php',
        'Module\Notebook\ManufacturerTable' => '/local/modules/notebookshop/lib/ManufacturerTable.php',
        'Module\Notebook\NotebookModelTable' => '/local/modules/notebookshop/lib/NotebookModelTable.php',
        'Module\Notebook\NotebookOptionTable' => '/local/modules/notebookshop/lib/NotebookOptionTable.php',
        'Notebookshop\DataFixtures\ModuleFixtures' => '/local/modules/notebookshop/lib/DataFixtures/ModuleFixtures.php',
    ]
);