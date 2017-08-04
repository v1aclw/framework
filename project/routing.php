<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:48
 *
 * @var \App\Facade $this
 */

\App\Route::post('/login')->method(\Controllers\AuthController::class, 'postLogin');
\App\Route::any('/logout')->method(\Controllers\AuthController::class, 'anyLogout');

/**
 * Home
 */
\App\Route::get('/add')->method(\Controllers\HomeController::class, 'getAdd');
\App\Route::post('/add')->method(\Controllers\HomeController::class, 'postAdd');
\App\Route::get('/edit/{id}')->pattern('id', '\d+')->method(\Controllers\HomeController::class, 'getEdit');
\App\Route::post('/edit/{id}')->pattern('id', '\d+')->method(\Controllers\HomeController::class, 'postEdit');
\App\Route::post('/preview/{id}')->pattern('id', '\d+')->method(\Controllers\HomeController::class, 'postPreview');
\App\Route::post('/preview')->method(\Controllers\HomeController::class, 'postPreview');
\App\Route::get('/{page}')->pattern('page', '\d+')->method(\Controllers\HomeController::class, 'getIndex');
\App\Route::get('/')->method(\Controllers\HomeController::class, 'getIndex');