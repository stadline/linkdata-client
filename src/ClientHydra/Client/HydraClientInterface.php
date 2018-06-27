<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Client;

use Stadline\LinkdataClient\src\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\src\Linkdata\Proxy\ProxyObject;

interface HydraClientInterface
{
    /**
     * @throws ClientHydraException
     */
    public function send(string $method, array $args);

    public function getProxy(string $iri): ProxyObject;
}
