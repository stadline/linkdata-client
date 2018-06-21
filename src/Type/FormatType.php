<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Type;

final class FormatType
{
    public const JSON = 'json';
    public const JSONLD = 'json-ld';

    /** @var array */
    private static $formats = [
        self::JSON => 'json',
        self::JSONLD => 'jsonld',
    ];
}
