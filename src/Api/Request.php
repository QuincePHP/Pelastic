<?php namespace Quince\Pelastic\Api;

use Quince\Pelastic\AccessibleMutatableTrait;
use Quince\Pelastic\Contracts\Api\RequestInterface;

abstract class Request implements  RequestInterface {

    use AccessibleMutatableTrait;

}