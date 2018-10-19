<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use Stadline\LinkdataClient\ClientHydra\Exception\RequestException;

interface AdapterInterface
{
    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $uri, array $headers = [], string $body = null): ResponseInterface;
}
