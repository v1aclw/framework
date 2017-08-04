<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 18:29
 */

namespace App\DB;

/**
 * Class Connection
 *
 * @package App\DB
 */
class PDOConnection implements IConnection
{

    /**
     * @var
     */
    private $_driver;

    /**
     * IConnection constructor.
     *
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $passwords
     */
    public function __construct(string $host, string $dbname, string $user, string $passwords) {
        $this->_driver = new \PDO(sprintf('mysql:host=%s;dbname=%s;', $host, $dbname), $user, $passwords);
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    public function query(string $query, array $bindings = []): array {
        return $this->_query($query, $bindings);
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return int
     */
    public function insert(string $query, array $bindings = []): int {
        $this->_query($query, $bindings);
        return $this->_driver->lastInsertId();
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    private function _query(string $query, array $bindings = []) {
        $statement = $this->_driver->prepare($query);
        foreach (array_values($bindings) as $key => $binding) {
            $statement->bindValue($key + 1, $binding, is_int($binding) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        if (!$statement->execute()) {
            throw new \PDOException(implode(' ', $statement->errorInfo()));
        }
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}