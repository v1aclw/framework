<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 23:23
 */

namespace Helpers;

/**
 * Class PaginationPage
 *
 * @package Helpers
 */
class PaginationPage
{

    /**
     * @var int
     */
    protected $_num;

    /**
     * @var bool
     */
    protected $_active;

    /**
     * @var bool
     */
    protected $_disabled;

    /**
     * PaginationPage constructor.
     *
     * @param int $num
     * @param bool $active
     * @param bool $disabled
     */
    public function __construct(int $num, bool $active, bool $disabled) {
        $this->_num = $num;
        $this->_active = $active;
        $this->_disabled = $disabled;
    }

    /**
     * @return int
     */
    public function getNum() {
        return $this->_num;
    }

    /**
     * @return bool
     */
    public function isActive() {
        return $this->_active;
    }

    /**
     * @return bool
     */
    public function isDisabled() {
        return $this->_disabled;
    }

}