<?php

require_once __DIR__ . '/bootstrap.php';

/** @var \Elasticsearch\Client $client */
$client = \Elasticsearch\ClientBuilder::create()->setHosts(['http://localhost:9200'])->build();

$manager = new \Quince\Pelastic\PelasticManager($client);

$document = new \Quince\Pelastic\Document(['name' => 'reza', 'last_name' => 'shadman'], time());

$indexRequest = new \Quince\Pelastic\Api\Endpoints\Document\Index\IndexRequest();

$indexRequest->setIndex('users')->setType('common')->setDocument($document);

/** @var \Quince\Pelastic\Contracts\Api\Endpoints\Document\Index\IndexResponseInterface $result */
$result = $manager->executeRequest($indexRequest);

var_dump($result->id());