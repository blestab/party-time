<?php

require 'init.php';

$app = new App(true);

//Ensure users are authenticated before accessing the admin section
$app->add(new \atk4\login\Auth())
    ->setModel(new \atk4\login\Model\User($app->db));

//Guests Admin section

$app->add(new Dashboard())->setModel(new Guest($app->db));
