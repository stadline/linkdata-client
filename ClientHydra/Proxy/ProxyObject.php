<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;

class ProxyObject
{
    /** @var HydraClientInterface */
    private $client;

    public function hydrate($iri)
    {
        return $this->client->getProxy($iri);
    }

    public function setClient(HydraClientInterface $client): void
    {
        $this->client = $client;
    }
}
