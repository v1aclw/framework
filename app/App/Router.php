<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:30
 */

namespace App;

use App\Router\RouteNotFoundException;

/**
 * Class Router
 *
 * @package App
 */
class Router
{

    /**
     * @var array
     */
    protected $_routes = [];

    /**
     * @var string
     */
    protected $_routesPath;

    /**
     * Router constructor.
     *
     * @param string $routesPath
     * @internal param string $routes
     */
    public function __construct(string $routesPath) {
        $this->_routesPath = $routesPath;
    }

    /**
     * @return string
     */
    public function getRoutesPath() {
        return $this->_routesPath;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \App\Router\RouteNotFoundException
     */
    public function handle(Request $request): Response {
        foreach ($this->_routes as $route) {
            if ($route->check($request->url(), $this->toRouteMethod($request->method()))) {
                $request->setRoute($route);
                return $route->execute($request);
            }
        }
        throw new RouteNotFoundException();
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function add(Route $route) {
        $this->_routes[] = $route;
        return $this;
    }

    /**
     * @param string $method
     * @return int
     */
    public function toRouteMethod(string $method): int {
        if (strtolower($method) === 'post') {
            return Route::POST;
        }
        return Route::GET;
    }

}