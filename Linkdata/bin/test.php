#!/usr/bin/env php
<?php

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);
\set_time_limit(0);
require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;
use Stadline\LinkdataClient\ClientHydra\Adapter\GuzzleAdapter;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Serializer\ProxyObjectNormalizer;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Stadline\LinkdataClient\Linkdata\Client\LinkdataClient;
use Stadline\LinkdataClient\Linkdata\Entity\Universe;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

$loader = require __DIR__ . '/../../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

/*
 * Test script
 */
//$baseUri = 'https://linkdata.dev.geonaute.com';
$baseUri = 'http://localhost.local:8000';
$iriPrefix = '/v2';
$entityNamespace = 'Stadline\LinkdataClient\Linkdata\Entity';
$jwt = getenv('JWT');

$adapter = new GuzzleAdapter($baseUri);
$adapter->setDefaultHeader('Authorization', 'Bearer ' . $jwt);

$iriConverter = new IriConverter($entityNamespace, $iriPrefix);

$normalizer = new ProxyObjectNormalizer();
$normalizer->setEntityNamespace($entityNamespace);
$normalizer->setIriConverter($iriConverter);

$encoders = [new JsonEncoder()];
$normalizers = [$normalizer, new ObjectNormalizer()];

$serializer = new Serializer($normalizers, $encoders);

$proxyManager = new ProxyManager($adapter, $iriConverter, $serializer);
$normalizer->setProxyManager($proxyManager);

$linkdataClient = new LinkdataClient($proxyManager, $adapter);

$linkdataClient->getAdapter()->makeRequest("GET", "/v2/me");

$collection = $linkdataClient->getProxyManager()->getCollection(Universe::class);
foreach ($collection as $entity) {
    /** @var \Stadline\LinkdataClient\Linkdata\Entity\Sport $sport */
    foreach ($entity->getSports() as $sport) {
        $sport->getId();
        $sport->getTranslatedNames();
    }
}
