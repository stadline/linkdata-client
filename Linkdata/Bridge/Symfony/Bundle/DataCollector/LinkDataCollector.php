<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Bridge\Symfony\Bundle\DataCollector;

use Stadline\LinkdataClient\Linkdata\Client\LinkdataClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class LinkDataCollector extends DataCollector
{
    private $client;

    public function __construct(LinkdataClient $client)
    {
        $this->client = $client;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        $this->data = $this->client->getAdapter()->getDebugData();
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function getName(): string
    {
        return 'linkdata_client.linkdata_collector';
    }

    public function getNbrCall(): int
    {
        return \count($this->data);
    }

    public function getTotalTime(): float
    {
        $time = 0;
        foreach ($this->data as $request) {
            $time += $request['time'];
        }

        return $time * 1000;
    }

    public function getNbrErrors(): int
    {
        $errors = 0;

        return $errors;
    }

    public function getCalls(): array
    {
        return $this->data;
    }
}
