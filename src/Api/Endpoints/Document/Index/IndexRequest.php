<?php namespace Quince\Pelastic\Api\Endpoints\Document\Index;

use Elasticsearch\Client;
use Quince\Pelastic\Api\Response\RawResponse;
use Quince\Pelastic\Api\Request\Request;
use Quince\Pelastic\Contracts\Api\Endpoints\Document\Index\IndexRequestInterface;
use Quince\Pelastic\Contracts\Api\Endpoints\Document\Index\IndexResponseInterface;
use Quince\Pelastic\Contracts\Api\Response\ResponseInterface;
use Quince\Pelastic\Contracts\DocumentInterface;

class IndexRequest extends Request implements IndexRequestInterface {

    /**
     * Convert request to an elasticsearch client representation
     *
     * @return array
     */
    public function toElasticClient()
    {
        $paramsArray = [];

        $paramsArray['index'] = $this->getIndex();

        if (null !== $this->getType()) {
            $paramsArray['type'] = $this->getType();
        }

        if (null !== $this->getDocumentId()) {
            $paramsArray['id'] = $this->getDocumentId();
        }

        $paramsArray['body'] = $this->getDocument()->toArray();

        $paramsArray = $paramsArray + $this->getAttribute('params', false, []);

        return $paramsArray;
    }

    /**
     * Get index response class
     *
     * @return string
     */
    public function getResponseClassOfRequest()
    {
        return IndexResponse::class;
    }

    /**
     * Execute the request by elasticsearch client
     *
     * @param Client $client
     * @return ResponseInterface
     */
    public function executeByElasticClient(Client $client)
    {
        $responseClass = $this->getResponseClassOfRequest();

        /** @var IndexResponseInterface $response */
        $response = new $responseClass;

        $rawResult = RawResponse::build($client->index($this->toElasticClient()));

        return $response->build($rawResult);
    }

    /**
     * Set index
     *
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->setAttribute('index', $index);

        return $this;
    }

    /**
     * Get index
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->getAttribute('index', true);
    }

    /**
     * Set type
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->setAttribute('type', (string) $type);

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->getAttribute('type', false, null);
    }

    /**
     * Set params array
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->setAttribute('params', $params);

        return $this;
    }

    /**
     * Get params array
     *
     * @return array
     */
    public function getParams()
    {
        $this->getAttribute('params', false, []);
    }

    /**
     * Set version of the document
     *
     * @param $version
     * @return integer
     */
    public function setVersion($version)
    {
        $this->putIntoAssociativeArrayField('params', 'version', $version);

        return $this;
    }

    /**
     * Set operation type of the document
     *
     * @param $opType
     * @return $this
     */
    public function setOpType($opType)
    {
        $this->putIntoAssociativeArrayField('params', 'op_type', $opType);

        return $this;
    }

    /**
     * Set parent
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->putIntoAssociativeArrayField('params', 'parent', $parent);

        return $this;
    }

    /**
     * Set version type
     *
     * @param $type
     * @return $this
     */
    public function setVersionType($type)
    {
        $this->putIntoAssociativeArrayField('params', 'version_type', $type);

        return $this;
    }

    /**
     * Set consistency
     *
     * @param $consistency
     * @return $this
     */
    public function setConsistency($consistency)
    {
        $this->putIntoAssociativeArrayField('params', 'consistency', $consistency);

        return $this;
    }

    /**
     * Set refresh
     *
     * @param $refresh
     * @return $this
     */
    public function setRefresh($refresh)
    {
        $this->putIntoAssociativeArrayField('params', 'refresh', $refresh);

        return $this;
    }

    /**
     * Set timeout
     *
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->putIntoAssociativeArrayField('params', 'timeout', (int) $timeout);

        return $this;
    }

    /**
     * Set routing
     *
     * @param $routing
     * @return $this
     */
    public function setRouting($routing)
    {
        $this->putIntoAssociativeArrayField('params', 'routing', $routing);

        return $this;
    }

    /**
     * Set replication
     *
     * @param $replication
     * @return $this
     */
    public function setReplication($replication)
    {
        $this->putIntoAssociativeArrayField('params', 'replication', $replication);

        return $this;
    }

    /**
     * Set ttl
     *
     * @param $ttl
     * @return $this
     */
    public function setTTL($ttl)
    {
        $this->putIntoAssociativeArrayField('params', 'ttl', (int) $ttl);

        return $this;
    }

    /**
     * Set timestamp
     *
     * @param integer $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp)
    {
        $this->putIntoAssociativeArrayField('params', 'timestamp', (int) $timestamp);

        return $this;
    }

    /**
     * Set document
     *
     * @param DocumentInterface $document
     * @param null $id
     * @return $this
     */
    public function setDocument(DocumentInterface $document, $id = null)
    {
        $this->setAttribute('document', $document);

        if (null !== $id) {
            $this->setDocumentId($id);
        }elseif (null !== ($id = $document->getId())) {
            $this->setDocumentId($id);
        }

        return $this;
    }

    /**
     * Get document
     *
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->getAttribute('document', true);
    }

    /**
     * Set document id
     *
     * @param $id
     * @return $this
     */
    public function setDocumentId($id)
    {
        $this->setAttribute('document_id', $id);

        return $this;
    }

    /**
     * Get document ID
     *
     * @return mixed|null
     */
    public function getDocumentId()
    {
        return $this->getAttribute('document_id', false, $this->getDocument()->getId());
    }

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
    public function make($index, $type = null, DocumentInterface $document, $id = null, array $params = [])
    {
        $this->setIndex($index);

        if (null !== $type) {
            $this->setType($type);
        }

        if (null !== $id) {
            $this->setDocumentId($id);
        }elseif (($id = $document->getId()) !== null) {
            $this->setDocumentId($id);
        }

        if (!empty($params)) {
            $this->setParams($params);
        }

        return $this;
    }
}