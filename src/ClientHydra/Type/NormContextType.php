<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\ClientHydra\Type;

final class NormContextType
{
    public const NORM = 'norm';
    public const DENORN = 'denorm';

    /** @var array */
    private static $normContext = [
        self::NORM => 'norm',
        self::DENORN => 'denorm',
    ];
}
