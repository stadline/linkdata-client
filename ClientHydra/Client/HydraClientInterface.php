<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Client;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyCollection;
use Stadline\LinkdataClient\ClientHydra\Adapter\AdapterInterface;

interface HydraClientInterface
{
    public function getObjectFromIri(string $iri): ?ProxyObject;
    public function contains($object): bool;
    public function getProxyFromIri(string $iri): ?ProxyObject;
    public function getObject(string $className, $id): ?ProxyObject;
    public function hasObject(string $iri): bool;
    public function addObject(string $iri, ProxyObject $object): void;
    public function getCollection(string $classname, array $filters = []): ProxyCollection;
    public function putObject(ProxyObject $object): ProxyObject;
    public function deleteObject(...$objectOrId): void;
    public function postObject(ProxyObject $object): ProxyObject;
    public function getAdapter(): AdapterInterface;
}
