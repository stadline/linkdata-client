<?php

namespace Stadline\LinkdataClient\ClientHydra\Metadata;

use ReflectionClass;
use ReflectionMethod;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class MetadataManager
{
    /** @var string */
    private $entityNamespace;
    private $proxyObjectMetadata = [];

    public function __construct(string $entityNamespace)
    {
        $this->entityNamespace = $entityNamespace;
    }

    public function getClassMetadata(string $class): ProxyObjectMetadata
    {
        if (!isset($this->proxyObjectMetadata[$class])) {
            $this->parseClassMetadata($class);
        }
        return $this->proxyObjectMetadata[$class];
    }

    private function parseClassMetadata(string $class): void
    {
        $metadata = new ProxyObjectMetadata($class);

        $reflexionClass = new ReflectionClass($class);
        foreach ($reflexionClass->getProperties() as $property) {
            if (false !== $property->getDocComment() && \preg_match('/@var\s+([a-zA-Z0-9_]+)(\[\])?/', $property->getDocComment(), $matches)) {
                list(, $type) = $matches;
                if (!\class_exists($type)) {
                    $type = $this->entityNamespace.'\\'.$type;
                }
                if (!\class_exists($type)) {
                    continue;
                }
                if ((new ReflectionClass($type))->isSubclassOf(ProxyObject::class)) {
                    $metadata->setProperty($property->getName(), ProxyObject::class, $type);
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
                if (null !== ($param = $method->getParameters()[0] ?? null) && $param->getType() && \class_exists($param->getType()->getName()) && (new ReflectionClass($param->getType()->getName()))->isSubclassOf(ProxyObject::class)) {
                    $metadata->setProperty($propertyName, ProxyObject::class, $param->getType()->getName());
                }
            }
        }
        $this->proxyObjectMetadata[$class] = $metadata;
    }
}