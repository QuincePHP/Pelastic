<?php namespace Quince\Pelastic\ODM;

use Carbon\Carbon;
use Elastica\Client;
use Illuminate\Support\Str;
use Quince\Pelastic\Contracts\Utils\ArrayableInterface;
use Quince\Pelastic\Contracts\Utils\JsonableInterface;
use Quince\Pelastic\Exceptions\PelasticException;
use Quince\Pelastic\Exceptions\PelasticMassAssignmentException;
use Quince\Pelastic\ODM\PelasticEvents as E;
use Quince\Pelastic\Utils\AccessibleMutatableTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class Pelastic implements ArrayableInterface, JsonableInterface, \ArrayAccess {

    use AccessibleMutatableTrait {
        setAttribute as traitSetAttribute;
        getAttribute as traitGetAttribute;
    }

    /**
     * Created at field name
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * Updated at field name
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The event dispatcher used
     *
     * @var EventDispatcher
     */
    protected static $eventDispatcher;

    /**
     * The elastica client which is used to perform queries againsts
     *
     * @var Client
     */
    protected static $elasticaClient;

    /**
     * Booted Pelastic classes
     * Every time a new instance is created the class is updated/added
     * to this array
     *
     * @var array
     */
    protected static $booted = [];

    /**
     * Indicates that pelastic is guarded or unguarded
     * An unguarded model can contain any attributes
     * There is no control on that.
     *
     *
     * @var bool
     */
    protected static $unguarded = false;

    /**
     * Elasticsearch index name
     * An index represents a table in sql databases.
     *
     *
     * @var string
     */
    protected $index;

    /**
     * Elasticsearch type which its combination with index is a unique identifier for
     * a collection of data.
     *
     * @var string
     */
    protected $type;

    /**
     * Original attributes on the document model
     * This attributes are untouched.
     *
     * @var array
     */
    protected $original;

    /**
     * The events for pelastic odm, this is a generic event class
     * which contains data for default model events like "booting".
     *
     * @var PelasticEvents
     */
    protected $events;

    /**
     * Are attributes snake cased?
     *
     * @var bool
     */
    protected static $snakeAttributes = true;

    /**
     * The id key which is being used as elasticsearch id
     *
     * @var string
     */
    protected $idKey = '_id';

    /**
     * The value of id of the remote elasticsearch
     *
     * @var string
     */
    protected $id;

    /**
     * Should read id from attributes of array or not?
     * It means when you set $model->id = 'something' it will be set as
     * the global elasticsearch ID.
     * Ids in elasticsearch does not contains in the _source field by default
     *
     * @var bool
     */
    protected $readIdFromAttributes = false;

    /**
     * Mutator cache
     *
     * @var array
     */
    protected static $mutatorCache = [];

    /**
     * Variables which are appended when toArray is called.
     *
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Visible attributes when to array is called
     * When this is set all of the other are ignored.
     *
     *
     * @var array
     */
    protected $visible = ['*'];

    /**
     * Hidden attributes when toArray is called
     * This ensures this field would not be available
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Guarded attributes by default all attributes are guarded.
     * You can assign values to guarded attributes in a bulk way like Model::create($attributes);
     *
     * @var array|null
     */
    protected $guarded = ['*'];

    /**
     * Fillable attributes by default nothing is fillable
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Appendable dates, you may have other date fields, which will
     * be appended to default date fields.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Global date format for the instance, you can change it to whatever you want,
     * this will be applied when ever date fields are accessed.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * Should model use timestamps or not
     * timestamps contains "updated_at", "created_at"
     *
     * @var bool
     */
    protected $timestamps = true;

    /**
     * Should the model remove id from attributes in setter method ?
     *
     * @var bool
     */
    protected $shouldRemoveIdFromAttributes = false;

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
     * Create pelastic event object
     *
     * @return void
     */
    protected function createEventObject()
    {
        $this->events = new E($this);
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

        foreach ((array)$event as $e) {

            $e = 'pelastic.' . $e . '.' . static::class;

            $pelasticEvent = $dispatcher->dispatch($e, $eventObject);

            if ($halt === true) {
                $pelasticEvent->stopPropagation();
            }

        }
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
     * Set event dispatcher instance
     *
     * @param EventDispatcher $eventDispatcher
     */
    public static function setEventDispatcher(EventDispatcher $eventDispatcher)
    {
        static::$eventDispatcher = $eventDispatcher;
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
     * Fill document with given attributes
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($attributes = $this->fillableFromAttributes($attributes) as $key => &$value) {

            if ($this->isFillable($key)) {

                $this->setAttribute($key, $value);

            } elseif ($totallyGuarded) {

                throw new PelasticMassAssignmentException("The {$key} attribute is guarded.");

            }

        }
    }

    /**
     * Is model totally guarded ?
     *
     * @return bool
     */
    public function totallyGuarded()
    {
        return count($this->fillable) == 0 && $this->guarded = ['*'];
    }

    /**
     * Filters the array of attributes
     *
     * @param array $attributes
     * @return array
     */
    public function fillableFromAttributes(array $attributes)
    {
        // We simply will check that the model is unguarded or not, if so we will return all
        // else if our fillable attribute is set we will intersect that with our attributes array
        // we will also will check that the wildcard is not set.
        if (count($this->fillable) > 0 && !static::$unguarded && $this->fillable != ['*']) {

            return array_intersect_key($attributes, array_flip($this->fillable));

        }

        return $attributes;
    }

    /**
     * Given attribute is fillable or not
     *
     * @param $attribute
     * @return bool
     */
    protected function isFillable($attribute)
    {
        // First will check that the whole models are guarded or not,
        // Then if the fillable array contains a wildcard star it means the developer
        // wants all. if the given attribute exists in the fillable array it is then to
        // be set. if the given attribute is set in the guarded array then it will be rejected.
        // If the fillable attribute is empty it means that the user wants the attribute.
        if (
            static::$unguarded === true ||
            $this->fillable == ['*'] ||
            in_array($attribute, $this->fillable) ||
            $this->isGuarded($attribute) === false ||
            (empty($this->fillable))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Given attribute is guarded or not
     *
     * @param $attribute
     * @return bool
     */
    public function isGuarded($attribute)
    {
        return in_array($attribute, $this->guarded) || $this->guarded == ['*'];
    }

    /**
     * Set attribute through attribute processor
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function setAttribute($attribute, $value)
    {
        // We will first process the attribute and run it through a
        // pipe line setters, dates, and other cool stuff
        $value = $this->processAttributeValue($attribute, $value);

        // First we will check that given attribute is an id field ,
        // Then if it is allowed to be set as id we will set it and also we will
        // check that should we skip setting or not
        if ($this->getKey() === $attribute) {

            if ($this->shouldReadIdFromAttributes()) {

                $this->setId($value);

            }

            if ($this->shouldRemoveIdFromAttributes()) {

                return $this;

            }

        }

        return $this->traitSetAttribute($attribute, $value);
    }

    /**
     * Process attribute and run it through the mutators
     *
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function processAttributeValue($attribute, $value)
    {
        if ($this->attributeHasSetMutator($attribute)) {

            $method = $this->getMutatorMethodForAttribute($attribute);

            return call_user_func([$this, $method], $value);

        }

        if ($this->isDateAttribute($attribute)) {

            $value = $this->fromDateTime($value);

        }

        // TODO :: add json castable

        return $value;
    }

    /**
     * Check that our attribute has setters in mutator cache
     *
     * @param $attribute
     * @return bool
     */
    protected function attributeHasSetMutator($attribute)
    {
        $attribute = studly_case($attribute);

        return method_exists($this, "set{$attribute}Attribute");
    }

    public function getMutatorMethodForAttribute($attribute)
    {
        $attribute = studly_case($attribute);

        return "set{$attribute}Attribute";
    }

    /**
     * Given attribute is a date attribute
     *
     * @param $attribute
     * @return bool
     */
    public function isDateAttribute($attribute)
    {
        return in_array($attribute, $this->getDates());
    }

    /**
     * Get date fields
     *
     * @return array
     */
    public function getDates()
    {
        return array_unique($this->getDefaultDates() + $this->dates);
    }

    /**
     * Get default timestamps
     *
     * @return array
     */
    private function getDefaultDates()
    {
        return [static::CREATED_AT, static::UPDATED_AT];
    }

    /**
     * Convert date time to carbon
     *
     * @param \DateTime $dateTime
     * @return \DateTime|Carbon
     */
    protected function fromDateTime($dateTime)
    {
        $format = $this->getDateFormat();

        if ($dateTime instanceof Carbon) {

            return $dateTime;

        } elseif ($dateTime instanceof \DateTime) {

            return Carbon::instance($dateTime);

        } elseif (is_numeric($dateTime)) {

            return Carbon::createFromTimestamp($dateTime);

        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateTime)) {

            return Carbon::createFromFormat('Y-m-d', $dateTime)->startOfDay();

        } else {

            return Carbon::createFromFormat($format, $dateTime);

        }
    }

    /**
     * Get date format on model setting and getting functions
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
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
     * Read id from attributes
     *
     * @return bool
     */
    public function shouldReadIdFromAttributes()
    {
        return $this->readIdFromAttributes;
    }

    /**
     * Should model remove id from attributes ?
     *
     * @return bool
     */
    public function shouldRemoveIdFromAttributes()
    {
        return $this->shouldRemoveIdFromAttributes;
    }

    /**
     * Create a model from attributes
     *
     * @param array $attributes
     * @param null $id
     * @return $this
     */
    public static function create(array $attributes = null, $id = null)
    {
        $instance = new static($attributes, $id);

        $instance->save();

        return $instance;
    }

    public function save()
    {
        // TODO add save functionality
    }

    /*
     * Get mutator method of this model for the given attribute
     *
     * @return string
     */

    /**
     * Run the given callback while being unguarded
     *
     * @param \Closure $callable
     * @return mixed
     */
    public static function unguarded(\Closure $callable)
    {
        if (static::$unguarded) {
            return $callable();
        }

        static::unguard();

        $result = $callable();

        static::reguard();

        return $result;
    }

    /**
     * Put models into unguarded state
     *
     * @return void
     */
    public static function unguard()
    {
        static::$unguarded = true;
    }

    /**
     * Push back all models to guarded state
     *
     * @return void
     */
    public static function reguard()
    {
        static::$unguarded = false;
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
     * Are the pelastic models totally unguarded?
     *
     * @return bool
     */
    public static function isUnguarded()
    {
        return (bool)static::$unguarded;
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
        $this->id = (string)$value;
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
     * An array representation of object
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    /**
     * Get array representation of attributes
     *
     * @return array
     */
    public function attributesToArray()
    {
        // First we will fetch visible attributes
        $values = $this->getArrayableAttributes();

        // Then we will process date fields
        foreach ($this->getDates() as $date) {

            if(array_key_exists($date, $values)) {

                if (null !== $values[$date]) $values[$date] = (string) $this->asDateTime($date);

            }

        }

        // Now we will check the mutator cache. we will decorate the attribute
        // of each attribute registered to its cache.
        foreach ($this->getMutatedAttributes() as $attribute => $method) {

            if (!isset($values[$attribute])) continue;

            $values[$attribute] = $this->mutateAttributeByMethodForArray($method, $values[$attribute]);

        }

        // We will now check for appendable attributes
        foreach ($this->getAppendableAttributes() as $attribute) {

            // We will extract the method name from the attribute
            $method = $this->generateGetMutatorMethodNameFromAttribute($attribute);

            // Then treat it as the above section.
            $values[$attribute] = $this->mutateAttributeByMethodForArray($method, null);

        }

        return $values;
    }

    /**
     * Get method name for attribute
     *
     * @param $attribute
     * @return string
     */
    protected function generateGetMutatorMethodNameFromAttribute($attribute)
    {
        return 'get' . snake_case($attribute) . 'Attribute';
    }

    /**
     * Get appendable attributes
     *
     * @return array
     */
    public function getAppendableAttributes()
    {
        return array_unique($this->appends);
    }

    /**
     * Mutate an attribute for array representation by its mutator method name
     *
     * @param $method
     * @param $value
     * @return array|mixed
     */
    protected function mutateAttributeByMethodForArray($method, $value)
    {
        /** @var ArrayableInterface|mixed $mutated */
        $mutated = $this->mutateAttributeByMethod($method, $value);

        return $mutated instanceof ArrayableInterface ? $mutated->toArray() : $mutated;
    }

    /**
     * Mutate an attribute by method
     *
     * @param $method
     * @param $value
     * @return mixed|array|ArrayableInterface
     */
    protected function mutateAttributeByMethod($method, $value)
    {
        return forward_static_call([static::class, $method], $value);
    }

    /**
     * Get mutated attributes
     *
     * @return array
     */
    protected function getMutatedAttributes()
    {
        if (!$this->mutatorsCached()) {

            $this->fillMutatorCache();

        }

        return static::$mutatorCache[static::class];
    }

    /**
     * Cache mutated attributes
     *
     * @param $class
     * @return void
     */
    protected function cacheMutatedAttributes($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        $mutatedAttributes = [];

        foreach (get_class_methods($class) as $method) {

            if (
                strpos($method, 'Attribute') !== false &&
                preg_match('/^get(.+)Attribute$/', $method, $matches)
            ) {
                $matches = lcfirst($matches[1]);

                $method = $matches[1];

                if (static::$snakeAttributes) {
                    $matches[1] = snake_case($matches[1]);
                }

                $mutatedAttributes[$matches[1]] = $method;
            }

        }

        static::$mutatorCache[$class] = $mutatedAttributes;
    }

    /**
     * Are current object mutators cached?
     *
     * @return bool
     */
    protected function mutatorsCached()
    {
        return static::classMutatorsCached(static::class);
    }

    /**
     * Is class mutators cached?
     *
     * @param $class
     * @return bool
     */
    protected static function classMutatorsCached($class)
    {
        return isset(static::$mutatorCache[$class]);
    }

    /**
     * Fill mutator cache for current object
     *
     * @return void
     */
    protected function fillMutatorCache()
    {
        static::cacheMutatedAttributes(static::class);
    }

    /**
     *
     *
     * @param Carbon|string|\DateTime $date
     * @return string
     */
    public function asDateTime($date)
    {
        return $this->fromDateTime($date);
    }

    /**
     * Relations to array
     *
     * @return array
     */
    public function relationsToArray()
    {
        return [];
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
     * Get attribute on model
     *
     * @param $what
     * @return mixed
     */
    public function __get($what)
    {
        return $this->getAttribute($what);
    }

    /**
     * Set attribute on model
     *
     * @param $what
     * @param $valueOfWhat
     * @return Pelastic
     */
    public function __set($what, $valueOfWhat)
    {
        return $this->setAttribute($what, $valueOfWhat);
    }

    /**
     * Get attribute from the container
     *
     * @param $attribute
     * @param bool $hardCheck
     * @param null $defaultValue
     * @return mixed
     */
    public function getAttribute($attribute, $hardCheck = false, $defaultValue = null)
    {
        if ($this->attributeHasGetMutator($attribute) || array_key_exists($attribute, $this->optionAttribute)) {

            return $this->getAttributeValue($attribute);

        }

        return $defaultValue;
    }

    /**
     * Indicates attribute has get mutator
     *
     * @param $attribute
     * @return bool
     */
    public function attributeHasGetMutator($attribute)
    {
        return method_exists($this, 'get' . studly_case($attribute) . 'Attribute');
    }

    /**
     * Gets attribute value
     *
     * @param $attribute
     * @return mixed
     */
    public function getAttributeValue($attribute)
    {
        $value = $this->traitGetAttribute($attribute);

        if ($this->attributeHasGetMutator($attribute)) {

            return $this->getAttributeFromGetter($attribute, $value);

        }

        if ($this->hasCast($attribute)) {

            return $this->processCastForAttribute($attribute, $value);

        }

        if ($this->isDateAttribute($attribute) && $value !== null) {

            return $value;

        }

        return $value;
    }

    public function getAttributeFromGetter($attribute, $value)
    {
        $method = $this->getGetterMethodForAttribute($attribute);

        return call_user_func([$this, $method], $value);
    }

    /**
     * Generate getter method for attribute
     *
     * @param $attribute
     * @return string
     */
    public function getGetterMethodForAttribute($attribute)
    {
        return 'get' . studly_case($attribute) . 'Attribute';
    }

    /**
     * Attribute has cast or not
     *
     * @param $attribute
     * @return bool
     */
    public function hasCast($attribute)
    {
        return array_key_exists($attribute, $this->casts);
    }

    /**
     * Process cast for attribute
     *
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function processCastForAttribute($attribute, $value)
    {
        return $value;
    }

    /**
     * Attribute is set or not
     *
     * @param $what
     * @return bool
     */
    public function __isset($what)
    {
        return $this->attributeIsSet($what);
    }

    /**
     * Attribute is set or not
     *
     * @param $attribute
     * @return bool
     */
    public function attributeIsSet($attribute)
    {
        return isset($this->optionAttribute[$attribute]) || $this->attributeHasGetMutator($attribute);
    }

    /**
     * Add magic method
     * This may forward static call for methods with the same name
     *
     * @param $method
     * @param array $args
     * @return mixed
     * @throws PelasticException
     */
    public function __call($method, $args = [])
    {
        // We will first check for the static calls of this class
        if (method_exists(static::class, $method)) {

            return forward_static_call_array([static::class, $method], $args);

        }

        // We will throw exception if no methods available.
        throw new PelasticException("Method : [$method] does not exist on this class and her friends.");
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     * @throws PelasticException
     */
    public function __callStatic($method, $args = [])
    {
        // We will create an instance of current class for static calls.
        $current = new static();

        if (method_exists($current, $method)) {
            return call_user_func_array([$current, $method], $args);
        }

        throw new PelasticException("Method : [$method] does not exist on this class and her friends.");
    }

    /**
     * Get arrayable attributes from the container
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        return $this->getArrayableItems($this->optionAttribute);
    }

    /**
     * Get arrayable items filtered by the visible and hidden criteria
     *
     * @param array $values
     * @return array
     */
    protected function getArrayableItems(array $values)
    {
        if (count($this->visible) > 0) {

            return array_intersect_key($values, array_flip($this->visible));

        }

        return array_diff_key($values, array_flip($this->hidden));
    }
}