<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\DataCollector;

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

    public function getName()
    {
        return 'linkdata_client.linkdata_collector';
    }

    public function getNbrCall()
    {
        return \count($this->data);
    }

    public function getTotalTime()
    {
        $time = 0;

        foreach ($this->data as $request) {
            $time += $request['time'];
        }

        $time = $time * 1000;

        return $time;
    }

    public function getNbrErrors()
    {
        $errors = 0;

        return $errors;
    }

    public function getCalls()
    {
        return $this->data;
    }
}
