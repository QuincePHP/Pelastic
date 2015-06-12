<?php namespace Quince\Pelastic\Api\Endpoints\Document\Get;

use Quince\Pelastic\Api\Response\Response;
use Quince\Pelastic\Contracts\Api\Response\RawResponseInterface;
use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;
use Quince\Pelastic\Contracts\DocumentInterface;
use Quince\Pelastic\Document;

class GetResponse extends Response {

    /**
     * @var DocumentInterface
     */
    protected $document;

    /**
     * Build from raw array
     *
     * @param RawResponseInterface $raw
     * @return ResponseInterface
     */
    public function build(RawResponseInterface $raw)
    {
        $this->raw = $raw;

        $metaData = array_only($this->raw->getArray(), ['_version', 'found', '_index', '_type', '_id']);

        $source = $this->raw['_source'];

        if (null === ($document = $this->getDocument())) {

            $this->document = new Document($source, $metaData['_id'], $metaData);

        }else {

            $this->document->create($source, $metaData['_id'], $metaData);

        }

        return $this;
    }

    /**
     * Set document
     *
     * @param DocumentInterface $document
     */
    public function setDocument(DocumentInterface $document)
    {
        $this->document = $document;
    }

    /**
     * Get the document
     *
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->document;
    }
}