<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:30
 */

namespace App;

use App\Request\{Files, Session};

/**
 * Class Request
 *
 * @package App
 */
class Request
{

    /**
     * @var string
     */
    protected $_url;

    /**
     * @var string
     */
    protected $_method;

    /**
     * @var array
     */
    protected $_get;

    /**
     * @var array
     */
    protected $_post;

    /**
     * @var Files
     */
    protected $_files;

    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var Route
     */
    protected $_route;

    /**
     * Request constructor.
     *
     * @param string $url
     * @param string $method
     * @param array $get
     * @param array $post
     * @param Files $files
     * @param Session $session
     */
    public function __construct(string $url, string $method, array $get, array $post, Files $files, Session $session) {
        $this->_url = $url;
        $this->_method = $method;
        $this->_get = $get;
        $this->_post = $post;
        $this->_files = $files;
        $this->_session = $session;
    }

    /**
     * @return static
     */
    public static function collect() {
        return new static($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_GET, $_POST, Files::collect(), Session::collect());
    }

    /**
     * @return string
     */
    public function url() {
        return $this->_url;
    }

    /**
     * @return string
     */
    public function method() {
        return $this->_method;
    }

    /**
     * @return Route
     */
    public function route() {
        return $this->_route;
    }

    /**
     * @return array
     */
    public function input() {
        return $this->_get;
    }

    /**
     * @return array
     */
    public function form() {
        return $this->_post;
    }

    /**
     * @return Files
     */
    public function files() {
        return $this->_files;
    }

    /**
     * @return Session
     */
    public function session() {
        return $this->_session;
    }

    /**
     * @param Route $route
     */
    public function setRoute(Route $route) {
        $this->_route = $route;
    }

}