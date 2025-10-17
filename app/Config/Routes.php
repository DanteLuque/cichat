<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/websocket', 'WebSocketController::index');

// averias
$routes->get('/averias', 'AveriaController::index');
$routes->get('/averias/registrar', 'AveriaController::crear');
$routes->post('api/averias/save', 'AveriaController::save');