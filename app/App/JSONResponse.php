<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 17:58
 */

namespace App;

/**
 * Class JSONResponse
 *
 * @package App
 */
class JSONResponse extends Response
{

    /**
     * JSONResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data) {
        parent::__construct(json_encode($data));
    }

}