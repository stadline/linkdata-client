<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;

class ProxyManager
{
    private $objects = [];
    private $hydraClient;
    private $config;

    public function __construct(HydraClientInterface $hydraClient)
    {
        $this->hydraClient = $hydraClient;
    }

    public function getProxy(string $iri): ProxyObject
    {
        $entityHash = \sha1($iri);

        if (isset($this->objects[$entityHash])) {
            return $this->objects[$entityHash];
        }

        // resolve method to call.
        $methodToCall = \ucfirst(Inflector::singularize(\explode('/', $iri)[2]));
        $tempMethodToCall = 'get';

        if (-1 !== \strstr('_', $methodToCall)) {
            foreach (\explode('_', $methodToCall) as $part) {
                if ('get' !== $part) {
                    $tempMethodToCall .= \ucfirst(Inflector::singularize($part));
                }
            }

            $methodToCall = $tempMethodToCall;
        }

        $id = \explode('/', $iri)[3];

        // call client to resolve proxy.
        $object = $this->hydraClient->send($methodToCall, [$id]);
        $objects[$entityHash] = $object;

        return $object;
    }

    private function loadConfiguration(): array
    {
        $json = \file_get_contents(__DIR__.'/../Config/config.json');

        return \json_decode($json, true);
    }
}
