<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:57
 */

namespace App\Request;

/**
 * Class Session
 *
 * @package App
 */
class Session
{

    /**
     * @var self
     */
    private static $_instance;

    /**
     * Session constructor.
     */
    private function __construct() {
        session_start();
    }

    private function __clone() {
    }

    /**
     * @return Session
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return Session
     */
    public static function collect() {
        return self::getInstance();
    }

    /**
     * @return void
     */
    public function destroy() {
        session_destroy();
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key) {
        return $_SESSION[$key];
    }

}