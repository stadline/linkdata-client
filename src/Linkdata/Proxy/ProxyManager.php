<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Proxy;

use Doctrine\Common\Inflector;
use Stadline\LinkdataClient\src\Linkdata\Client\LinkdataClient;

class ProxyManager
{
    private $objects = [];

    public function get(string $iri, LinkdataClient $linkdataClient): ProxyObject
    {
        $entityHash = \sha1($iri);

        if (isset($this->objects[$entityHash])) {
            return $this->objects[$entityHash];
        }

        // resolve method to call.
        $methodToCall = \sprintf('get%s', \ucfirst(Inflector::singularize(\explode('/', $iri)[2])));
        $id = \explode('/', $iri)[3];

        // call client to resolve proxy.
        $object = $linkdataClient->send($methodToCall, [$id], $linkdataClient);
        $objects[$entityHash] = $object;

        return $object;
    }
}
