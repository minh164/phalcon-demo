<?php
/**
 * Created by PhpStorm.
 * User: minh164
 * Date: 12/17/2019
 * Time: 1:24 PM
 */

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/login',
    [
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/invoices/:action',
    [
        'controller' => 'invoices',
        'action'     => 1,
    ]
);
$router->handle($_SERVER["REQUEST_URI"]);
//dump($router); die();


use Phalcon\Di;
use Phalcon\Mvc\Dispatcher;

$container  = new Di();

$container->setShared('response', function () {

});
$dispatcher = new Dispatcher();

$dispatcher->setDI($container);

$dispatcher->setNamespaceName("Website\Controllers\Admin");
$dispatcher->setControllerName("login");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();

//dump($controller); die();
return $router;