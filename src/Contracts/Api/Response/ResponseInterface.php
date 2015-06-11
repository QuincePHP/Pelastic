<?php namespace Quince\Pelastic\Contracts\Api\Response;

use Illuminate\Contracts\Support\Arrayable;

interface ResponseInterface extends Arrayable {

    /**
     * Build from raw array
     *
     * @param RawResponseInterface $raw
     * @return ResponseInterface
     */
    public function build(RawResponseInterface $raw);

}