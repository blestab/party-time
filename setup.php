<?php

require 'init.php';

$app = new App(true);

//Migrate necessary tables
$app->add('\atk4\schema\MigratorConsole')
    ->migrateModels([
        new \atk4\login\Model\User($app->db)
    ]);
    
//App admins management
$app->add('CRUD')->setModel(new \atk4\login\Model\User($app->db));
