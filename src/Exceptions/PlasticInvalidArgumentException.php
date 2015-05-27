<?php namespace Quince\Exceptions;

use Quince\Pelastic\Contracts\Exceptions\PelasticExceptionInterface;

class PelasticInvalidArgumentException extends \InvalidArgumentException implements PelasticExceptionInterface {

}