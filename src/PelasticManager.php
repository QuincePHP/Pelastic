<?php namespace Quince\Pelastic;

use Pimple\Container;
use Quince\Pelastic\Config\PelasticConfig;
use Quince\Pelastic\Contracts\Config\PelasticConfigInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PelasticManager {

    /**
     * @var Container
     */
    protected $pimpleContainer;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var PelasticConfigInterface
     */
    protected $config;

    /**
     * Some shared methods
     * @param PelasticConfigInterface $config
     */
    public function __construct(PelasticConfigInterface $config = null)
    {
        $this->setContainer();
        $this->config = $config ?: new PelasticConfig();
    }

    /**
     * Set pimple container
     *
     * @return $this
     */
    protected function setContainer()
    {
        $this->pimpleContainer = PimpleContainerGateway::getContainer();

        return $this;
    }

    /**
     * Get pimple container
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->pimpleContainer;
    }


    /**
     * Get config
     *
     * @return PelasticConfig|PelasticConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
}