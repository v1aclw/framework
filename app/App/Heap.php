<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 15:06
 */

namespace App;

/**
 * Class Heap
 *
 * @package App
 */
class Heap
{

    /**
     * @var array
     */
    private static $_data = [];

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value) {
        if (!array_key_exists($key, self::$_data)) {
            self::$_data[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return self::$_data[$key];
    }

    /**
     * @return Facade
     */
    public static function app() {
        return self::$_data['app'];
    }

}