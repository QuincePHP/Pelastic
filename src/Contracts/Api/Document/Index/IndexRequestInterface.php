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
     * @param $id
     * @return $this
     */
    public function setId($id);

    /**
     * Index to store document on
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index);

    /**
     * Type to set document on
     *
     * @param $type
     * @return $this
     */
    public function setType($type);

    /**
     * Index with all args
     *
     * @param DocumentInterface $document
     * @param $index
     * @param null $type
     * @param null $id
     * @return mixed
     */
    public function index(DocumentInterface $document, $index, $type = null, $id = null);

    /**
     * Get document of the request
     *
     * @return DocumentInterface
     */
    public function getDocument();

    /**
     * Get id of the document
     *
     * @return string|integer
     */
    public function getDocumentId();

    /**
     * Get index that should be used to store documents on.
     *
     * @return string
     */
    public function getIndex();

    /**
     * Get type that should be used to store documents on.
     *
     * @return string
     */
    public function getType();
}