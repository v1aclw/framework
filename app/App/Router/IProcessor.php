<?php

/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:27
 */

namespace App\Router;

use App\Request;
use App\Response;

/**
 * Interface IProcessor
 *
 * @package App\Router
 */
interface IProcessor
{

    /**
     * @param Request $request
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function execute(Request $request): Response;

}