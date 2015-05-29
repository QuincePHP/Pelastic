<?php namespace Quince\Pelastic\Tests\Unit;

use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Contracts\ArrayableInterface;
use Quince\Pelastic\Contracts\Queries\QueryInterface;
use Quince\Pelastic\Contracts\Queries\TermQueryInterface;
use Quince\Pelastic\Queries\TermQuery;

class TermQueryTest extends BaseTestCase {

    /**
     * @var TermQuery
     */
    protected $mainObject;

    public function setUp()
    {
        $this->mainObject = new TermQuery('title', 'This is a title');
        parent::setUp();
    }

    public function test_class_implements_the_needed_interfaces()
    {
        $needs = [QueryInterface::class, TermQueryInterface::class, ArrayableInterface::class];

        foreach ($needs as $need) {

            $this->assertTrue(is_a($this->mainObject, $need));

        }
    }

    public function test_final_generated_array_with_and_without_construct()
    {
        $expected = [
            'term' => [
                'title' => [
                    'value' => $string = 'some query string'
                ]
            ]
        ];

        $this->mainObject = new TermQuery();

        $this->mainObject->setField('title');

        $this->mainObject->setQuery($string);

        $this->assertEquals($expected, $this->mainObject->toArray());

        $this->mainObject->setQuery('ss');

        $this->assertNotEquals($expected, $this->mainObject->toArray());

        $this->mainObject->setValue($string);

        $this->assertEquals($expected, $this->mainObject->toArray());

        $expected['term']['title']['boost'] = 500;

        $this->mainObject->setBoost(500);

        $this->assertEquals($expected, $this->mainObject->toArray());

        $this->setExpectedException(PelasticInvalidArgumentException::class);

        $this->mainObject->setBoost('salam');
    }
}