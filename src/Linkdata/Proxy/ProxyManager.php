<?php

namespace Stadline\LinkdataClient\src\Linkdata\Proxy;

use Doctrine\Common\Util\Inflector;
use Stadline\LinkdataClient\src\ClientHydra\Utils\UriConverter;
use Stadline\LinkdataClient\src\Linkdata\Client\LinkdataClient;

class ProxyManager
{
    private $objects = [];
    private $client;

    public function get(string $iri): ProxyObject
    {
        $entityHash = sha1($iri);

        if (isset($this->objects[$entityHash])) {
            return $this->objects[$entityHash];
        }

        // resolve method to call.
        $methodToCall = sprintf('get%s', ucfirst(Inflector::singularize(explode('/', $iri)[2])));
        $id = explode('/', $iri)[3];

        var_dump($methodToCall, $id);
        // call client to resolve proxy.
        $object = $this->client->$methodToCall($id);
        $objects[$entityHash] = $object;

        return $object;
    }

    public function setClient(LinkdataClient $client)
    {
        $this->client = $client;
    }
}