<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string     getId()
 * @method void       setId(string $id)
 * @method ?string    getOneId()
 * @method void       setOneId(?string $oneId)
 * @method int        getGender()
 * @method void       setGender(int $gender)
 * @method array      getRoles()
 * @method void       setRoles(array $roles)
 * @method ?string    getLanguage()
 * @method void       setLanguage(?string $language)
 * @method ?string    getCountry()
 * @method void       setCountry(?string $country)
 * @method ?string    getImageUrl()
 * @method void       setImageUrl(?string $imageUrl)
 * @method \DateTime  getBirthDate()
 * @method void       setBirthDate(\DateTime $birthDate)
 * @method ?\DateTime getScheduleDelete()
 * @method void       setScheduleDelete(?\DateTime $scheduleDelete)
 * @method ?array     getUserMeasures()
 * @method ?array     getUserMeasureGoals()
 * @method ?array     getUserStorages()
 * @method ?array     getActivities()
 * @method ?array     getUserAgreements()
 * @method \DateTime  getCreatedAt()
 * @method void       setCreatedAt(\DateTime $createdAt)
 * @method \DateTime  getUpdatedAt()
 * @method void       setUpdatedAt(\DateTime $updatedAt)
 */
class User extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_norm"})
     */
    public $id;

    /**
     * @var ?string
     * @Groups({"user_norm"})
     */
    public $oneId;

    /**
     * @var int
     * @Groups({"user_norm", "user_denorm"})
     */
    public $gender;

    /**
     * @var array
     * @Groups({"user_norm"})
     */
    public $roles;

    /**
     * @var ?string
     * @Groups({"user_norm", "user_denorm"})
     */
    public $language;

    /**
     * @var ?string
     * @Groups({"user_norm", "user_denorm"})
     */
    public $country;

    /**
     * @var ?string
     * @Groups({"user_norm", "user_denorm"})
     */
    public $imageUrl;

    /**
     * @var \DateTime
     * @Groups({"user_denorm"})
     */
    public $birthDate;

    /**
     * @var ?\DateTime
     * @Groups({"user_norm", "user_denorm"})
     */
    public $scheduleDelete;

    /**
     * @var ?array
     * @Groups({"user_denorm"})
     */
    public $userMeasures;

    /**
     * @var ?array
     * @Groups({"user_denorm"})
     */
    public $userMeasureGoals;

    /**
     * @var ?array
     * @Groups({"user_denorm"})
     */
    public $userStorages;

    /**
     * @var ?array
     * @Groups({"user_denorm"})
     */
    public $activities;

    /**
     * @var ?array
     * @Groups({"user_denorm"})
     */
    public $userAgreements;

    /**
     * @var \DateTime
     * @Groups({"user_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_norm"})
     */
    public $updatedAt;
}
