<?php

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
    private $cache;

    public function __construct($class)
    {
        $this->class = $class;
        $this->resetCache();
    }

    public function getClass()
    {
        return $this->class;
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

        $this->resetCache();
    }

    public function getPropertiesNameByTypes(string $type): array
    {
        if (!isset($this->cache['getPropertiesNameByTypes'][$type])) {
            $this->cache['getPropertiesNameByTypes'][$type] = array_keys(array_filter($this->properties, function ($elt) use ($type) {
                return ($elt['type'] === $type || ($type === ProxyObject::class && true === ($elt['isProxyObject'] ?? false)));
            }));
        }
        return $this->cache['getPropertiesNameByTypes'][$type];
    }

    public function testPropertyType(string $property, string $type): bool
    {
        if (!isset($this->cache['testPropertyType'][$property . ':' . $type])) {
            $this->cache['testPropertyType'][$property . ':' . $type] = in_array($property, $this->getPropertiesNameByTypes($type), true);
        }
        return $this->cache['testPropertyType'][$property . ':' . $type];
    }

    private function resetCache(): void
    {
        $this->cache = [
            'getPropertiesNameByTypes' => [],
            'testPropertyType' => [],
        ];
    }
}