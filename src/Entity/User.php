<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use AppBundle\DBAL\Types\GenderType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class User
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    protected $id;

    /**
     * @var int
     *
     * @Serializer\SerializedName("gender")
     * @Serializer\Type("integer")
     */
    protected $gender;

    /**
     * @var array
     *
     * @Serializer\SerializedName("roles")
     * @Serializer\Type("array")
     */
    protected $roles;

    /**
     * @var string
     *
     * @Serializer\SerializedName("language")
     * @Serializer\Type("string")
     */
    protected $language;

    /**
     * @var string
     *
     * @Serializer\SerializedName("country")
     * @Serializer\Type("string")
     */
    protected $country;

    /**
     * @var string
     *
     * @Serializer\SerializedName("imageUrl")
     * @Serializer\Type("string")
     */
    protected $imageUrl;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("birthDate")
     * @Serializer\Type("datatime")
     */
    protected $birthDate;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("createdAt")
     * @Serializer\Type("datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("updatedAt")
     * @Serializer\Type("datetime")
     */
    private $updatedAt;

//    /**
//     * @var ArrayCollection
//     */
//    private $userMeasures;
//
//    /**
//     * @var ArrayCollection
//     */
//    private $userMeasureGoals;
//
//    /**
//     * @var ArrayCollection
//     */
//    private $userStorages;
//
//    /**
//     * @var ArrayCollection
//     */
//    private $activities;
//
//    private $userRecords;
//
//    /**
//     * @var ArrayCollection
//     */
//    private $userRoutes;
//
//    /**
//     * @var ArrayCollection
//     */
//    private $userAgreements;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("scheduleDelete")
     * @Serializer\Type("datetime")
     */
    private $scheduleDelete;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return DateTime
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     */
    public function setBirthDate(DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getScheduleDelete(): ?DateTime
    {
        return $this->scheduleDelete;
    }

    /**
     * @param DateTime $scheduleDelete
     */
    public function setScheduleDelete(DateTime $scheduleDelete): void
    {
        $this->scheduleDelete = $scheduleDelete;
    }
}
