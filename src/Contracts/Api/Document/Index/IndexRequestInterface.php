<?php namespace Quince\Pelastic\Contracts\Api\Document\Index;

use Quince\Pelastic\Contracts\Api\RequestInterface;
use Quince\Pelastic\Contracts\DocumentInterface;

interface IndexRequestInterface extends  RequestInterface {

    /**
     * Set document to work on
     *
     * @param DocumentInterface $document
     * @param null $id
     * @return $this
     */
    public function setDocument(DocumentInterface $document, $id = null);

    /**
     * Set id
     *
     * @param null $id
     * @return $this
     */
    public function setId($id = null);
    
}