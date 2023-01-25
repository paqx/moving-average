<?php

use Paquix\Ma\Router;
use Paquix\Ma\Controller;

require_once __DIR__.'/../vendor/autoload.php';

$router = new Router();

$router->get('/', [Controller::class, 'index']);

$router->failover([Controller::class, 'failover']);