<?php

require_once __DIR__ . '/bootstrap.php';

use Elasticsearch\ClientBuilder;
use Quince\Pelastic\Api\Endpoints\Document\Get\GetRequest;
use Quince\Pelastic\Api\Endpoints\Document\Index\IndexRequest;
use Quince\Pelastic\Document;
use Quince\Pelastic\PelasticManager;

$client = ClientBuilder::create()->setHosts(['http://localhost:9200'])->build();

$manager = new PelasticManager($client);

$indexRequest = new IndexRequest();
$indexRequest->setIndex('users')
             ->setType('common')
             ->setDocument($document = new Document(['username' => 'John'], 'document1'));

$result = $manager->executeRequest($indexRequest);
$documentId = $document->getId();


$getRequest = (new GetRequest())->setId($documentId)->setIndex('users')->setType('common');

/** @var \Quince\Pelastic\Contracts\Api\Endpoints\Document\Get\GetResponseInterface $result */
$result = $manager->executeRequest($getRequest);

var_dump($result->getDocument()->toArray());
var_dump($result->toArray());