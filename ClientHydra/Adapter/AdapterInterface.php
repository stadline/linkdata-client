<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

use Stadline\LinkdataClient\ClientHydra\Exception\RequestException\RequestException;

interface AdapterInterface
{
    /**
     * @throws RequestException
     */
    public function makeRequest(string $method, string $baseUrl, string $uri, array $headers = [], string $body = null): string;
}
