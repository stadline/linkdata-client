<?php

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class IriConverter
{
    private $baseUri;

    public function getIriFromObject(ProxyObject $object): string
    {

    }

    public function getIriFromClassNameAndId(string $className, $id): string
    {

    }

    public function getCollectionIriFromClassName(string $className, $id): string
    {

    }

    public function getClassnameFromIri(string $iri): string
    {

    }

    public function generateCollectionUri(string $className, array $filters = []): string
    {
        $this->generateUri();
    }

    public function generateObjectUri(string $className, $id): string
    {
        $this->generateUri();
    }

    protected function generateUri(string $baseUri, $parameters): string
    {

    }
}