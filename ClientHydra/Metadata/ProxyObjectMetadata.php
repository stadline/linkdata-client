<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Metadata;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;

class ProxyObjectMetadata
{
    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_FLOAT = 'float';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY = 'array';
    public const TYPE_DATETIME = 'DateTime';

    private $class;
    private $properties = [];
    private $metadataCache;
    private $cacheConfig = [
        'enabled' => false,
        'public' => false,
        'ttl' => 3600
    ];

    public function __construct($class)
    {
        $this->class = $class;
        $this->resetMetadataCache();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getCacheConfig(): array
    {
        return $this->cacheConfig;
    }

    public function setCacheConfig(bool $enabled = false, int $ttl = 3600, bool $public = false):void
    {
        $this->cacheConfig = [
            'enabled' => $enabled,
            'public' => $public,
            'ttl' => $ttl
        ];
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getProperty(string $name): ?array
    {
        return $this->properties[$name];
    }

    public function setProperty(string $name, string $type, array $options = []): void
    {
        $this->properties[$name] = [
            'type' => $type,
        ];
        if (true === $options['isProxyObject']) {
            $this->properties[$name]['isProxyObject'] = true;
        }

        $this->resetMetadataCache();
    }

    public function getPropertiesNameByTypes(string $type): array
    {
        if (!isset($this->metadataCache['getPropertiesNameByTypes'][$type])) {
            $this->metadataCache['getPropertiesNameByTypes'][$type] = \array_keys(\array_filter($this->properties, function ($elt) use ($type) {
                return $elt['type'] === $type || (ProxyObject::class === $type && true === ($elt['isProxyObject'] ?? false));
            }));
        }

        return $this->metadataCache['getPropertiesNameByTypes'][$type];
    }

    public function testPropertyType(string $property, string $type): bool
    {
        if (!isset($this->metadataCache['testPropertyType'][$property.':'.$type])) {
            $this->metadataCache['testPropertyType'][$property.':'.$type] = \in_array($property, $this->getPropertiesNameByTypes($type), true);
        }

        return $this->metadataCache['testPropertyType'][$property.':'.$type];
    }

    private function resetMetadataCache(): void
    {
        $this->metadataCache = [
            'getPropertiesNameByTypes' => [],
            'testPropertyType' => [],
        ];
    }
}
