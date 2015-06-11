<?php namespace Quince\Pelastic\Contracts\Api\Request;

interface RequestInterface extends
    RequestHttpPresenterInterface,
    RequestElasticsearchClientPresenterInterface,
    ResponsableRequestInterface
{

}