<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\ClientHydra\Type;

final class MethodType
{
    public const POST = 'post';
    public const PUT = 'put';
    public const GET = 'get';
    public const DELETE = 'delete';

    /** @var array */
    private static $methods = [
        self::POST => 'post',
        self::PUT => 'put',
        self::GET => 'get',
        self::DELETE => 'delete',
    ];
}
