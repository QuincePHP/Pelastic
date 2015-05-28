<?php namespace Quince\Pelastic\Tests\Unit;

use Quince\Pelastic\Contracts\FactoryInterface;
use Quince\Pelastic\Contracts\QueryFactoryInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\QueryFactory;

class QueryFactoryTest extends BaseTestCase {

    /**
     * @var QueryFactory
     */
    protected $mainObject;

    public function setUp()
    {
        $this->mainObject = new QueryFactory();
    }

    public function test_it_implements_needed_interfaces()
    {
        $needs = [FactoryInterface::class, QueryFactoryInterface::class];

        foreach ($needs as $need) {

            $this->assertTrue(is_a($this->mainObject, $need));

        }
    }

    public function test_it_can_create_from_class()
    {
        $this->setExpectedException(PelasticInvalidArgumentException::class);

        $this->mainObject->createFromClass('\StdClass');
    }

}