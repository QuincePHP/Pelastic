<?php namespace Quince\Pelastic\Api\Document;

use Quince\Pelastic\Api\Request;
use Quince\Pelastic\Contracts\Api\Document\Index\IndexRequestInterface;
use Quince\Pelastic\Contracts\Api\Http;
use Quince\Pelastic\Contracts\DocumentInterface;

class IndexRequest extends Request implements IndexRequestInterface {

    /**
     * Set document to work on
     *
     * @param DocumentInterface $document
     * @param null $id
     * @return $this
     */
    public function setDocument(DocumentInterface $document, $id = null)
    {
        $this->setAttribute('document', $document);

        if (null !== $id) {
            $this->setId($id);
        }elseif (null !== ($id = $document->getId())) {
            $this->setId($id);
        }

        return $this;
    }

    /**
     * Set id
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setAttribute('id', $id);

        return $this;
    }

    /**
     * Index to store document on
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->setAttribute('index', (string) $index);
    }

    /**
     * Type to set document on
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->setAttribute('type', (string) $type);
    }

    /**
     * Index with all args
     *
     * @param DocumentInterface $document
     * @param $index
     * @param null $type
     * @param null $id
     * @return mixed
     */
    public function index(DocumentInterface $document, $index, $type = null, $id = null)
    {
        $this->setIndex($index);

        if (null !== $type) {
            $this->setType($type);
        }

        $this->setDocument($document, $id);

        return $this;
    }

    /**
     * Get document of the request
     *
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->getAttribute('document', true);
    }

    /**
     * Get id of the document
     *
     * @return string|integer
     */
    public function getDocumentId()
    {
        return $this->getAttribute('id', false, $this->getDocument()->getId());
    }

    /**
     * Get index that should be used to store documents on.
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->getAttribute('id', true);
    }

    /**
     * Get type that should be used to store documents on.
     *
     * @return string
     */
    public function getType()
    {
        return $this->getAttribute('type', false, null);
    }

    /**
     * Convert a request to http
     *
     * @return Http
     */
    public function toHttp()
    {
        $uri = $this->getIndex();

        if (null !== $this->getType()) {
            $uri .= '/' . $this->getType();
        }

        if (null !== $this->getDocumentId()) {
            $uri .= '/' . $this->getDocumentId();
        }

        $body = $this->getDocument()->toArray();

        return new Http('PUT', $uri, null, $body);
    }
}