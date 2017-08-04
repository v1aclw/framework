<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 23:18
 */

namespace Helpers;

/**
 * Class Pagination
 *
 * @package Helpers
 */
class Pagination implements \Iterator
{

    /**
     * @var int
     */
    protected $_visiblePagesCount = 5;

    /**
     * @var PaginationPage[]
     */
    protected $_items;

    /**
     * @var int
     */
    protected $_page;

    /**
     * @var int
     */
    protected $_limit;

    /**
     * @var int
     */
    protected $_count;

    /**
     * Pagination constructor.
     *
     * @param int $page
     * @param int $limit
     * @param int $count
     */
    public function __construct(int $page, int $limit, int $count) {
        $this->_page = $page;
        $this->_limit = $limit;
        $this->_count = $count;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param int $count
     * @return static
     */
    public static function create(int $page, int $limit, int $count) {
        return new static($page, $limit, $count);
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setVisiblePagesCount(int $count) {
        $this->_visiblePagesCount = $count;
        $this->_items = null;

        return $this;
    }

    /**
     * @return int
     */
    public function count() {
        $this->_generate();
        return count($this->_items);
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return PaginationPage Can return any type.
     * @since 5.0.0
     */
    public function current() {
        $this->_generate();
        return current($this->_items);
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        $this->_generate();
        next($this->_items);
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        $this->_generate();
        return key($this->_items);
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
        $this->_generate();
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
        $this->_generate();
        reset($this->_items);
    }

    /**
     * @return PaginationPage|null
     */
    public function getPrev() {
        return $this->getPageObject($this->_page - 1);
    }

    /**
     * @return PaginationPage|null
     */
    public function getNext() {
        return $this->getPageObject($this->_page + 1);
    }

    /**
     * @param int $num
     * @return PaginationPage|null
     */
    public function getPageObject(int $num) {
        foreach ($this->_items as $item) {
            if ($item->getNum() === $num) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @return int
     */
    public function getPage() {
        return $this->_page;
    }

    protected function _generate() {
        if ($this->_items === null) {
            $last = floor($this->_count / $this->_limit) + ($this->_count % $this->_limit ? 1 : 0);
            $from = (int)max(1, $this->_page - floor($this->_visiblePagesCount / 2));
            $to = (int)min($from + $this->_visiblePagesCount - 1, $last);

            if ($from > 1) {
                $this->_items[] = new PaginationPage(1, false, false);
                if ($from > 2) {
                    $this->_items[] = new PaginationPage(2, false, true);
                }
            }

            for ($i = $from; $i <= $to; $i++) {
                $this->_items[] = new PaginationPage($i, $i === $this->_page, false);
            }

            if ($to < $last) {
                if ($to < $last - 1) {
                    $this->_items[] = new PaginationPage($last - 1, false, true);
                }
                $this->_items[] = new PaginationPage($last, false, false);
            }
        }
    }
}