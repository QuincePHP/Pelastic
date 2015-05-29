<?php namespace Quince\Pelastic\Tests\Unit;

use Mockery as M;

class BaseTestCase extends \PHPUnit_Framework_TestCase {

    protected $mainObject;

    /**
     * Get mockery for a class
     *
     * @param $mockable
     * @return M\MockInterface
     */
    public function getMockery($mockable)
    {
        return M::mock($mockable);
    }

}