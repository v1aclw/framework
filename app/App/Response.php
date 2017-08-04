<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 12:30
 */

namespace App;

/**
 * Class Response
 *
 * @package App
 */
class Response
{

    const
        HTTP_OK = 200,
        HTTP_NOT_FOUND = 404;

    /**
     * @var string
     */
    public $content;

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var int
     */
    public $statusCode = self::HTTP_OK;

    /**
     * Response constructor.
     *
     * @param mixed $data
     */
    public function __construct(string $data) {
        $this->content = $data;
    }

    public function send() {
        foreach ($this->headers as $header) {
            header($header, false, $this->statusCode);
        }

        header(sprintf('HTTP/1.0 %d Not Found', $this->statusCode), true, $this->statusCode);

        echo $this->content;
    }

}