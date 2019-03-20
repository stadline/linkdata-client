<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string getId()
 * @method void   setId(string $id)
 * @method string getOneId()
 * @method void   setOneId(string $oneId)
 * @method int    getGender()
 * @method void   setGender(int $gender)
 * @method array  getRoles()
 * @method void   setRoles(array $roles)
 * @method string getLanguage()
 * @method void   setLanguage(string $language)
 * @method string getCountry()
 * @method void   setCountry(string $country)
 * @method string getImageUrl()
 * @method void   setImageUrl(string $imageUrl)
 * @method string getBirthDate()
 * @method void   setBirthDate(string $birthDate)
 * @method string getScheduleDelete()
 * @method void   setScheduleDelete(string $scheduleDelete)
 * @method string getCreatedAt()
 * @method void   setCreatedAt(string $createdAt)
 * @method string getUpdatedAt()
 * @method void   setUpdatedAt(string $updatedAt)
 */
class User extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    public $id;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    public $oneId;

    /**
     * @var int
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    public $gender;

    /**
     * @var array
     *
     * @Groups({"user_norm"})
     */
    public $roles;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    public $language;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    public $country;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    public $imageUrl;

    /**
     * @var string
     *
     * @Groups({"user_denorm"})
     */
    public $birthDate;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    public $createdAt;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    public $updatedAt;

//    /**
//     * @var ArrayCollection
//     */
//    public $userMeasures;
//
//    /**
//     * @var ArrayCollection
//     */
//    public $userMeasureGoals;
//
//    /**
//     * @var ArrayCollection
//     */
//    public $userStorages;
//
//    /**
//     * @var ArrayCollection
//     */
//    public $activities;
//
//    public $userRecords;
//
//    /**
//     * @var ArrayCollection
//     */
//    public $userRoutes;
//
//    /**
//     * @var ArrayCollection
//     */
//    public $userAgreements;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    public $scheduleDelete;
}
