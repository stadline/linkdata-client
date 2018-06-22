<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class User
{
    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    protected $id;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    protected $oneId;

    /**
     * @var int
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    protected $gender;

    /**
     * @var array
     *
     * @Groups({"user_norm"})
     */
    protected $roles;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    protected $language;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    protected $country;

    /**
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
     */
    protected $imageUrl;

    /**
     * @var string
     *
     * @Groups({"user_denorm"})
     */
    protected $birthDate;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @Groups({"user_norm"})
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
     * @var string
     *
     * @Groups({"user_norm", "user_denorm"})
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
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOneId(): ?string
    {
        return $this->oneId;
    }

    /**
     * @param string $oneId
     */
    public function setOneId(?string $oneId): void
    {
        $this->oneId = $oneId;
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
    public function setGender(?int $gender): void
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
    public function setRoles(?array $roles): void
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
    public function setLanguage(?string $language): void
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
    public function setCountry(?string $country): void
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
    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(?string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getScheduleDelete(): ?string
    {
        return $this->scheduleDelete;
    }

    /**
     * @param string $scheduleDelete
     */
    public function setScheduleDelete(?string $scheduleDelete): void
    {
        $this->scheduleDelete = $scheduleDelete;
    }
}
