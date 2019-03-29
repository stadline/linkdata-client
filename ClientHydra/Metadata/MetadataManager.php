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

    public function getClassMetadatas(): array
    {
        return $this->proxyObjectMetadata;
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

        // search in properties
        foreach ($reflexionClass->getProperties() as $property) {
            if (false !== $property->getDocComment() && \preg_match('/@var\s+\\\\?\??([a-zA-Z0-9_]+)(\[\])?/', $property->getDocComment(), $matches)) {
                [, $type] = $matches;

                $type = $this->parseType($type);

                $metadata->setProperty(
                    $property->getName(),
                    $type['type'],
                    [
                        'isProxyObject' => $type['isProxyObject'] ?? false
                    ]
                );
            }
        }

        // search in setters parameters
        foreach ($reflexionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (0 === \strpos($method->getName(), 'set')) {
                $propertyName = \lcfirst(\substr($method->getName(), 3));

                // property already known : ignore
                if (\in_array($propertyName, $metadata, true)) {
                    continue;
                }

                // missing parameter : ignore
                if (null === ($param = $method->getParameters()[0] ?? null)) {
                    continue;
                }

                // no parameter typing : ignore
                if (!$param->getType()) {
                    continue;
                }

                $type = $this->parseType($param->getType()->getName());

                $metadata->setProperty(
                    $propertyName,
                    $type['type'],
                    [
                        'isProxyObject' => $type['isProxyObject'] ?? false
                    ]
                );
            }
        }

        $this->proxyObjectMetadata[$class] = $metadata;
    }

    private function parseType(string $type): array
    {
        $return = [
            'type' => null,
            'isProxyObject' => false,
        ];

        // basic type case
        if ($normalizedType = (static function (string $type): ?string {
            if (\in_array($type, [
                'integer',
                'int'
            ])) {
                return ProxyObjectMetadata::TYPE_INTEGER;
            }

            if (\in_array($type, [
                'float',
                'double'
            ])) {
                return ProxyObjectMetadata::TYPE_FLOAT;
            }

            if (\in_array($type, [
                'boolean',
                'bool'
            ])) {
                return ProxyObjectMetadata::TYPE_BOOLEAN;
            }

            if ('string' === $type) {
                return ProxyObjectMetadata::TYPE_STRING;
            }

            if ('array' === $type) {
                return ProxyObjectMetadata::TYPE_ARRAY;
            }

            return null;
        })($type)
        ) {
            $return['type'] = $normalizedType;
            return $return;
        }

        // object case
        if (\class_exists($type) || \class_exists($type = $this->entityNamespace . '\\' . $type)) {
            $return['type'] = $type; // special flag for proxyobject
            // test proxy object
            if ((new ReflectionClass($type))->isSubclassOf(ProxyObject::class)) {
                $return['isProxyObject'] = true;
            }
            return $return;
        }

        throw new \RuntimeException(\sprintf('Unsupported property type : %s', $type));
    }
}