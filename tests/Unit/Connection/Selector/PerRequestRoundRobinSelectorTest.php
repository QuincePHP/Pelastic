<?php namespace Quince\Pelastic\Tests\Unit\Connection\Selector;

use Quince\Pelastic\Connection\GuzzleConnection;
use Quince\Pelastic\Connection\Selector\PerRequestRoundRobinSelector;
use Quince\Pelastic\PelasticManager;
use Quince\Pelastic\Tests\Unit\BaseTestCase;

class PerRequestRoundRobinSelectorTest extends BaseTestCase {

    /**
     * @var PerRequestRoundRobinSelector
     */
    protected $selector;

    public function setUp()
    {
        $this->selector = new PerRequestRoundRobinSelector();
    }

    public function test_it_will_round_roubin_connection_usage_distribution()
    {
        for($i = 0; $i< 5; $i++) {
            $connections[$i] = rand(1, 500);
        }

        for ($i = 0; $i < 20; $i++) {
            $index = $i % 5;
            $this->assertEquals($connections[$index], $this->selector->select($connections));
        }
    }

}