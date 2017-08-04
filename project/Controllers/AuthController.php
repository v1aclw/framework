<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 04.08.17
 * Time: 15:23
 */

namespace Controllers;

use App\Controller;
use App\JSONResponse;
use Models\User;

/**
 * Class AuthController
 *
 * @package Controllers
 */
class AuthController extends Controller
{

    /**
     * Login
     *
     * @param string $login
     * @param string $password
     * @return JSONResponse
     */
    public function postLogin(string $login, string $password) {
        $users = User::query('select id from users where login = ? and password = ?', [$login, md5($password)]);
        if ($users->count()) {
            /** @var User $user */
            $user = $users->first();
            $user->login();
        }
        return new JSONResponse([
            'success' => $users->count() ? 1 : 0,
        ]);
    }

    /**
     * Logout
     *
     * @return \App\Response
     */
    public function anyLogout() {
        User::current()->logout();
        return $this->redirect('/');
    }

}