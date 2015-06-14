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
        $type = $this->getNewType();

        $document = $type->getDocument($id, ['_source' => $include]);

        $this->getModel()->setId($document->getId());

        $this->getModel()->fill($document->getData());

        return $this->getModel();
    }

    /**
     * Get new type instance
     *
     * @return Type
     */
    protected function getNewType()
    {
        return new Type($this->getNewIndex(), $this->getModel()->getType());
    }

    /**
     * Get new index instance
     *
     * @return \Elastica\Index
     */
    protected function getNewIndex()
    {
        return static::$client->getIndex($this->getModel()->getIndex());
    }

}