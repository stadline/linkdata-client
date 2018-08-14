<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Geonaute\LinkdataBundle\Utils\RelatedValue;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class Datatype extends ProxyObject
{
    // commonly used datatype
    const HR_CURRENT = 1;
    const HR_MIN = 2;
    const HR_MAX = 3;
    const HR_AVG = 4;
    const DISTANCE = 5;
    const SPEED_CURRENT = 6;
    const SPEED_MAX = 7;
    const SPEED_MIN = 8;
    const SPEED_AVG = 9;
    const CADENCE_CURRENT = 10;
    const ELEVATION_CURRENT = 14;
    const ELEVATION_MAX = 15;
    const ELEVATION_MIN = 16;
    const ASCENT = 18;
    const DESCENT = 19;
    const LAP = 20;
    const BREAK_TIME = 21;
    const WEIGHT_KILOGRAMS = 22;
    const CALORIES_BURNT = 23;
    const DURATION = 24;
    const HR_PERCENTAGE_MIN = 25;
    const HR_PERCENTAGE_MAX = 26;
    const HEIGHT = 27;
    const HR_REST = 28;
    const STEP_NUMBER = 29;
    const ACTIVE_TIME = 30;
    const WALKING_TIME = 37;
    const RUNNING_TIME = 38;
    const MUSIC_TRACK = 39;
    const MODE = 36;
    const FAT_BURN = 41;
    const MANUAL_POINTS = 97;
    const ACTIVITY_NUMBER = 98;
    const POINTS_EARNED = 99;
    const RPM_CURRENT = 100;
    const RPM_AVG = 103;
    const BIKE_TRAINER_RESISTANCE = 177;
    const CURRENT_HOME_TRAINER_POWER = 178;
    const MAXIMUM_HOME_TRAINER_POWER = 179;
    const AVERAGE_HOME_TRAINER_POWER = 180;
    const WEIGHT = 181;
    const BODY_FAT_PERCENTAGE = 182;
    const BODY_MUSCLE_PERCENTAGE = 184;
    const BODY_BONE_PERCENTAGE = 185;
    const BODY_WATER_PERCENTAGE = 186;
    const PMA_PERCENTAGE = 183;
    const EXERCISE_FLAG = 187;
    const EXERCISE_PHASE_FLAG = 188;
    const BORG_SCALE_SLOTS = 189;
    const BALANCE_INDICATOR = 190;
    const FLEXIBILITY_INDICATOR = 191;
    const PUMPS_INDICATOR = 192;
    const SQUATS_INDICATOR = 193;
    const LINING_INDICATOR = 194;
    const CARDIO_INDICATOR = 195;
    // Daily activity
    const SLEEPING_TIME = 196;
    const LIGHT_SLEEPING_TIME = 197;
    const DEEP_SLEEPING_TIME = 198;
    const BED_TIME = 199;
    const WAKEUP_TIME = 200;
    const VMA = 201;
    const PMA = 202;
    const SCORE_FIT_TEST = 203;
    const MAX_SLOPE_DEVICE = 204;
    const AVG_SLOPE_DEVICE = 205;
    const MAX_BIKE_TRAINER_RESISTANCE = 206;
    const AVG_BIKE_TRAINER_RESISTANCE = 207;
    const STRIDE_LENGTH = 208;
    const STEPS_OBJECTIVE = 209;
    const SLEEP_OBJECTIVE = 210;

    // special cases : datatypes that doesn't exist
    const ELAPSED_TIME = 10000;
    const SPEED_RATE_CURRENT = 10001;
    const VERTICAL_SPEED_CURRENT = 10002;
    const ASCENT_SPEED_AVG = 10003;
    const DESCENT_SPEED_AVG = 10004;
    const TIME_OF_DAY = 10005;
    const LOCATION = 10006;
    const MONTH_FIRST_LETTER = 10007;
    const MONTH = 10008;
    const SPEED_RATE_AVG = 10009;
    const SPEED_RATE_MAX = 10010;
    const HR_LITERAL_ZONE = 10011;
    const ELEVATION_PERCENTAGE = 10012;
    const ELEVATION_PERCENTAGE_ASCENT = 10013;
    const ELEVATION_PERCENTAGE_DESCENT = 10014;

    public static $iconNames = [
        self::HR_CURRENT => 'icon-geonaute-heart',
        self::HR_MIN => 'icon-geonaute-heart',
        self::HR_MAX => 'icon-geonaute-heart',
        self::HR_AVG => 'icon-geonaute-heart',
        self::DISTANCE => 'icon-geonaute-road',
        self::SPEED_CURRENT => 'icon-geonaute-perform',
        self::SPEED_AVG => 'icon-geonaute-perform',
        self::CADENCE_CURRENT => 'icon-geonaute-step',
        self::ELEVATION_CURRENT => 'icon-geonaute-mountain',
        self::ELEVATION_MAX => 'icon-geonaute-mountain',
        self::ELEVATION_MIN => 'icon-geonaute-mountain',
        self::ASCENT => 'icon-geonaute-ascent',
        self::DESCENT => 'icon-geonaute-descent',
        self::LAP => 'icon-geonaute-time',
        self::BREAK_TIME => 'icon-geonaute-time',
        self::WEIGHT_KILOGRAMS => 'icon-geonaute-cal',
        self::CALORIES_BURNT => 'icon-geonaute-cal',
        self::DURATION => 'icon-geonaute-time',
        self::ELAPSED_TIME => 'icon-geonaute-time',
        self::HR_PERCENTAGE_MIN => 'icon-geonaute-percent',
        self::HR_PERCENTAGE_MAX => 'icon-geonaute-percent',
        self::HEIGHT => 'icon-geonaute-cal',
        self::HR_REST => 'icon-geonaute-heart',
        self::STEP_NUMBER => 'icon-geonaute-step',
        self::ACTIVE_TIME => 'icon-geonaute-walk-fast',
        self::WALKING_TIME => 'icon-geonaute-time',
        self::RUNNING_TIME => 'icon-geonaute-time',
        self::FAT_BURN => 'icon-geonaute-cal',
        self::MANUAL_POINTS => 'icon-geonaute-on',
        self::POINTS_EARNED => 'icon-geonaute-on',
        self::RPM_CURRENT => 'icon-geonaute-rpm',
        self::RPM_AVG => 'icon-geonaute-rpm',
        self::ACTIVITY_NUMBER => 'icon-geonaute-hightchart',
        self::SPEED_RATE_CURRENT => 'icon-geonaute-perform',
        self::ELEVATION_PERCENTAGE => 'icon-geonaute-next',
        self::ELEVATION_PERCENTAGE_ASCENT => 'icon-geonaute-ascent-arrow',
        self::ELEVATION_PERCENTAGE_DESCENT => 'icon-geonaute-descent-arrow',
        self::WEIGHT_KILOGRAMS => 'icon-geonaute-weight',
        self::WEIGHT => 'icon-geonaute-weight',
        self::BODY_FAT_PERCENTAGE => 'icon-geonaute-weight',
        self::CURRENT_HOME_TRAINER_POWER => 'icon-geonaute-power',
    ];

    public static $userHrMax = 220;
    public static $userHrRest = 120;

    /**
     * @var int
     * @Groups({"datatype_norm"})
     */
    private $id;

    /**
     * @var string
     * @Groups({"datatype_norm"})
     */
    private $unit;

    /**
     * @var array
     *
     * @Groups({"datatype_norm"})
     */
    private $translatedNames;

    /**
     * @var array
     *
     * @Groups({"datatype_norm"})
     */
    private $translatedDescriptions;

    /**
     * @var int
     * @Groups({"datatype_norm"})
     */
    private $recordWay;

    /**
     * @var bool
     * @Groups({"datatype_norm"})
     */
    private $cumulable;

    /**
     * @var bool
     * @Groups({"datatype_norm"})
     */
    private $active = true;

    /**
     * @var string
     * @Groups({"datatype_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"datatype_norm"})
     */
    private $updatedAt;

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): void
    {
        $this->unit = $unit;
    }

    public function getTranslatedNames(): array
    {
        return $this->translatedNames;
    }

    public function setTranslatedNames(array $translatedNames): void
    {
        $this->translatedNames = $translatedNames;
    }

    public function getTranslatedDescriptions(): ?array
    {
        return $this->translatedDescriptions;
    }

    public function setTranslatedDescriptions(?array $translatedDescriptions): void
    {
        $this->translatedDescriptions = $translatedDescriptions;
    }

    public function getRecordWay(): int
    {
        return $this->recordWay;
    }

    public function setRecordWay(int $recordWay): void
    {
        $this->recordWay = $recordWay;
    }

    public function isCumulable(): bool
    {
        return $this->cumulable;
    }

    public function setCumulable(bool $cumulable): void
    {
        $this->cumulable = $cumulable;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function hasNameByLocale(string $locale): bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }

    public function hasDescriptionByLocale(string $locale): bool
    {
        return isset($this->translatedDescriptions[$locale]) && !empty($this->translatedDescriptions[$locale]);
    }

    public function getDescriptionByLocale(string $locale): ?string
    {
        return $this->hasDescriptionByLocale($locale) ? $this->translatedDescriptions[$locale] : null;
    }

    /**
     * Return icon for datatype.
     *
     * @return string
     */
    public static function getIcon($unitId)
    {
        if (\array_key_exists($unitId, self::$iconNames)) {
            return self::$iconNames[$unitId];
        }

        return '';
    }

    /**
     * Returns related datatype value.
     */
    public static function getRelatedValue($value, $unitId)
    {
        switch ($unitId) {
            case self::SPEED_AVG:
            case self::SPEED_CURRENT:
            case self::SPEED_MIN:
            case self::SPEED_MAX:
                return self::computeSpeedRate($value);
            case self::HR_AVG:
            case self::HR_CURRENT:
            case self::HR_MIN:
            case self::HR_MAX:
                return self::computeHrPercentageMax($value);
            default:
                return null;
        }
    }

    public static function computeSpeedRate($rawValue)
    {
        $speedValue = (float) (string) $rawValue;
        if ($speedValue > 0) {
            return new RelatedValue(1 / $speedValue, self::SPEED_RATE_CURRENT);
        }
    }

    public static function computeHrPercentageMax($rawValue)
    {
        $hrValue = (float) (string) $rawValue;
        $userHrMax = static::$userHrMax;
        $userHrRest = static::$userHrRest;
        // handle 0 case
        if ($userHrMax === $userHrRest) {
            return new RelatedValue(0, self::HR_PERCENTAGE_MAX);
        }

        return new RelatedValue((($hrValue - $userHrRest) / ($userHrMax - $userHrRest)) * 100, self::HR_PERCENTAGE_MAX);
    }
}
