<?php

require 'init.php';

$app = new App(true);

//Migrate necessary tables
$app->add('\atk4\schema\MigratorConsole')
    ->migrateModels([
      //Tried to add Guest to a migration but kept geting an error in heroku, locally it seems fine
      //  new Guest($app->db),
        new \atk4\login\Model\User($app->db)
    ]);

//App admins management
$app->add('CRUD')->setModel(new \atk4\login\Model\User($app->db));
