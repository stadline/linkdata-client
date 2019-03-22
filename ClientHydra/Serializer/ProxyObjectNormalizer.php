<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Serializer;

use Stadline\LinkdataClient\ClientHydra\Metadata\MetadataManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProxyObjectNormalizer extends ObjectNormalizer
{
    /** @var ProxyManager */
    private $proxyManager;
    /** @var IriConverter */
    private $iriConverter;
    /** @var MetadataManager */
    private $metadataManager;

    public function setMetadataManager(MetadataManager $metadataManager): void
    {
        $this->metadataManager = $metadataManager;
    }

    public function setProxyManager(ProxyManager $proxyManager): void
    {
        $this->proxyManager = $proxyManager;
    }

    public function setIriConverter(IriConverter $iriConverter): void
    {
        $this->iriConverter = $iriConverter;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $classContext = $context['classContext'] ?? null;
        if (is_string($classContext)) {
            $context['classContext'] = [$classContext];
        } elseif (null === $classContext) {
            $context['classContext'] = [];
        }

        if (in_array(\get_class($object), $context['classContext'], true)) {
            return parent::normalize($object, $format, $context);
        }

        return $this->iriConverter->getIriFromObject($object);
    }

    /**
     * Denormalizes data back into an object of the given class.
     */
    public function denormalize($data, $class, $format = null, array $context = []): ProxyObject
    {
        // Only support array
        if (!\is_array($data)) {
            throw new InvalidArgumentException('ProxyObjectDenormalizer::denormalize requires an array in parameter');
        }

        if (isset($context[AbstractNormalizer::OBJECT_TO_POPULATE]) && $context[AbstractNormalizer::OBJECT_TO_POPULATE] instanceof ProxyObject && null !== ($metadata = $this->metadataManager->getClassMetadata(\get_class($context[AbstractNormalizer::OBJECT_TO_POPULATE])))) {
            foreach ($metadata->getPropertiesNameByTypes(ProxyObject::class) as $propName) {
                if (isset($data[$propName])) {
                    if (\is_array($data[$propName])) {
                        $properties = [];
                        foreach ($data[$propName] as $elt) {
                            if (\is_array($elt) && isset($elt['@id'])) {
                                $subObject = $this->proxyManager->getProxyFromIri($elt['@id']);
                                $subObject->_refresh($elt);
                                $properties[] = $subObject;
                            } elseif (\is_string($elt) && $this->iriConverter->isIri($elt)) {
                                $properties[] = $this->proxyManager->getProxyFromIri($elt);
                            } else {
                                $properties[] = $elt;
                            }
                        }
                        $data[$propName] = $properties;
                    } else {
                        $data[$propName] = $this->proxyManager->getProxyFromIri($data[$propName]);
                    }
                }
            }
        }

        return parent::denormalize($data, $class, $format, $context);
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed  $data   Data to denormalize from
     * @param string $type   The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ('json' !== $format) {
            return false;
        }

        $reflectionClass = new \ReflectionClass($type);

        return $reflectionClass->isSubclassOf(ProxyObject::class) && \is_array($data) && HydraParser::isHydraObjectResponse($data);
    }
}
