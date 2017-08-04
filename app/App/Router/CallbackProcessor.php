<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:37
 */

namespace App\Router;

use App\{
    Request,
    Response
};

/**
 * Class CallbackProcessor
 *
 * @package App\Router
 */
class CallbackProcessor extends Processor
{

    /**
     * @var callable
     */
    protected $_callback;

    /**
     * CallbackProcessor constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback) {
        $this->_callback = $callback;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws RouteNotFoundException
     */
    public function execute(Request $request): Response {
        try {
            $parameters = $this->getReflectionParameters(new \ReflectionFunction($this->_callback), $request);
        } catch (\InvalidArgumentException $exception) {
            throw new RouteNotFoundException();
        }

        $result = call_user_func_array($this->_callback, $parameters);

        if ($result instanceof Response) {
            return $result;
        }

        return new Response((string)$result);
    }
}