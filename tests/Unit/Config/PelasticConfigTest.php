<?php namespace Quince\Pelastic\Tests\Unit\Config;

use Quince\Pelastic\Config\PelasticConfig;
use Quince\Pelastic\Connection\Pool\NoPingConnectionPool;
use Quince\Pelastic\Connection\Selector\PerRequestRoundRobinSelector;
use Quince\Pelastic\Exceptions\PelasticInvalidArgumentException;
use Quince\Pelastic\Tests\Unit\BaseTestCase;

class PelasticConfigTest extends BaseTestCase {

    /**
     * @var PelasticConfig
     */
    protected $config;

    public function setUp()
    {
        $this->config = new PelasticConfig();
    }

    public function test_set_hosts_method()
    {
        $this->config->setHosts($hosts = ['http://localhost:9200', '1']);

        $this->assertEquals($this->config->getHosts(), $hosts);
    }

    public function test_set_selector_method()
    {
        $selector = $this->getMockery(new PerRequestRoundRobinSelector);

        $this->config->setSelector($selector);

        $this->assertInstanceOf(PerRequestRoundRobinSelector::class, $this->config->getSelector());
    }

    public function test_set_pool_method()
    {
        $class = NoPingConnectionPool::class;

        $this->config->setConnectionPoolStrategy($class);

        $this->assertEquals($this->config->getConnectionPoolStrategy(), $class);
    }

    public function test_auth()
    {
        $this->assertNull($this->config->getAuthParams());

        $auth = [
            'username' => '12',
            'password' => '123',
            'method' => 'Basic'
        ];

        $this->config->setAuth($auth['username'], $auth['password'], $auth['method']);

        $this->assertEquals($this->config->getAuthParams(), $auth);

        $this->setExpectedException(PelasticInvalidArgumentException::class);

        $this->config->setAuth('sss', 'ss', 'asdasd');
    }
}