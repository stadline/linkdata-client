<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Adapter;

interface AdapterInterface
{
    public function makeRequest(string $method, string $baseUrl, string $uri, array $headers = [], string $body = null): string;
}
