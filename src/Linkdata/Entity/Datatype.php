<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class Datatype extends ProxyObject
{
    const ON = 99;
    const ON_MANUAL = 97;
    const ACTIVITY = 98;
    const HRCUR = 1;
    const HRMAX = 3;
    const HRAVG = 4;
    const SPEEDCUR = 6;
    const SPEEDMAX = 7;
    const SPEEDAVG = 9;
    const ELEVATIONCUR = 14;
    const LAP = 20;
    const WEIGHT_KILOGRAMS = 22;
    const CALBURNT = 23;
    const DURATION = 24;
    const HEIGHT = 27;
    const HRREST = 28;
    const STEPS = 29;
    const DISTANCE = 5;
    const ASCENT = 18;
    const DESCENT = 19;
    const ELEVATION_MAX = 15;
    const ELEVATION_MIN = 16;
    const CADENCECUR = 10;
    const CADENCEMAX = 11;
    const CADENCEMIN = 12;
    const CADENCEAVG = 13;
    const TIME_IN_ZONE = 42;
    const EXERCISE_TYPE = 43;
    const TOTAL_STROKE = 44;
    const TOTAL_SERVES = 45;
    const TOTAL_FOREHANDS = 46;
    const TOTAL_BACKHANDS = 47;
    const STROKE_TYPE = 48;
    const STROKE_ZONE_1 = 49;
    const STROKE_ZONE_2 = 50;
    const STROKE_ZONE_3 = 51;
    const STROKE_ZONE = 52;
    const DECISIVE_STROKE = 53;
    const CENTERED_FOREHANDS = 59;
    const CENTERED_BACKHANDS = 60;
    const CENTERED_SERVES = 61;
    const BALL_SPEED_CURRENT = 54;
    const BALL_SPEED_MAX = 56;
    const BALL_SPEED_AVG = 57;
    const WINNING_FOREHANDS = 62;
    const WINNING_BACKHANDS = 64;
    const LOOSING_FOREHANDS = 63;
    const LOOSING_BACKHANDS = 65;
    const WINNING_FIRST_SERVES = 66;
    const LOOSING_FIRST_SERVES = 69;
    const WINNING_SECOND_SERVES = 67;
    const LOOSING_SECOND_SERVES = 68;
    const TOTAL_WINNING_POINTS = 70;
    const TOTAL_LOOSING_POINTS = 71;
    const MAX_CONSECUTIVE_WINNING_POINTS = 72;
    const TOTAL_FIRST_SERVES = 73;
    const TOTAL_SECOND_SERVES = 74;
    const TOTAL_CENTERED_FIRST_SERVES = 75;
    const TOTAL_CENTERED_SECOND_SERVES = 76;
    const FIRST_SERVE_BALL_SPEED_MAX = 77;
    const SECOND_SERVE_BALL_SPEED_MAX = 78;
    const FIRST_SERVE_BALL_SPEED_AVG = 79;
    const SECOND_SERVE_BALL_SPEED_AVG = 80;
    const WIN_ON_FIRST_SERVE = 81;
    const WIN_ON_SECOND_SERVE = 82;
    const SUCCESSFUL_FIRST_SERVE_SPEED_MAX = 83;
    const SUCCESSFUL_FIRST_SERVE_SPEED_AVG = 84;
    const TOTAL_SUCCESSFULL_FIRST_SERVE = 85;
    const TOTAL_SUCCESSFULL_CENTERED_FIRST_SERVE = 86;
    const MATCH_TIME = 87;
    const TRAINING_TIME = 88;
    const TOTAL_GAMES = 89;
    const TOTAL_BREAK_POINTS = 90;
    const TOTAL_BREAK_POINTS_WON = 91;
    const TOTAL_VICTORY = 92;
    const TOTAL_DEFEAT = 93;
    const TOTAL_MATCH = 95;
    const TOTAL_TRAINING = 96;
    const TOTAL_MATCH_FOREHANDS = 104;
    const TOTAL_MATCH_BACKHANDS = 105;
    const TOTAL_TRAINING_FOREHANDS = 106;
    const TOTAL_TRAINING_BACKHANDS = 107;
    const TOTAL_TRAINING_SERVES = 108;
    const TOTAL_MATCH_CENTERED_FOREHANDS = 109;
    const TOTAL_MATCH_CENTERED_BACKHANDS = 110;
    const TOTAL_TRAINING_CENTERED_FOREHANDS = 111;
    const TOTAL_TRAINING_CENTERED_BACKHANDS = 112;
    const TOTAL_TRAINING_CENTERED_SERVES = 113;
    const TOTAL_TROPHIES = 114;
    const TRAINING_SERVE_BALL_SPEED_AVG = 115;
    const TRAINING_SERVE_BALL_SPEED_MAX = 116;
    const MAX_STROKES_DURING_A_POINT = 117;
    const MAX_CONSECUTIVE_WINNING_SERVES = 118;
    const WALKING_TIME = 37;
    const ACTIVE_TIME = 30;
    const RUNNING_TIME = 38;
    const WALKING_DURATION = 119;
    const INTENSITY_AVG = 127;
    const TOTAL_SERVES_WITHOUT_EFFECT = 128;
    const TOTAL_SERVES_WITH_EFFECT = 129;
    const TOTAL_FOREHANDS_TOPSPIN = 130;
    const TOTAL_FOREHANDS_SLICE = 131;
    const TOTAL_FOREHANDS_FLAT = 132;
    const TOTAL_BACKHANDS_TOPSPIN = 133;
    const TOTAL_BACKHANDS_SLICE = 134;
    const TOTAL_BACKHANDS_FLAT = 135;
    const STROKE_EFFECT = 136;
    const TOTAL_FIRST_SERVES_WITHOUT_EFFECT = 137;
    const TOTAL_FIRST_SERVES_WITH_EFFECT = 138;
    const TOTAL_SECOND_SERVES_WITHOUT_EFFECT = 139;
    const TOTAL_SECOND_SERVES_WITH_EFFECT = 140;
    const INTENSITY_AVG_FOREHANDS_TOPSPIN = 141;
    const INTENSITY_AVG_FOREHANDS_SLICE = 142;
    const INTENSITY_AVG_FOREHANDS_FLAT = 143;
    const INTENSITY_AVG_BACKHANDS_TOPSPIN = 144;
    const INTENSITY_AVG_BACKHANDS_SLICE = 145;
    const INTENSITY_AVG_BACKHANDS_FLAT = 146;
    const TOTAL_TRAINING_SERVES_WITHOUT_EFFECT = 147;
    const TOTAL_TRAINING_SERVES_WITH_EFFECT = 148;
    const TOTAL_TRAINING_FOREHANDS_TOPSPIN = 149;
    const TOTAL_TRAINING_FOREHANDS_SLICE = 150;
    const TOTAL_TRAINING_FOREHANDS_FLAT = 151;
    const TOTAL_TRAINING_BACKHANDS_TOPSPIN = 152;
    const TOTAL_TRAINING_BACKHANDS_SLICE = 153;
    const TOTAL_TRAINING_BACKHANDS_FLAT = 154;
    const TOTAL_MATCH_FOREHANDS_TOPSPIN = 155;
    const TOTAL_MATCH_FOREHANDS_SLICE = 156;
    const TOTAL_MATCH_FOREHANDS_FLAT = 157;
    const TOTAL_MATCH_BACKHANDS_TOPSPIN = 158;
    const TOTAL_MATCH_BACKHANDS_SLICE = 159;
    const TOTAL_MATCH_BACKHANDS_FLAT = 160;
    const TRAINING_INTENSITY_AVG_FOREHANDS_TOPSPIN = 161;
    const TRAINING_INTENSITY_AVG_FOREHANDS_SLICE = 162;
    const TRAINING_INTENSITY_AVG_FOREHANDS_FLAT = 163;
    const TRAINING_INTENSITY_AVG_BACKHANDS_TOPSPIN = 164;
    const TRAINING_INTENSITY_AVG_BACKHANDS_SLICE = 165;
    const TRAINING_INTENSITY_AVG_BACKHANDS_FLAT = 166;
    const MATCH_INTENSITY_AVG_FOREHANDS_TOPSPIN = 167;
    const MATCH_INTENSITY_AVG_FOREHANDS_SLICE = 168;
    const MATCH_INTENSITY_AVG_FOREHANDS_FLAT = 169;
    const MATCH_INTENSITY_AVG_BACKHANDS_TOPSPIN = 170;
    const MATCH_INTENSITY_AVG_BACKHANDS_SLICE = 171;
    const MATCH_INTENSITY_AVG_BACKHANDS_FLAT = 172;
    const INTENSITY_MAX_FOREHANDS = 173;
    const INTENSITY_MAX_BACKHANDS = 174;
    const VMA_PERCENTAGE = 175;
    const PERCENTAGE_MAX_HR_CURRENT = 176;
    const RESISTANCE = 177;
    const POWER_CURRENT = 178;
    const POWER_MAX = 179;
    const POWER_AVG = 180;
    const WEIGHT = 181;
    const FAT_PERCENTAGE = 182;
    const MUSCLE_PERCENTAGE = 184;
    const BONE_PERCENTAGE = 185;
    const WATER_PERCENTAGE = 186;
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
    const LOCATION = 10000;

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
}
