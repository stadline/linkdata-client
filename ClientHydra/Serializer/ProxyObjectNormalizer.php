<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Serializer;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyManager;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Utils\HydraParser;
use Stadline\LinkdataClient\ClientHydra\Utils\IriConverter;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
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
     *
     * @param mixed  $data    Data to restore
     * @param string $class   The expected class to instantiate
     * @param string $format  Format the given data was extracted from
     * @param array  $context Options available to the denormalizer
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     *
     * @return object
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        // Only support array
        if (!\is_array($data)) {
            throw new InvalidArgumentException('ProxyObjectDenormalizer::denormalize requires an array in parameter');
        }

        if (isset($context[AbstractNormalizer::OBJECT_TO_POPULATE]) && $context[AbstractNormalizer::OBJECT_TO_POPULATE] instanceof ProxyObject) {
            $reflexionClass = new \ReflectionClass($context[AbstractNormalizer::OBJECT_TO_POPULATE]);
            foreach($data as $propName => $propValue) {
                if (null === $propValue && '' === $propValue) {
                    continue;
                }

                $setterMethod = sprintf('set%s', Inflector::classify($propName));
                if (!$reflexionClass->hasMethod($setterMethod)) {
                    continue;
                }

                $setter = $reflexionClass->getMethod($setterMethod);
                if (null !== ($param = $setter->getParameters()[0] ?? null) && ProxyObject::class === $param->getType()) {
                    $data[$propName] = $this->proxyManager->getProxyFromIri($propValue);
                    continue;
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
