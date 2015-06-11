<?php namespace Quince\Pelastic\Contracts\Api\Request;

interface RequestHttpPresenterInterface {

    /**
     * Convert a request to http
     *
     * @return Http
     */
    public function toHttp();

}