<?php

/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:55
 */

namespace App\Request;

/**
 * Class Files
 *
 * @package Request
 */
class Files implements \Iterator
{

    /**
     * @var array
     */
    protected $_files = [];

    /**
     * @return Files
     */
    public static function collect() {
        $files = [];
        foreach ($_FILES as $key => $file) {
            try {
                $files[$key] = new TempFile($file['tmp_name'], $file['name'], $file['type'], $file['error'], $file['size']);
            } catch (\InvalidArgumentException $exception) {

            }
        }
        return new self($files);
    }

    /**
     * Files constructor.
     *
     * @param File[] $files
     */
    private function __construct(array $files) {
        $this->_files = $files;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isset($key) {
        return array_key_exists($key, $this->_files);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key) {
        return $this->_files[$key];
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return File Can return any type.
     * @since 5.0.0
     */
    public function current() {
        return current($this->_files);
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        next($this->_files);
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return key($this->_files);
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        return $this->key() !== null;
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        reset($this->_files);
    }
}