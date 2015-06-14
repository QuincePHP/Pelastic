<?php namespace Quince\Pelastic\ODM;

use Elastica\Client;
use Elastica\Type;

class ElasticaAdaptor {

    /**
     * The model which the builder workds on
     *
     * @var Pelastic
     */
    protected $model;

    /**
     * @var Client
     */
    protected static $client;

    /**
     * Set elastica client
     *
     * @param Client $client
     */
    public static function setElasticaClient(Client $client)
    {
        static::$client = $client;
    }

    /**
     * Get model
     *
     * @return Pelastic
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set model to work on
     *
     * @param Pelastic $model
     */
    public function setModel(Pelastic $model)
    {
        $this->model = $model;
    }

    /**
     * Find a document by id
     *
     * @param $id
     * @param null $include
     * @return Pelastic
     */
    public function find($id, $include = null)
    {
        $index = static::$client->getIndex($this->getModel()->getIndex());

        $type = new Type($index, $this->getModel()->getType());

        $document = $type->getDocument($id, ['_source' => $include]);

        $this->getModel()->setId($document->getId());

        $this->getModel()->fill($document->getData());

        return $this->getModel();
    }

}