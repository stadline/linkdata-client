<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class Sport extends ProxyObject
{
    public const ALPINISME = 153;
    public const AQUAGYM = 260;
    public const ARTS_MARTIAUX = 45;
    public const AVIRON = 263;
    public const BADMINTON = 335;
    public const BASKETBALL = 10;
    public const BMX = 360;
    public const BODYBOARD = 264;
    public const BOXE = 35;
    public const CANOE_KAYAK = 265;
    public const COURSE_A_PIED = 121;
    public const DANSE = 79;
    public const ESCALADE = 161;
    public const FITNESS = 91;
    public const FOOTBALL = 13;
    public const GOLF = 320;
    public const HANDBALL = 18;
    public const HOCKEY = 20;
    public const HOCKEY_SUR_GLACE = 21;
    public const KITESURF = 273;
    public const MARCHE = 113;
    public const MUSCULATION_EN_SALLE = 98;
    public const NATATION = 274;
    public const PLANCHE_A_VOILE = 280;
    public const PLONGEE = 284;
    public const RAMEUR = 398;
    public const RANDONNEE = 168;
    public const RANDONNEE_EQUESTRE = 200;
    public const RAQUETTE_A_NEIGE = 173;
    public const ROLLER = 367;
    public const RUGBY = 27;
    public const SKATEBOARD = 374;
    public const SKI = 174;
    public const SKI_ALPIN = 176;
    public const SNOWBOARD = 185;
    public const SURF = 296;
    public const TAPIS_DE_COURSE = 395;
    public const TENNIS = 357;
    public const TRAIL = 126;
    public const TRIATHLON = 77;
    public const VELO_ELLIPTIQUE = 397;
    public const VELO_EN_SALLE = 110;
    public const VELO_SUR_ROUTE = 385;
    public const VOILE = 301;
    public const VOLLEYBALL = 32;
    public const VTT = 388;
    public const COURSE_D_ORIENTATION = 127;
    public const MARCHE_NORDIQUE = 114;
    public const RUN_AND_BIKE = 399;
    public const YOGA = 105;
    public const SKI_DE_RANDONNEE = 177;
    public const PARAPENTE = 7;
    public const TIR_A_L_ARC = 326;
    public const STAND_UP_PADDLE = 400;
    public const PADEL = 340;
    public const SQUASH = 354;
    public const TENNIS_DE_TABLE = 358;
    public const HOME_TRAINER = 401;
    public const SKI_DE_FOND_SKATING = 184;
    public const SKI_DE_FOND_ALTERNATIF = 183;
    public const CHAR_A_VOILE = 366;
    public const ACTIVITY_QUOTIDIENNE = 402;
    public const PILATES = 109;
    public const ELLIPTICAL_TRAINER = 397;
    public const DAILY_ACTIVITY = 402;
    public const COURSE_A_PIED_SUR_PISTE = 122;
    public const COURSE_A_PIED_SUR_ROUTE = 123;
    public const COURSE_A_PIED_EN_NATURE = 124;
    public const CROSS = 125;
    public const DIX_KM = 132;
    public const SEMI_MARATHON = 133;
    public const MARATHON = 134;
    public const CENT_KM = 135;
    public const TRAIL_COURT = 136;
    public const TRAIL_LONG = 137;
    public const ULTRA_TRAIL = 138;
    public const BMX_RACE = 361;
    public const BMX_STREET = 362;
    public const BMX_TRIAL = 363;
    public const PLAYBIKE = 364;
    public const VELO = 381;
    public const CYCLOCROSS = 382;
    public const CYCLOTOURISME = 383;
    public const VELO_SUR_PISTE = 384;
    public const VELO_URBAIN = 386;
    public const VELO_RANDONNEE = 387;
    public const VTT_CROSS_COUNTRY = 389;
    public const VTT_DESCENTE = 390;
    public const VTT_DIRT = 391;
    public const VTT_TRIAL = 392;
    public const VTT_ENDURO = 393;
    public const VTT_ALL_MOUNTAIN = 394;

    public static $iconNames = [
        self::ALPINISME => 'icon-alpinisme',
        self::AQUAGYM => 'icon-aquagym',
        self::ARTS_MARTIAUX => 'icon-arts-martiaux',
        self::AVIRON => 'icon-aviron',
        self::BADMINTON => 'icon-badminton',
        self::BASKETBALL => 'icon-basketball',
        self::BMX => 'icon-bmx',
        self::BODYBOARD => 'icon-bodyboard',
        self::BOXE => 'icon-boxe',
        self::CANOE_KAYAK => 'icon-canoe-kayak',
        self::COURSE_A_PIED => 'icon-course-a-pied',
        self::DANSE => 'icon-danse',
        self::ESCALADE => 'icon-escalade',
        self::FITNESS => 'icon-fitness',
        self::FOOTBALL => 'icon-football',
        self::GOLF => 'icon-golf',
        self::HANDBALL => 'icon-handball',
        self::HOCKEY => 'icon-hockey',
        self::KITESURF => 'icon-kitesurf',
        self::MARCHE => 'icon-marche-rapide',
        self::MUSCULATION_EN_SALLE => 'icon-musculation-en-salle',
        self::NATATION => 'icon-natation',
        self::PLANCHE_A_VOILE => 'icon-planche-a-voile',
        self::PLONGEE => 'icon-plongee',
        self::RAMEUR => 'icon-rameur',
        self::RANDONNEE => 'icon-randonnee',
        self::RANDONNEE_EQUESTRE => 'icon-randonne-equestre',
        self::RAQUETTE_A_NEIGE => 'icon-raquette-a-neige',
        self::ROLLER => 'icon-roller',
        self::RUGBY => 'icon-rugby',
        self::SKATEBOARD => 'icon-skateboard',
        self::SKI => 'icon-ski',
        self::SKI_ALPIN => 'icon-ski-alpin',
        self::SNOWBOARD => 'icon-snowboard',
        self::SURF => 'icon-surf',
        self::TAPIS_DE_COURSE => 'icon-tapis-de-course',
        self::TENNIS => 'icon-tennis',
        self::TRAIL => 'icon-trail',
        self::TRIATHLON => 'icon-triathlon',
        self::VELO_RANDONNEE => 'icon-velo-de-randonnee',
        self::VELO_ELLIPTIQUE => 'icon-velo-elliptique',
        self::VELO_EN_SALLE => 'icon-velo-en-salle',
        self::VELO_SUR_ROUTE => 'icon-velo-sur-route',
        self::VOILE => 'icon-voile',
        self::VOLLEYBALL => 'icon-volleyball',
        self::VTT => 'icon-vtt',
        self::MARCHE_NORDIQUE => 'icon-marchenordique',
        self::RUN_AND_BIKE => 'icon-runandbike',
        self::YOGA => 'icon-yoga',
        self::SKI_DE_RANDONNEE => 'icon-skidefond-skating',
        self::PARAPENTE => 'icon-parapente',
        self::TIR_A_L_ARC => 'icon-tiralarc',
        self::STAND_UP_PADDLE => 'icon-standuppaddle',
        self::PADEL => 'icon-paddletennis',
        self::SQUASH => 'icon-squash',
        self::TENNIS_DE_TABLE => 'icon-tennisdetable',
        self::HOME_TRAINER => 'icon-home-trainer',
        self::SKI_DE_FOND_ALTERNATIF => 'icon-skiderandonnee',
        self::SKI_DE_FOND_SKATING => 'icon-skidefond-alternatif',
        self::CHAR_A_VOILE => 'icon-charavoile',
        self::ACTIVITY_QUOTIDIENNE => 'icon-marche',
        self::PILATES => 'icon-pilates',
    ];

    protected static $slug_table = [
        self::ALPINISME => 'alpinisme',
        self::AQUAGYM => 'aquagym',
        self::ARTS_MARTIAUX => 'arts-martiaux',
        self::AVIRON => 'aviron',
        self::BADMINTON => 'badminton',
        self::BASKETBALL => 'basketball',
        self::BMX => 'bmx',
        self::BODYBOARD => 'bodyboard',
        self::BOXE => 'boxe',
        self::CANOE_KAYAK => 'canoe-kayak',
        self::COURSE_A_PIED => 'course-a-pied',
        self::DANSE => 'danse',
        self::ESCALADE => 'escalade',
        self::FITNESS => 'fitness',
        self::FOOTBALL => 'football',
        self::GOLF => 'golf',
        self::HANDBALL => 'handball',
        self::HOCKEY => 'hockey',
        self::KITESURF => 'kitesurf',
        self::MARCHE => 'marche-rapide',
        self::MUSCULATION_EN_SALLE => 'musculation-en-salle',
        self::NATATION => 'natation',
        self::PLANCHE_A_VOILE => 'planche-a-voile',
        self::PLONGEE => 'plongee',
        self::RAMEUR => 'rameur',
        self::RANDONNEE => 'randonnee',
        self::RANDONNEE_EQUESTRE => 'randonne-equestre',
        self::RAQUETTE_A_NEIGE => 'raquette-a-neige',
        self::ROLLER => 'roller',
        self::RUGBY => 'rugby',
        self::SKATEBOARD => 'skateboard',
        self::SKI => 'ski',
        self::SKI_ALPIN => 'ski-alpin',
        self::SNOWBOARD => 'snowboard',
        self::SURF => 'surf',
        self::TAPIS_DE_COURSE => 'tapis-de-course',
        self::TENNIS => 'tennis',
        self::TRAIL => 'trail',
        self::TRIATHLON => 'triathlon',
        self::VELO_RANDONNEE => 'velo-de-randonnee',
        self::VELO_ELLIPTIQUE => 'velo-elliptique',
        self::VELO_EN_SALLE => 'velo-en-salle',
        self::VELO_SUR_ROUTE => 'velo-sur-route',
        self::VOILE => 'voile',
        self::VOLLEYBALL => 'volleyball',
        self::VTT => 'vtt',
        self::MARCHE_NORDIQUE => 'marchenordique',
        self::RUN_AND_BIKE => 'runandbike',
        self::YOGA => 'yoga',
        self::SKI_DE_RANDONNEE => 'skidefond-skating',
        self::PARAPENTE => 'parapente',
        self::TIR_A_L_ARC => 'tiralarc',
        self::STAND_UP_PADDLE => 'standuppaddle',
        self::PADEL => 'paddletennis',
        self::SQUASH => 'squash',
        self::TENNIS_DE_TABLE => 'tennisdetable',
        self::HOME_TRAINER => 'home-trainer',
        self::SKI_DE_FOND_ALTERNATIF => 'skiderandonnee',
        self::SKI_DE_FOND_SKATING => 'skidefond-alternatif',
        self::CHAR_A_VOILE => 'charavoile',
        self::ACTIVITY_QUOTIDIENNE => 'marche',
        self::PILATES => 'pilates',
    ];

    /**
     * @var int
     *
     * @Groups({"sport_norm"})
     */
    private $id;

    /**
     * @var array
     *
     * @Groups({"sport_norm"})
     */
    private $translatedNames;

    /**
     * @var Universe
     *
     * @Groups({"sport_norm"})
     */
    private $universe;

    /**
     * @var bool
     *
     * @Groups({"sport_norm"})
     */
    private $active = true;

    /**
     * @var string
     *
     * @Groups({"sport_norm"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @Groups({"sport_norm"})
     */
    private $updatedAt;

    /**
     * @var array
     *
     * @Groups({"sport_norm"})
     */
    private $userEquipments;

    private $iri;

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTranslatedNames(): ?array
    {
        return $this->translatedNames;
    }

    public function setTranslatedNames(?array $translatedNames): void
    {
        $this->translatedNames = $translatedNames;
    }

    public function getUniverse()
    {
        if (null !== $this->universe) {
            $this->universe->_hydrate();
        }

        return $this->universe;
    }

    public function setUniverse(?Universe $universe): void
    {
        $this->universe = $universe;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function hasNameByLocale(string $locale): ?bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }

    public static function getIcon($id): string
    {
        if (isset(self::$slug_table[$id])) {
            return self::$slug_table[$id];
        }

        return '';
    }

    public function getUserEquipments(): array
    {
        return $this->userEquipments;
    }

    public function setUserEquipments($userEquipments): void
    {
        $this->userEquipments = $userEquipments;
    }

    public function getIri(): string
    {
        return sprintf('/v2/sports/%s', $this->id);
    }
}
