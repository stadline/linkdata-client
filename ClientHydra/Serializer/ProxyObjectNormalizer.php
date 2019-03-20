<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Serializer;

use ReflectionMethod;
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
    /** @var string */
    private $entityNamespace;
    /** @var IriConverter */
    private $iriConverter;
    private $proxyObjectMetadata = [];

    public function setProxyManager(ProxyManager $proxyManager): void
    {
        $this->proxyManager = $proxyManager;
    }

    public function setEntityNamespace(string $entityNamespace): void
    {
        $this->entityNamespace = $entityNamespace;
    }

    public function setIriConverter(IriConverter $iriConverter): void
    {
        $this->iriConverter = $iriConverter;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        if (($context['classContext'] ?? null) === \get_class($object)) {
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

        // generate metadata cache
        if (!isset($this->proxyObjectMetadata[$class])) {
            $metadata = [];

            $reflexionClass = new \ReflectionClass($context[AbstractNormalizer::OBJECT_TO_POPULATE]);
            foreach ($reflexionClass->getProperties() as $property) {
                if (false !== $property->getDocComment() && \preg_match('/@var\s+([a-zA-Z0-9_]+)(\[\])?/', $property->getDocComment(), $matches)) {
                    list(, $type) = $matches;
                    if (!\class_exists($type)) {
                        $type = $this->entityNamespace.'\\'.$type;
                    }
                    if (!\class_exists($type)) {
                        continue;
                    }
                    if ((new \ReflectionClass($type))->isSubclassOf(ProxyObject::class)) {
                        $metadata[] = $property->getName();
                    }
                }
            }
            foreach ($reflexionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if (0 === \strpos($method->getName(), 'set')) {
                    $propertyName = \lcfirst(\substr($method->getName(), 3));
                    if (\in_array($propertyName, $metadata, true)) {
                        continue;
                    }
                    // If parameter is proxy object
                    if (null !== ($param = $method->getParameters()[0] ?? null) && $param->getType() && \class_exists($param->getType()->getName()) && (new \ReflectionClass($param->getType()->getName()))->isSubclassOf(ProxyObject::class)) {
                        $metadata[] = $propertyName;
                    }
                }
            }
            $this->proxyObjectMetadata[$class] = $metadata;
        }

        if (isset($context[AbstractNormalizer::OBJECT_TO_POPULATE]) && $context[AbstractNormalizer::OBJECT_TO_POPULATE] instanceof ProxyObject && null !== ($metadata = $this->proxyObjectMetadata[\get_class($context[AbstractNormalizer::OBJECT_TO_POPULATE])])) {
            foreach ($metadata as $propName) {
                if (isset($data[$propName])) {
                    if (\is_array($data[$propName])) {
                        $properties = [];
                        foreach ($data[$propName] as $elt) {
                            if (\is_array($elt) && isset($elt['@id'])) {
                                $subObject = $this->proxyManager->getProxyFromIri($elt['@id']);
                                $subObject->_refreshPartial($elt);
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
