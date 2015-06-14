<?php namespace Quince\Pelastic\ODM;

use Elastica\Client;
use Illuminate\Support\Str;
use Quince\Pelastic\Contracts\Utils\ArrayableInterface;
use Quince\Pelastic\Contracts\Utils\JsonableInterface;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Quince\Pelastic\ODM\PelasticEvents as E;

class Pelastic implements ArrayableInterface, JsonableInterface, \ArrayAccess{

    use AccessibleMutatableTrait;

    /**
     * Elasticsearch indexes
     *
     * @var string
     */
    protected $index;

    /**
     * Elasticsearch types
     *
     * @var string
     */
    protected $type;

    /**
     * Original attributes on the document model
     *
     * @var array
     */
    protected $original;

    /**
     * The events for pelastic odm
     *
     * @var PelasticEvents
     */
    protected $events;

    /**
     * The id key which is being used as elasticsearch id
     *
     * @var string
     */
    protected $idKey = '_id';

    /**
     * The id of the remote elasticsearch
     *
     * @var string
     */
    protected $id;

    /**
     * Should read id from attributes of array or not?
     *
     * @var bool
     */
    protected $readIdFromAttributes = false;

    /**
     * The event dispatcher used
     *
     * @var EventDispatcher
     */
    protected static $eventDispatcher;

    /**
     * @var Client
     */
    protected static $elasticaClient;

    /**
     * Booted Pelastic classes
     *
     * @var array
     */
    protected static $booted = [];

    /**
     * @param array $attributes
     * @param null $id
     */
    public function __construct(array $attributes = null, $id = null)
    {
        // First we will check that the class has been booted or not
        // This strategy originally comes from eloquent
        $this->bootIfNotBooted();

        // Then we will add attributes by concerns like guarded and fillable attributes
        if (null !== $attributes) {
            $this->fill($attributes);
        }

        if (null !== $id) {
            $this->setId($id);
        }
    }

    /**
     * Boot current object
     *
     * @return void
     */
    protected function bootCurrent()
    {
        $this->createEventObject();

        $this->firePelasticEvent(E::EVENT_BOOTING, false);

        static::$booted[static::class] = true;

        static::boot();

        $this->firePelasticEvent(E::EVENT_BOOTED, false);
    }

    /**
     * Boot the class
     *
     * @return void
     */
    protected static function boot()
    {
        static::bootTraits();
    }

    /**
     * Call trait boot methods
     *
     * @return void
     */
    protected static function bootTraits()
    {
        foreach (class_uses_recursive(static::class) as $trait) {

            if (method_exists(static::class, $method = 'boot' . class_basename($trait))) {

                forward_static_call_array([static::class], $method);

            }

        }
    }

    /**
     * Set elastica client to work on
     *
     * @param Client $client
     * @return void
     */
    public static function setElasticaClient(Client $client)
    {
        static::$elasticaClient = $client;
    }

    /**
     * Add event
     *
     * @param $event
     * @param bool $halt
     * @throws PelasticException
     */
    public function firePelasticEvent($event, $halt = false)
    {
        if (null === ($dispatcher = static::getEventDispatcher())) {
            throw new PelasticException("You have to set an event dispatcher for PelasticODM.");
        }

        $eventObject = $this->getEvents();

        foreach ((array) $event as $e) {

            $e = 'pelastic.' . $e . '.' . static::class;

            $pelasticEvent = $dispatcher->dispatch($e, $eventObject);

            if ($halt === true) {
                $pelasticEvent->stopPropagation();
            }

        }
    }

    /**
     * Get pelastic events
     *
     * @return PelasticEvents
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Indicates current object has been booted or not
     *
     * @return bool
     */
    public function currentObjectHasBeenBooted()
    {
        return $this->givenClassHasBeenBooted(static::class);
    }

    /**
     * The given class has been booted or not
     *
     * @param $class
     * @return bool
     */
    public function givenClassHasBeenBooted($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        return isset(static::$booted[$class]);
    }

    /**
     * Boot class if not booted yet
     *
     * @return void
     */
    protected function bootIfNotBooted()
    {
        if (!$this->currentObjectHasBeenBooted()) {

            $this->bootCurrent();

        }
    }

    /**
     * Create pelastic event object
     *
     * @return void
     */
    protected function createEventObject()
    {
        $this->events = new E($this);
    }

    /**
     * Fill document with given attributes
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        $this->optionAttribute = $attributes;

        if ($this->shouldReadIdFromAttributes() && isset($attributes[$key = $this->getKey()])) {

            $this->setId($this->getAttribute($key));

            $this->removeKeyFromAttribute($key);

        }
    }

    /**
     * Get document id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set document id
     *
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        $this->id = (string) $value;
        return $this;
    }

    /**
     * Remove key from attribute container
     *
     * @param $key
     */
    public function removeKeyFromAttribute($key)
    {
        unset($this->optionAttribute[$key]);
    }

    /**
     * Set event dispatcher instance
     *
     * @param EventDispatcher $eventDispatcher
     */
    public static function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        static::$eventDispatcher = $eventDispatcher;
    }

    /**
     * Find by given id
     *
     * @param $id
     * @param null $include
     * @return $this
     */
    public static function find($id, $include = null)
    {
        return (new static)->newQuery()->find($id, $include);
    }

    /**
     * Find given document by id
     *
     * @param $id
     * @param null $include
     * @return Pelastic
     */
    public static function findById($id, $include = null)
    {
        return static::find($id, $include);
    }

    /**
     * Get event dispatcher instance
     *
     * @return EventDispatcher
     */
    public static function getEventDispatcher()
    {
        return static::$eventDispatcher;
    }

    /**
     * Get id key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->idKey;
    }

    /**
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }

    /**
     * An json representation of object
     *
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512)
    {
        return json_encode($this->toArray(), $options, $depth);
    }

    /**
     * Read id from attributes
     *
     * @return bool
     */
    public function shouldReadIdFromAttributes()
    {
        return $this->readIdFromAttributes;
    }

    /**
     * Elastica adaptor
     *
     * @return ElasticaAdaptor
     */
    public function newQuery()
    {
        $elastica = $this->newElasticaAdaptor();

        $elastica->setModel($this);

        return $elastica;
    }

    /**
     * New elastica adaptor
     *
     * @return ElasticaAdaptor
     */
    protected function newElasticaAdaptor()
    {
        return new ElasticaAdaptor;
    }

    /**
     * Get index name for current model
     *
     * @return string
     */
    public function getIndex()
    {
        if (null !== $this->index) return $this->index;

        return Str::plural($this->index);
    }

    /**
     * Get type of elasticsearch
     * we will first look for the set attribute
     * if it is null then we will prepend an 'all_' string
     * to the index name and use it as type name
     *
     * @return string
     */
    public function getType()
    {
        if (null !== $this->type) return $this->type;

        return 'all_' . $this->getIndex();
    }
}