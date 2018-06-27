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

    public function __get($propertyName)
    {
        $annotationReader = new AnnotationReader();

        $reflectionProperty = new \ReflectionProperty($this, $propertyName);
        $propertyAnnotations = $annotationReader->getPropertyAnnotations($reflectionProperty);

        foreach ($propertyAnnotations as $propertyAnnotation) {
            if ($propertyAnnotation instanceof Proxy) {
                // getUniverse
                $methodToCall = \sprintf('get%s', \ucfirst($propertyName));

                return $this->hydrate($this->{$methodToCall}());
            }
        }
    }

    private function hydrate($iri)
    {
        return $this->client->get($iri);
    }

    public function setClient(LinkdataClient $client): void
    {
        $this->client = $client;
    }
}
