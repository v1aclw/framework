<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 18:21
 */

namespace Models;

use App\Model;

/**
 * Class Task
 *
 * @package Models
 *
 * @property $id
 * @property $user_name
 * @property $description
 * @property $email
 * @property $image
 * @property $status
 */
class Task extends Model
{

    const
        STATUS_NEW = 0,
        STATUS_SUCCESS = 10,

        IMAGES_PATH = '/uploads/',

        IMAGE_MAX_WIDTH = 320,
        IMAGE_MAX_HEIGHT = 240;

    /**
     * @return string
     */
    public function getTable(): string {
        return 'tasks';
    }

    /**
     * @return bool
     */
    public function hasImage() {
        return $this->image && file_exists($this->getImagePath());
    }

    /**
     * @return string
     */
    public function getImagePath() {
        if (array_key_exists('temp_image', $this->_data) && $this->_data['temp_image']) {
            return $this->_data['temp_image'];
        }
        return ROOTPATH . '/public' . self::IMAGES_PATH . md5($this->id);
    }

    /**
     * @return string
     */
    public function getImageUrl() {
        if (array_key_exists('temp_image', $this->_data) && $this->_data['temp_image']) {
            return '/temp/' . basename($this->_data['temp_image']);
        }
        return self::IMAGES_PATH . md5($this->id);
    }
}