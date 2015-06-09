<?php namespace Quince\Pelastic\Contracts\Api;

interface RequestHttpPresenterInterface {

    /**
     * Convert a request to http
     *
     * @return Http
     */
    public function toHttp();

}