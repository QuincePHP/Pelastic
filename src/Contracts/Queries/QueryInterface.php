<?php namespace Quince\Pelastic\Contracts\Queries;

use Quince\Pelastic\Contracts\AccessorMutatorInterface;
use Quince\Pelastic\Contracts\ArrayableInterface;

interface QueryInterface extends AccessorMutatorInterface, BoostableInterface, ArrayableInterface {

}
