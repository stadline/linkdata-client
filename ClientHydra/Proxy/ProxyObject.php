<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Proxy;

/**
 * @method void            setId(null|int|string $id)
 * @method null|int|string getId()
 */
abstract class ProxyObject
{
    /** @var \Closure */
    private $_doRefresh;
    /** @var \Closure */
    private $_getData;

    /* internal metadata */
    private $_hydrated = false;
    private $_hydratedProperties = [];

    public function _refresh(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->_hydratedProperties[$k] = true;
        }
        ($this->_doRefresh)($this, $data);
    }

    public function _init(
        \Closure $refreshClosure,
        \Closure $getDataClosure
    ): void
    {
        $this->_getData = $getDataClosure;
        $this->_doRefresh = $refreshClosure;
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

    /**
     * Hydrate an object with an IRI given.
     * If hydrate is set to false, it returns the IRI given.
     */
    protected function _hydrate(?array $data = null): void
    {
        // already hydrated : ignore
        if (true === $this->_hydrated || null === $this->getId()) {
            return;
        }

        // if data is empty = get data from api
        if (null === $data) {
            $data = ($this->_getData)($this);
        }

        $this->_refresh($data);

        $this->_hydrated = true;
    }

    protected function _set($property, $value): void
    {
        $this->_hydratedProperties[$property] = true;
        $this->{$property} = $value;
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
