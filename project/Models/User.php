<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 22:06
 */

namespace Models;

use App\Model;
use App\Request\Session;

/**
 * Class User
 *
 * @package Models
 *
 * @property $id
 * @property string $login
 * @property string $password
 */
class User extends Model
{

    /**
     * @return string
     */
    public function getTable(): string {
        return 'users';
    }

    public function login() {
        Session::getInstance()->set('user_id', $this->id);
    }

    public function logout() {
        Session::getInstance()->destroy();
    }

    public static function isAuth() {
        return Session::getInstance()->get('user_id');
    }

    /**
     * @return User
     */
    public static function current() {
        if (self::isAuth()) {
            $user = self::getByPrimaryKey(Session::getInstance()->get('user_id'));
            if ($user) {
                unset($user->password);
                return $user;
            }
        }
        return new self();
    }
}