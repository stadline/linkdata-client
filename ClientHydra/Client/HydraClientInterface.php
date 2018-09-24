<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

interface HydraClientInterface
{
    /**
     * @throws ClientHydraException
     */
    public function send(string $method, array $args);
}
