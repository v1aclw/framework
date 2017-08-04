<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:47
 */

namespace App;

use App\DB\Collection;

/**
 * Class Model
 *
 * @package App
 */
abstract class Model
{

    /**
     * @var string
     */
    protected $_primaryKey = 'id';

    /**
     * @var array
     */
    protected $_data = [];

    /**
     * @return string
     */
    abstract public function getTable(): string;

    /**
     * Model constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->_data = $data;
    }

    public function save() {
        $fields = array_intersect(self::getFields($this->getTable()), array_keys($this->_data));
        if ($fields) {
            $implodedFields = implode(',', array_map(function ($item) {
                return '`' . $item . '`';
            }, $fields));
            $implodedUpdate = implode(',', array_map(function ($item) {
                return '`' . $item . '` = VALUES(`' . $item . '`)';
            }, $fields));

            $bindings = [];
            foreach ($fields as $field) {
                $bindings[] = $this->_data[$field];
            }
            $result = DB::insert('
                  INSERT INTO ' . $this->getTable() . ' (' . $implodedFields . ') 
                  VALUES (' . implode(',', array_fill(0, count($fields), '?')) . ')
                  ON DUPLICATE KEY UPDATE ' . $implodedUpdate . '
              ', $bindings);

            $this->_data[$this->_primaryKey] = $result;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        return $this->_data[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        return array_key_exists($name, $this->_data);
    }

    /**
     * @param $name
     */
    public function __unset($name) {
        unset($this->_data[$name]);
    }

    /**
     * @param string $table
     * @return array
     */
    public static function getFields(string $table) {
        static $fields = [];

        if (!array_key_exists($table, $fields)) {
            $fields[$table] = array_column(DB::query('SHOW COLUMNS FROM ' . $table, []), 'Field');
        }

        return $fields[$table];
    }

    /**
     * @return int
     */
    public static function getFoundRows() {
        return (int)current(current(DB::query('SELECT FOUND_ROWS();')));
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return Collection
     */
    public static function query(string $query, array $bindings = []) {
        $result = DB::query($query, $bindings);
        foreach ($result as $key => $fields) {
            $result[$key] = new static($fields);
        }

        return new Collection($result);
    }

    /**
     * @param $primaryKeyValue
     * @return static
     */
    public static function getByPrimaryKey($primaryKeyValue) {
        $model = new static();
        $results = DB::query('select * from `' . $model->getTable() . '` where `' . $model->_primaryKey . '` = ?', [$primaryKeyValue]);
        if (!count($results)) {
            return null;
        }
        foreach ($results[0] as $key => $value) {
            $model->{$key} = $value;
        }
        return $model;
    }

}