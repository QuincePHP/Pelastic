<?php namespace Quince\Pelastic\Contracts\Api\Document\Index;

use Quince\Pelastic\Contracts\Api\RepositoryInterface;

interface IndexRepositoryInterface extends RepositoryInterface {

    /**
     * Execute an index request
     *
     * @param IndexRequestInterface $request
     * @return mixed
     */
    public function executeRequest(IndexRequestInterface $request);

}