<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 18:33
 */

namespace App;

use App\DB\IConnection;

/**
 * Class DB
 *
 * @package App
 */
class DB
{

    /**
     * @var self
     */
    private static $_instance;

    /**
     * @var IConnection
     */
    private $_connection;

    /**
     * @return self
     */
    public final static function getInstance() {
        if (self::$_instance === null) {
            $config = require_once ROOTPATH . '/db.php';
            self::$_instance = new self(new $config['driver']($config['host'], $config['dbname'], $config['user'], $config['password']));
        }
        return self::$_instance;
    }

    /**
     * @return IConnection
     */
    public function getConnection() {
        return $this->_connection;
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    public final static function query(string $query, array $bindings = []) {
        return self::getInstance()->getConnection()->query($query, $bindings);
    }

    public final static function insert(string $query, array $bindings) {
        return self::getInstance()->getConnection()->insert($query, $bindings);
    }

    /**
     * DB constructor.
     *
     * @param IConnection $connection
     */
    private function __construct(IConnection $connection) {
        $this->_connection = $connection;
    }

    /**
     *
     */
    private function __clone() {
    }

}