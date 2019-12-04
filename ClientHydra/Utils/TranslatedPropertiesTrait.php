<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\ClientHydra\Utils;

trait TranslatedPropertiesTrait
{
    private static $FALLBACK_LOCALE = 'en';

    protected function getTranslatedPropertyByLocale(string $property, string $locale): ?string
    {
        // asked locale
        if (isset($this->{'get'.\ucfirst($property)}()[$locale]) && !empty($this->{'get'.\ucfirst($property)}()[$locale])) {
            return $this->{'get'.\ucfirst($property)}()[$locale];
        }

        // fallback to en
        if (isset($this->{'get'.\ucfirst($property)}()[self::$FALLBACK_LOCALE]) && !empty($this->{'get'.\ucfirst($property)}()[self::$FALLBACK_LOCALE])) {
            return $this->{'get'.\ucfirst($property)}()[self::$FALLBACK_LOCALE];
        }

        // unknown
        return null;
    }
}
