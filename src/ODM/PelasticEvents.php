<?php namespace Quince\Pelastic\ODM;

use Symfony\Component\EventDispatcher\Event;

class PelasticEvents extends Event {

    const EVENT_BOOTING = 'booting';

    const EVENT_BOOTED = 'booted';

    protected $document;

    public function __construct(Pelastic $document)
    {
        $this->document = $document;
    }

    public function getDocument()
    {
        return $this->document;
    }

}