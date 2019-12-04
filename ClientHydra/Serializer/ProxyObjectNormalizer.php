<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Serializer;

use SportTrackingDataSdk\ClientHydra\Client\HydraClientInterface;
use SportTrackingDataSdk\ClientHydra\Metadata\ProxyObjectMetadata;
use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use SportTrackingDataSdk\ClientHydra\Utils\HydraParser;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProxyObjectNormalizer extends ObjectNormalizer
{
    /** @var HydraClientInterface */
    private $hydraClient;

    public function setHydraClient(HydraClientInterface $hydraClient): void
    {
        $this->hydraClient = $hydraClient;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $classContext = $context['classContext'] ?? null;
        if (\is_string($classContext)) {
            $context['classContext'] = [$classContext];
        } elseif (null === $classContext) {
            $context['classContext'] = [\get_class($object)];
        }

        if ($object instanceof \DateTime) {
            return $object->format(DATE_ATOM);
        }

        if (!$object instanceof ProxyObject || \in_array(\get_class($object), $context['classContext'], true)) {
            // save current class context
            $context['currentClassContext'] = \get_class($object);
            $data = parent::normalize($object, $format, $context);

            // In put case, only add field if value is modified
            if (true === ($context['putContext'] ?? null)) {
                $editedProperties = $object->_getEditedProperties($data);
                foreach ($data as $fieldName => $useless) {
                    if (!\in_array($fieldName, $editedProperties, true)) {
                        unset($data[$fieldName]);
                    }
                }
            }

            return $data;
        }

        return $this->hydraClient->getIriConverter()->getIriFromObject($object);
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

        $metadata = $this->hydraClient->getMetadataManager()->getClassMetadata(\get_class($context[AbstractNormalizer::OBJECT_TO_POPULATE]));
        if (isset($context[AbstractNormalizer::OBJECT_TO_POPULATE]) && $context[AbstractNormalizer::OBJECT_TO_POPULATE] instanceof ProxyObject) {
            foreach ($metadata->getPropertiesNameByTypes(ProxyObject::class) as $propName) {
                if (isset($data[$propName])) {
                    if (\is_array($data[$propName])) {
                        if (isset($data[$propName]['@id'])) {
                            $subObject = $this->hydraClient->getProxyFromIri($data[$propName]['@id']);
                            $subObject->_refresh($data[$propName]);
                            $data[$propName] = $subObject;
                        } else {
                            $properties = [];
                            foreach ($data[$propName] as $elt) {
                                if (\is_array($elt) && isset($elt['@id'])) {
                                    $subObject = $this->hydraClient->getProxyFromIri($elt['@id']);
                                    $subObject->_refresh($elt);
                                    $properties[] = $subObject;
                                    continue;
                                }
                                if (\is_string($elt) && $this->hydraClient->getIriConverter()->isIri($elt)) {
                                    $properties[] = $this->hydraClient->getProxyFromIri($elt);
                                } else {
                                    $properties[] = $elt;
                                }
                            }
                            $data[$propName] = $properties;
                        }
                    } else {
                        $data[$propName] = $this->hydraClient->getProxyFromIri($data[$propName]);
                    }
                }
            }
            foreach ($metadata->getPropertiesNameByTypes(ProxyObjectMetadata::TYPE_DATETIME) as $propName) {
                if (\is_string($data[$propName] ?? null)) {
                    $data[$propName] = new \DateTime($data[$propName]);
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

        if ('[]' === \substr($type, -2)) {
            return false;
        }

        return (new \ReflectionClass($type))->isSubclassOf(ProxyObject::class) && \is_array($data) && HydraParser::isHydraObjectResponse($data);
    }
}
