<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 18:29
 */

namespace App\DB;

/**
 * Interface IConnection
 *
 * @package App\DB
 */
interface IConnection
{

    /**
     * IConnection constructor.
     *
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $passwords
     */
    public function __construct(string $host, string $dbname, string $user, string $passwords);

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    public function query(string $query, array $bindings = []): array;

    /**
     * @param string $query
     * @param array $bindings
     * @return int
     */
    public function insert(string $query, array $bindings = []): int;

}