<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 11:55
 */

namespace App;

use App\Router\IProcessor;
use App\Router\RouteNotFoundException;

/**
 * Class Facade
 *
 * @package App
 */
class Facade
{

    /**
     * @var IProcessor
     */
    protected $_routeNotFoundProcessor;

    /**
     * @var Router
     */
    protected $_router;

    /**
     * Facade constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router) {
        $this->_router = $router;

        Heap::set('app', $this);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \App\Router\RouteNotFoundException
     */
    public function handle(Request $request): Response {
        require_once $this->_router->getRoutesPath();

        try {
            return $this->_router->handle($request);
        } catch (RouteNotFoundException $exception) {
            if ($this->_routeNotFoundProcessor !== null) {
                return $this->_routeNotFoundProcessor->execute($request);
            }
            throw $exception;
        }
    }

    /**
     * @param IProcessor $processor
     * @return $this
     */
    public function setRouteNotFoundProcessor(IProcessor $processor) {
        $this->_routeNotFoundProcessor = $processor;

        return $this;
    }

    /**
     * @param Route $route
     * @return $this
     */
    public function addRoute(Route $route) {
        $this->_router->add($route);

        return $this;
    }

    /**
     * @return Facade
     */
    public static function app(): Facade {
        return Heap::app();
    }

}