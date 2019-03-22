<?php

namespace Stadline\LinkdataClient\ClientHydra\Metadata;

class ProxyObjectMetadata
{
    private $class;
    private $properties = [];
    private $cache = [
        'getPropertiesNameByTypes' => [],
        'testPropertyType' => [],
    ];

    public function __construct($class)
    {
        $this->class = $class;
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

    public function setProperty(string $name, string $type, ?string $class): void
    {
        $this->properties[$name] = [
            'type' => $type,
            'class' => $class
        ];
    }

    public function getPropertiesNameByTypes(string $type): array
    {
        if (!isset($this->cache['getPropertiesNameByTypes'][$type])) {
            $this->cache['getPropertiesNameByTypes'][$type] = array_keys(array_filter($this->properties, function ($elt) use ($type) {
                return ($elt['type'] === $type);
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
}