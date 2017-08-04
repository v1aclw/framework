<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:34
 */

/**
 * @param array ...$arguments
 */
function dd(...$arguments) {
    die('<pre>' . print_r($arguments, 1) . '</pre>');
}