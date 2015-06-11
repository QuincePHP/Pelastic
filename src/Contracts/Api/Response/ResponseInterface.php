<?php namespace Quince\Pelastic\Contracts\Api\Response;

interface ResponseInterface {

    /**
     * Build from raw array
     *
     * @param RawResponseInterface $raw
     * @return ResponseInterface
     */
    public function build(RawResponseInterface $raw);

}