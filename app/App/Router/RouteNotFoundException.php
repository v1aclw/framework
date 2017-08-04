<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:29
 */

namespace App\Router;

use Exception;

/**
 * Class RouteNotFoundException
 *
 * @package App\Router
 */
class RouteNotFoundException extends Exception
{

    /**
     * RouteNotFoundException constructor.
     */
    public function __construct() {
        parent::__construct('', 404);
    }

}