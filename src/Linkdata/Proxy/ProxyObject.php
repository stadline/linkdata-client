<?php

namespace Stadline\LinkdataClient\src\Linkdata\Proxy;
use Stadline\LinkdataClient\src\Linkdata\Client\LinkdataClient;
use Stadline\LinkdataClient\src\Linkdata\Entity\Universe;

class ProxyObject
{
    /** @var LinkdataClient */
    private $client;

    public function hydrate($iri)
    {
        return $this->client->get($iri);
    }

    public function setClient(LinkdataClient $client)
    {
        $this->client = $client;
    }
}
