<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 21:26
 */

namespace App;

/**
 * Class View
 *
 * @package App
 */
class View
{

    /**
     * @var array
     */
    protected static $_shared = [];

    /**
     * @var array
     */
    protected $_layout = [];

    /**
     * @var string
     */
    protected $_template = '';

    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []) {
        $this->_template = $template;
        if (array_key_exists('temp', $this->_layout)) {
            $this->_layout[$template] = $this->_layout['temp'];
            unset($this->_layout['temp']);
        }
        $content = '';
        if (file_exists($template)) {
            ob_start();

            extract(array_merge(self::$_shared, $data), EXTR_OVERWRITE);
            require $template;

            $content = ob_get_clean();
        }

        if ($this->_layout[$template] && file_exists($this->_layout[$template])) {
            $layout = $this->_layout[$template];
            unset($this->_layout[$template]);
            return $this->render($layout, array_merge($data, compact('content')));
        }
        return $content;
    }

    /**
     * @param string $layout
     * @return $this
     */
    public function layout(string $layout) {
        if ($this->_template) {
            $this->_layout[$this->_template] = $layout;
        } else {
            $this->_layout['temp'] = $layout;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function share(string $key, $value) {
        self::$_shared[$key] = $value;
    }

}