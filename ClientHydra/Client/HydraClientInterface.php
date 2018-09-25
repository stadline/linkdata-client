<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Exception\ClientHydraException;

interface HydraClientInterface
{
    /**
     * @throws ClientHydraException
     */
    public function call(string $method, array $args);
}
