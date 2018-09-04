<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Client\HydraClientInterface;

class ProxyObject
{
    /** @var HydraClientInterface */
    private $client;

    private $hydrate = true;

    /**
     * Hydrate an object with an IRI given.
     * If hydrate is set to false, it returns the IRI given.
     *
     * @param string $iri
     *
     * @return ProxyObject|string
     */
    public function hydrate(string $iri)
    {
        if (!$this->hydrate) {
            return $iri;
        }

        return $this->client->getProxy($iri);
    }

    public function setClient(HydraClientInterface $client): void
    {
        $this->client = $client;
    }

    public function setHydrate(bool $hydrate): void
    {
        $this->hydrate = $hydrate;
    }
}
