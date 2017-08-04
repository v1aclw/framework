<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 11:55
 */

/**
 * Class Autoloader
 */
class Autoloader {

    /**
     * @var array
     */
    protected static $_folders = [
        'app'
    ];

    /**
     * @param array $folders
     * @return void
     */
    public static function register(array $folders = []) {
        self::$_folders = $folders;
        if (!in_array('app', $folders, true)) {
            self::$_folders[] = 'app';
        }
        spl_autoload_register([Autoloader::class, 'loader']);
    }

    /**
     * @param string $className
     * @return bool
     */
    public static function loader(string $className) {
        $path = str_replace('\\', '/', $className);
        foreach (self::$_folders as $folder) {
            $filename = ROOTPATH . '/' . $folder . '/' . $path . '.php';
            if (file_exists($filename)) {
                require_once $filename;
                return true;
            }
        }
        return false;
    }

}