<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 04.08.17
 * Time: 15:01
 */

namespace Helpers;

/**
 * Class Image
 *
 * @package Helpers
 */
class Image
{

    /**
     * @param string $filePath
     * @param int $width
     * @param int $height
     */
    public static function resize(string $filePath, int $width, int $height) {
        $imagick = new \Imagick($filePath);
        if ($imagick->getImageWidth() > $width || $imagick->getImageHeight() > $height) {
            $imagick->scaleImage($width, $height, 1);
            $imagick->writeImage();
        }
    }

}