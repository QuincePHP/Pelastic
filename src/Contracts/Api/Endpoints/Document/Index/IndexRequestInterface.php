<?php namespace Quince\Pelastic\Contracts\Api\Endpoints\Document\Index;

use Quince\Pelastic\Contracts\Api\Request\RequestInterface;
use Quince\Pelastic\Contracts\DocumentInterface;

interface IndexRequestInterface extends RequestInterface {

    /**
     * Set index
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index);

    /**
     * Get index
     *
     * @return string
     */
    public function getIndex();

    /**
     * Set type
     *
     * @param $type
     * @return $this
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return string
     */
    public function getType();

    /**
     * Set params array
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params);

    /**
     * Get params array
     *
     * @return array
     */
    public function getParams();

    /**
     * Set version of the document
     *
     * @param $version
     * @return integer
     */
    public function setVersion($version);

    /**
     * Set operation type of the document
     *
     * @param $opType
     * @return $this
     */
    public function setOpType($opType);

    /**
     * Set parent
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent);

    /**
     * Set version type
     *
     * @param $type
     * @return $this
     */
    public function setVersionType($type);

    /**
     * Set consistency
     *
     * @param $consistency
     * @return $this
     */
    public function setConsistency($consistency);

    /**
     * Set refresh
     *
     * @param $refresh
     * @return $this
     */
    public function setRefresh($refresh);

    /**
     * Set timeout
     *
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout);

    /**
     * Set routing
     *
     * @param $routing
     * @return $this
     */
    public function setRouting($routing);

    /**
     * Set replication
     *
     * @param $replication
     * @return $this
     */
    public function setReplication($replication);

    /**
     * Set ttl
     *
     * @param $ttl
     * @return $this
     */
    public function setTTL($ttl);

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp);

    /**
     * Set document
     *
     * @param DocumentInterface $document
     * @param null $id
     * @return $this
     */
    public function setDocument(DocumentInterface $document, $id = null);

    /**
     * Get document
     *
     * @return DocumentInterface
     */
    public function getDocument();

    /**
     * Set document id
     *
     * @param $id
     * @return $this
     */
    public function setDocumentId($id);

    /**
     * Get document ID
     *
     * @return mixed|null
     */
    public function getDocumentId();

    /**
     * Make with all attributes
     *
     * @param $index
     * @param null $type
     * @param DocumentInterface $document
     * @param null $id
     * @param array $params
     * @return $this
     */
    public function make($index, $type = null, DocumentInterface $document, $id = null, array $params);

}