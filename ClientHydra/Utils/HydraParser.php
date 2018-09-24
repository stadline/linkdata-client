<?php

namespace Stadline\LinkdataClient\ClientHydra\Utils;

use Doctrine\Common\Inflector\Inflector;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Type\NormContextType;

class HydraParser
{
    public static function isHydraResponse(array $content): bool
    {
        return null !== self::getType($content);
    }

    public static function isHydraObjectResponse(array $content): bool
    {
        return self::isHydraResponse($content) && !self::isCollection($content);
    }

    public static function isHydraCollectionResponse(array $content): bool
    {
        return self::isHydraResponse($content) && self::isCollection($content);
    }

    public static function getEntityName(array $content): ?string
    {
        if (!isset($content['@context'])) {
            return null;
        }

        return \explode('/', $content['@context'])[3] ?? null;
    }

    public static function isCollection(array $content): bool
    {
        return \in_array(self::getType($content), ['Hydra:Collection', 'Hydra:PartialCollection']);
    }

    public static function getType(array $content): ?string
    {
        return $content['@type'] ?? null;
    }

    /**
     * @param ProxyObject $object
     * @return string
     */
    public static function getNormContext(ProxyObject $object): string
    {
        $e = \explode('\\', \get_class($object));
        return \sprintf('%s_%s', Inflector::tableize(\end($e)), NormContextType::NORM);
    }

    public static function getDenormContext(array $content): string
    {
        return \sprintf('%s_%s', \strtolower(self::getType($content)), NormContextType::DENORN);
    }
}