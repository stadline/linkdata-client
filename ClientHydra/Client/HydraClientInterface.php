<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;

interface HydraClientInterface
{
    public function getCollection(string $classname, array $filters = []): ProxyCollection;
    public function getObject(string $className, $id, bool $autoHydrate = false): ?ProxyObject;

    public function contains($object): bool;
    public function addObject(string $iri, ProxyObject $object): void;

    public function putObject(ProxyObject $object): ProxyObject;
    public function deleteObject(...$objectOrId): void;
    public function postObject(ProxyObject $object): ProxyObject;

    public function getAdapter(): AdapterInterface;
}
