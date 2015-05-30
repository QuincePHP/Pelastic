<?php namespace Quince\Pelastic\Tests\Unit;

use Quince\Pelastic\Contracts\FactoryInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Contracts\QueryFactoryInterface;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Exceptions\PelasticLogicException;
use Quince\Pelastic\Queries\TermQuery;
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
        $termQuery = $this->mainObject->createFromClass(TermQuery::class);

        $this->assertTrue(is_a($termQuery, TermQuery::class));

        $this->setExpectedException(PelasticInvalidArgumentException::class);

        $this->mainObject->createFromClass('\StdClass');
    }

    public function test_it_can_create_from_keyword()
    {
        $termQuery = $this->mainObject->create('term');

        $this->assertTrue(is_a($termQuery, TermQuery::class));

        $this->setExpectedException(PelasticLogicException::class);

        $termQuery->toArray();

        $termQuery = $this->mainObject->create('term', ['title', 'some title']);

        $expected = [
            'term' => [
                'title' => [
                    'value' => 'some title'
                ]
            ]
        ];

        $this->assertEquals($expected, $termQuery->toArray());
    }

    public function test_get_interface()
    {
        $this->assertEquals($this->mainObject->getInterface(), QueryInterface::class);
    }
}