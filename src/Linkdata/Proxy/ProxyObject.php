<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Proxy;

use Doctrine\Common\Annotations\AnnotationReader;
use Stadline\LinkdataClient\src\Linkdata\Annotation\Proxy;
use Stadline\LinkdataClient\src\Linkdata\Client\LinkdataClient;
use Stadline\LinkdataClient\src\Linkdata\Entity\Universe;

/**
 * @property Universe $universe
 */
class ProxyObject
{
    /** @var LinkdataClient */
    private $client;

    public function hydrate($iri)
    {
        return $this->client->get($iri);
    }

    public function setClient(LinkdataClient $client): void
    {
        $this->client = $client;
    }
}
