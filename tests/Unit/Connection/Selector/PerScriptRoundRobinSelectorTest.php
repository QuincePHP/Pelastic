<?php namespace Quince\Pelastic\Tests\Unit\Connection\Selector;

use Quince\Pelastic\Connection\Selector\PerScriptRoundRobinSelector;
use Quince\Pelastic\Tests\Unit\BaseTestCase;

class PerScriptRoundRobinSelectorTest extends BaseTestCase {

    /**
     * @var PerScriptRoundRobinSelector
     */
    protected $selector;

    public function setUp()
    {
        $this->selector = new PerScriptRoundRobinSelector();
    }

    public function test_it_will_return_the_same_connection_for_ever()
    {
        for ($i = 1; $i < 10; $i++) {
            $connections[$i] = rand(1, 200000);
        }

        $first = null;

        for ($i = 1; $i < 50; $i++) {
            $current = $this->selector->select($connections);
            if(is_null($first)) {
                $first = $current;
            }

            $this->assertEquals($first, $current);
        }
    }

}