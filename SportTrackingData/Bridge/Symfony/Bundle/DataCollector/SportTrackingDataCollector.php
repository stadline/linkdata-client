<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Bridge\Symfony\Bundle\DataCollector;

use SportTrackingDataSdk\ClientHydra\Metadata\MetadataManager;
use SportTrackingDataSdk\SportTrackingData\Client\SportTrackingDataClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class SportTrackingDataCollector extends DataCollector
{
    private $client;
    private $metadataManager;

    public function __construct(SportTrackingDataClient $client, MetadataManager $metadataManager)
    {
        $this->client = $client;
        $this->metadataManager = $metadataManager;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        $this->data = $this->client->getAdapter()->getDebugData();
        $this->data['metadata'] = $this->metadataManager->getClassMetadatas();
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function getName(): string
    {
        return 'sporttrackingdata_sdk.sporttrackingdata_collector';
    }

    public function getNbrCall(): int
    {
        $c = 0;
        foreach ($this->getCalls() as $request) {
            if (false === $request['cacheOrigin']) {
                ++$c;
            }
        }

        return $c;
    }

    public function getMetaData(): array
    {
        return $this->data['metadata'];
    }

    public function getTotalTime(): float
    {
        $time = 0;
        foreach ($this->getCalls() as $request) {
            $time += $request['time'];
        }

        return $time * 1000;
    }

    public function getNbrErrors(): int
    {
        $errors = 0;
        foreach ($this->getCalls() as $request) {
            if (true === $request['isError']) {
                ++$errors;
            }
        }

        return $errors;
    }

    public function getNbrCacheCall(): int
    {
        return \count($this->getCalls());
    }

    public function getCalls(): array
    {
        return $this->data['calls'];
    }

    public function getConfiguration(): ?array
    {
        return $this->data['config'];
    }
}
