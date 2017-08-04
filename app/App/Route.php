<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:16
 */

namespace App;

use App\Router\{
    IProcessor,
    CallbackProcessor,
    MethodProcessor
};

/**
 * Class Route
 *
 * @package App
 */
class Route
{

    const
        GET = 0,
        POST = 1,
        ANY = 2,

        DEFAULT_PATTERN = '[^\/]+';

    /**
     * @var string
     */
    protected $_url;

    /**
     * @var int
     */
    protected $_method;

    /**
     * @var IProcessor
     */
    protected $_processor;

    /**
     * @var array
     */
    protected $_patterns = [];

    /**
     * @var array
     */
    protected $_data = [];

    /**
     * Route constructor.
     *
     * @param string $url
     * @param int $method
     */
    public function __construct(string $url, int $method) {
        $this->_url = $url;
        $this->_method = in_array($method, [self::GET, self::POST, self::ANY], true) ? $method : self::GET;
        Facade::app()->addRoute($this);
    }

    /**
     * @param string $controller
     * @param string $method
     * @return $this
     */
    public function method(string $controller, string $method) {
        $this->_processor = new MethodProcessor($controller, $method);

        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function callback(callable $callback) {
        $this->_processor = new CallbackProcessor($callback);

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function pattern(string $key, string $value) {
        $this->_patterns[$key] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getData() {
        return $this->_data;
    }

    /**
     * @param string $url
     * @param int $method
     * @return bool
     */
    public function check(string $url, int $method) {
        if ($this->_method === self::ANY || $method === $this->_method) {
            preg_match_all('/{([^}]+)}/iu', $this->_url, $matches);
            $replace = $vars = [0];
            foreach ($matches[1] as $match) {
                $replace['{' . $match . '}'] = '(' . (array_key_exists($match, $this->_patterns) ? $this->_patterns[$match] : self::DEFAULT_PATTERN) . ')';
                $vars[] = $match;
            }
            $pattern = '/^' . str_replace('/', '\/', str_replace('\/', '/', strtr($this->_url, $replace))) . '\/?(?:\?.*)?$/iu';
            if (preg_match($pattern, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if ($key === 0) continue;
                    $this->_data[$vars[$key]] = $match;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \App\Router\RouteNotFoundException
     */
    public function execute(Request $request): Response {
        return $this->_processor->execute($request);
    }

    /**
     * @param string $url
     * @return static
     */
    public static function get(string $url) {
        return new static($url, self::GET);
    }

    /**
     * @param string $url
     * @return static
     */
    public static function post(string $url) {
        return new static($url, self::POST);
    }

    /**
     * @param string $url
     * @return static
     */
    public static function any(string $url) {
        return new static($url, self::ANY);
    }

}