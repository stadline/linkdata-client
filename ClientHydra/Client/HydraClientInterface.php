<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Adapter\HttpAdapterInterface;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

interface HydraClientInterface
{
    public function getCollection(string $classname, array $filters = []): ProxyCollection;

    public function getObject(string $className, $id, bool $autoHydrate = false): ?ProxyObject;

    public function contains($object): bool;

    public function putObject(ProxyObject $object): ProxyObject;

    public function deleteObject(...$objectOrId): void;

    public function postObject(ProxyObject $object): ProxyObject;

    public function getAdapter(): HttpAdapterInterface;

    public function getProxyFromIri(string $iri, ?bool $autoHydrate = false): ?ProxyObject;

    public function cacheWarmUp(): void;
}
