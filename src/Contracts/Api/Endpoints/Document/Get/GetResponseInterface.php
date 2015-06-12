<?php namespace Quince\Pelastic\Contracts\Api\Endpoints\Document\Get;

use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;
use Quince\Pelastic\Contracts\DocumentInterface;

interface GetResponseInterface extends ResponseInterface {

    /**
     * @param DocumentInterface $document
     * @return mixed
     */
    public function setDocument(DocumentInterface $document);

    /**
     * @return DocumentInterface
     */
    public function getDocument();

}