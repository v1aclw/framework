<?php

/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 13:47
 */

namespace Controllers;

use App\Response;
use App\View;

/**
 * Class RouteNotFoundController
 *
 * @package Controllers
 */
class RouteNotFoundController
{

    /**
     * 404
     *
     * @return Response
     */
    public function getIndex() {
        $response = new Response((new View())->render(ROOTPATH . '/project/Views/layout.php', [
            'title'       => 404,
            'description' => 'Page not found',
        ]));
        $response->statusCode = Response::HTTP_NOT_FOUND;
        return $response;
    }

}