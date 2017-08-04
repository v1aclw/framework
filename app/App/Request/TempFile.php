<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 03.08.17
 * Time: 1:22
 */

namespace App\Request;

/**
 * Class TempFile
 *
 * @package App\Request
 */
class TempFile extends File
{

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var string
     */
    protected $_type;

    /**
     * @var string
     */
    protected $_error;

    /**
     * @var int
     */
    protected $_size;

    /**
     * TempFile constructor.
     *
     * @param string $path
     * @param string $name
     * @param string $type
     * @param string $error
     * @param int $size
     */
    public function __construct(string $path, string $name, string $type, string $error, int $size) {
        $this->_name = $name;
        $this->_type = $type;
        $this->_error = $error;
        $this->_size = $size;

        parent::__construct($path);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getPath() {
        return $this->_path;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @param string $path
     * @return File
     */
    public function move(string $path) {
        move_uploaded_file($this->_path, $path);
        return new File($path);
    }

}