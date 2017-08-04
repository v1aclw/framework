<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 03.08.17
 * Time: 1:01
 */

namespace App\Request;

class File
{

    /**
     * @var string
     */
    protected $_path;

    /**
     * File constructor.
     *
     * @param string $path
     */
    public function __construct(string $path) {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('File doesn\'t exists');
        }

        $this->_path = $path;
    }

    /**
     * @param string $path
     */
    public function move(string $path) {
        rename($this->_path, $path);
        $this->_path = $path;
    }

    /**
     * @return mixed
     */
    public function pathInfo() {
        return pathinfo($this->_path);
    }

    /**
     * @return void
     */
    public function delete() {
        unlink($this->_path);
    }

}