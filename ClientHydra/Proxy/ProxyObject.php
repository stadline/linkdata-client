<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

use Stadline\LinkdataClient\ClientHydra\Metadata\MetadataManager;
use Stadline\LinkdataClient\ClientHydra\Metadata\ProxyObjectMetadata;

/**
 * @method void            setId(null|int|string $id)
 * @method null|int|string getId()
 */
abstract class ProxyObject
{
    public static function _init(
        \Closure $refreshClosure,
        \Closure $getDataClosure,
        \Closure $getObjectClosure,
        MetadataManager $metadataManager
    ): void {
        self::$_getData = $getDataClosure;
        self::$_doRefresh = $refreshClosure;
        self::$_getObject = $getObjectClosure;
        self::$_metadataManager = $metadataManager;
    }

    /** @var \Closure */
    private static $_doRefresh;
    /** @var \Closure */
    private static $_getData;
    /** @var \Closure */
    private static $_getObject;
    /** @var MetadataManager */
    private static $_metadataManager;

    /* internal metadata */
    private $_hydratedProperties = [];
    private $_currentDistantValues = [];

    public function _refresh(array $data): void
    {
        (self::$_doRefresh)($this, $data);
        foreach ($data as $k => $v) {
            $this->_hydratedProperties[$k] = true;
            $this->_currentDistantValues[$k] = $v;
        }
    }

    public function _getEditedProperties(): array {
        $editedProperties = [];

        foreach ($this->_getMetadata()->getProperties() as $name => $property) {
            // Check property value change
            if ($this->_currentDistantValues[$name] !== $this->$name) {
                $editedProperties[] = $name;
            }
        }

        return $editedProperties;
    }

    public function __call($name, $arguments)
    {
        if (1 !== \preg_match('/^(?<method>set|get|is)(?<propertyName>[A-Za-z0-1]+)$/', $name, $matches)) {
            throw new \RuntimeException(\sprintf('No method %s for object %s', $name, \get_class($this)));
        }

        // Check propertyExists
        $propertyName = \lcfirst($matches['propertyName']);
        if (!(new \ReflectionClass($this))->hasProperty($propertyName)) {
            throw new \RuntimeException(\sprintf('%s::%s() error : property "%s" does not exists', \get_class($this), $name, $propertyName));
        }

        if ('set' === $matches['method']) {
            if (1 !== \count($arguments)) {
                throw new \RuntimeException(\sprintf('%s::%s() require one and only one parameter', \get_class($this), $name));
            }
            $this->_set($propertyName, $arguments[0]);
        } elseif (\in_array($matches['method'], ['is', 'get'], true)) {
            if (0 !== \count($arguments)) {
                throw new \RuntimeException(\sprintf('%s::%s() require no parameter', \get_class($this), $name));
            }

            return $this->_get($propertyName);
        } else {
            throw new \RuntimeException('What ??? Not possible !');
        }
    }

    protected function isHydrated(): bool
    {
        return \count($this->_getMetadata()->getProperties()) === \count($this->_hydratedProperties);
    }

    /**
     * Hydrate an object with an IRI given.
     * If hydrate is set to false, it returns the IRI given.
     */
    public function _hydrate(?array $data = null): void
    {
        // already hydrated : ignore
        if ($this->isHydrated() || null === $this->getId()) {
            return;
        }

        // if data is empty = get data from api
        if (null === $data) {
            $data = (self::$_getData)($this);
        }

        $this->_refresh($data);
    }

    protected function _getMetadata(): ProxyObjectMetadata
    {
        return self::$_metadataManager->getClassMetadata(\get_class($this));
    }

    protected function _set($property, $value): void
    {
        $this->_hydratedProperties[$property] = true;

        $this->{$property} = (function () use ($property, $value) {
            if (null === $value) {
                return null;
            }

            $prop = $this->_getMetadata()->getProperty($property);
            // Basic types
            switch ($prop['type']) {
                case ProxyObjectMetadata::TYPE_INTEGER:
                    return (int) $value;
                case ProxyObjectMetadata::TYPE_BOOLEAN:
                    return (bool) $value;
                case ProxyObjectMetadata::TYPE_FLOAT:
                    return (float) $value;
                case ProxyObjectMetadata::TYPE_STRING:
                    return (string) $value;
                case ProxyObjectMetadata::TYPE_DATETIME:
                    return $value instanceof \DateTime ? $value : new \DateTime($value);
            }

            // ProxyObject
            if (!$value instanceof self && ($prop['isProxyObject'] ?? false)) {
                return (self::$_getObject)($prop['type'], $value, false);
            }

            return $value;
        })();
    }

    protected function _get($property)
    {
        // Id special case
        if ('id' === $property) {
            return $this->{$property};
        }

        // Object not hydrated : autohydrate
        if (true !== ($this->_hydratedProperties[$property] ?? null)) {
            $this->_hydrate();
        }

        // Return property
        return $this->{$property};
    }
}
