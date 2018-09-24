<?php

namespace Stadline\LinkdataClient\ClientHydra\Serializer;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProxyObjectNormalizer extends ObjectNormalizer
{
    /** @var ProxyManager */
    private $proxyManager;
    /** @var string */
    private $entityNamespace;

    public function setProxyManager(ProxyManager $proxyManager): void
    {
        $this->proxyManager = $proxyManager;
    }

    public function setEntityNamespace(string $entityNamespace): void
    {
        $this->entityNamespace = $entityNamespace;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        // Only support array
        if (!\is_array($data)) {
            throw new InvalidArgumentException('ProxyObjectDenormalizer::denormalize requires an array in parameter');
        }

        if ($this->proxyManager->hasObject($data['@id'])) {
            return $this->proxyManager->getObject($data['@id']);
        }

        $realclass = \sprintf('%s\%s', $this->entityNamespace, HydraParser::getType($data));

        $reflectionClass = new \ReflectionClass($realclass);
        if (!$reflectionClass->isSubclassOf(ProxyObject::class)) {
            throw new RuntimeException(sprintf('%s must be a a subclass of ProxyObject', $realclass));
        }

        /** @var ProxyObject $object */
        $object = parent::denormalize($data, $realclass, $format, $context);
//        $object->setProxyManager($this->proxyManager);

        return $object;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($format !== 'json') {
            return false;
        }

        return ProxyObject::class === $type && \is_array($data2) && HydraParser::isHydraObjectResponse($data2);
    }
}