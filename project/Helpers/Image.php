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
     * TODO: Реализовать с проверкой движка, сделать 2 класса с одним интерфейсом с возможностью ресайзить
     *
     * @param string $filePath
     * @param int $maxWidth
     * @param int $maxHeight
     * @internal param int $width
     * @internal param int $height
     */
    public static function resize(string $filePath, int $maxWidth, int $maxHeight) {
        if (class_exists('Imagick')) {
            $imagick = new \Imagick($filePath);
            if ($imagick->getImageWidth() > $maxWidth || $imagick->getImageHeight() > $maxHeight) {
                $imagick->scaleImage($maxWidth, $maxHeight, 1);
                $imagick->writeImage();
            }
        } else {
            list($imageWidth, $imageHeight) = getimagesize($filePath);
            if ($imageWidth > $maxHeight && $imageHeight > $maxHeight) {
                $widthRatio = $imageWidth / $maxWidth;
                $heightRation = $imageHeight / $maxHeight;
                if ($widthRatio > $heightRation) {
                    $width = $imageWidth / $widthRatio;
                    $height = $imageHeight / $widthRatio;
                } else {
                    $width = $imageWidth / $heightRation;
                    $height = $imageHeight / $heightRation;
                }
                $src = imagecreatefromstring(file_get_contents($filePath));
                $dst = imagecreatetruecolor($width, $height);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);
                imagedestroy($src);
                imagepng($dst, $filePath);
                imagedestroy($dst);
            }
        }
    }

}