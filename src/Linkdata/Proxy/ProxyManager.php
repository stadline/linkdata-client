<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Proxy;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\src\ClientHydra\Client\HydraClientInterface;

class ProxyManager
{
    private $objects = [];
    private $hydraClient;

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
        $methodToCall = \sprintf('get%s', \ucfirst(Inflector::singularize(\explode('/', $iri)[2])));
        $id = \explode('/', $iri)[3];

        // call client to resolve proxy.
        $object = $this->hydraClient->send($methodToCall, [$id]);
        $objects[$entityHash] = $object;

        return $object;
    }
}
