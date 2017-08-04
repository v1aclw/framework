<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:46
 */

namespace App;

/**
 * Class Controller
 *
 * @package App
 */
abstract class Controller
{

    /**
     * @param string $url
     * @return Response
     */
    public function redirect(string $url) {
        $response = new Response('');
        $response->headers[] = 'Location: ' . $url;
        return $response;
    }

}