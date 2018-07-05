<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Type;

final class HydraType
{
    public const MEMBER = 'hydra:member';
    public const COLLECTION = 'hydra:Collection';
    public const TOTAL_ITEMS = 'hydra:totalItems';
    public const VIEW = 'hydra:view';
    public const SEARCH = 'hydra:search';
    public const FIRST_PAGE = 'hydra:first';
    public const LAST_PAGE = 'hydra:last';
    public const NEXT_PAGE = 'hydra:next';

    /** @var array */
    public static $hydraTypes = [
        self::MEMBER => 'hydra:member',
        self::COLLECTION => 'hydra:Collection',
        self::TOTAL_ITEMS => 'hydra:totalItems',
        self::VIEW => 'hydra:view',
        self::SEARCH => 'hydra:search',
    ];
}
