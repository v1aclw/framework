<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:34
 */

namespace App\Router;

use App\{
    Request,
    Response
};

/**
 * Class MethodProcessor
 *
 * @package App\Router
 */
class MethodProcessor extends Processor
{

    /**
     * @var string
     */
    protected $_controller;

    /**
     * @var string
     */
    protected $_method;

    /**
     * MethodProcessor constructor.
     *
     * @param string $controller
     * @param string $method
     */
    public function __construct(string $controller, string $method) {
        $this->_controller = $controller;
        $this->_method = $method;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function execute(Request $request): Response {
        try {
            $reflection = new \ReflectionMethod($this->_controller, $this->_method);
        } catch (\ReflectionException $exception) {
            throw new RouteNotFoundException();
        }

        try {
            $parameters = $this->getReflectionParameters($reflection, $request);
        } catch (\InvalidArgumentException $exception) {
            throw new RouteNotFoundException();
        }

        $result = $reflection->invokeArgs(new $this->_controller, $parameters);

        if ($result instanceof Response) {
            return $result;
        }

        return new Response((string)$result);
    }
}