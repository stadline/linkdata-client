<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Utils;

/**
 * @deprecated
 *
 * @todo : remove this class
 */
class RelatedValue
{
    private $value;

    private $id;

    public function __construct($value, $datatypeId = null)
    {
        $this->value = $value;
        $this->id = $datatypeId;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function getId()
    {
        return $this->id;
    }
}
