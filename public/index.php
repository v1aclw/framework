<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 11:48
 */

define('ROOTPATH', realpath(__DIR__ . '/..'));

require_once ROOTPATH . '/app/Autoloader.php';
require_once ROOTPATH . '/app/debug.php';

Autoloader::register([
    'project'
]);

$app = new \App\Facade(new \App\Router(ROOTPATH . '/project/routing.php'));

$app->setRouteNotFoundProcessor(new \App\Router\MethodProcessor(\Controllers\RouteNotFoundController::class, 'getIndex'));

$response = $app->handle(\App\Request::collect());

$response->send();