<?php

require_once __DIR__ . '/bootstrap.php';

use Elasticsearch\ClientBuilder;
use Quince\Pelastic\PelasticManager;
use Quince\Pelastic\Document;
use Quince\Pelastic\Api\Endpoints\Document\Index\IndexRequest;

/*
 * Create the global elasticsearch client builder
 */
/** @var \Elasticsearch\Client $client */
$client = ClientBuilder::create()->setHosts(['http://localhost:9200'])->build();

/*
 * Create a new PelasticManager Instance
 * Then pass the elasticsearch client to that
 */
$manager = new PelasticManager($client);

$document = new Document(['name' => 'reza', 'last_name' => 'shadman']);

$indexRequest = (new IndexRequest())->setIndex('users')
                                    ->setType('common')
                                    ->setDocument($document);

/*
 * When you execute a request, the above document is updated (the response id is injected to that)
 * The IndexResponseInterface class is a data object containing response attributes
 */
/** @var \Quince\Pelastic\Contracts\Api\Endpoints\Document\Index\IndexResponseInterface $result */
$result = $manager->executeRequest($indexRequest);

/*
 * This is the raw result data
 */
echo "\n Raw Result Data:\n";
var_dump($result->toArray());

/*
 * This is the updated/generated document id
 */
echo "\nDocument ID:\n";
var_dump($document->getId());

/*
 * This is the version of the document
 */
echo "\nDocument Version:\n";
var_dump($result->getVersion());