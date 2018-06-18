<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use AppBundle\Activity\Validator\Constraints\Datastream;
use AppBundle\Activity\Validator\Constraints\Locations;
use AppBundle\DoctrineExtensions\Timezonable\Mapping\Annotation\Timezonable;
use AppBundle\DoctrineExtensions\Userable\Mapping\Annotation\Userable;
use AppBundle\Validator\Constraints\ActivityDataSummaryConstraint;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Activity
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @Serializer\SerializedName("user")
     * @Serializer\Type("string")
     */
    protected $user;

    /**
     * @var string
     *
     * @Serializer\SerializedName("sport")
     * @Serializer\Type("string")
     */
    protected $sport;

    /**
     * @var UserDevice
     *
     * @Serializer\SerializedName("userDevice")
     * @Serializer\Type("string")
     */
    protected $userDevice;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("startdate")
     * @Serializer\Type("datetime")
     */
    private $startdate;

    /**
     * @var string
     *
     * @Serializer\SerializedName("startdateTimezone")
     * @Serializer\Type("string")
     */
    private $startdateTimezone;

    /**
     * @var int
     *
     * @Serializer\SerializedName("duration")
     * @Serializer\Type("integer")
     */
    private $duration;

    /**
     * @var float
     *
     * @Serializer\SerializedName("latitude")
     * @Serializer\Type("float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @Serializer\SerializedName("longitude")
     * @Serializer\Type("float")
     */
    private $longitude;

    /**
     * @var float
     *
     * @Serializer\SerializedName("elevation")
     * @Serializer\Type("float")
     */
    private $elevation;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("manual")
     * @Serializer\Type("boolean")
     */
    private $manual;

    /**
     * @var string
     *
     * @Serializer\SerializedName("comment")
     * @Serializer\Type("string")
     */
    private $comment;

    /**
     * @var string
     *
     * @Serializer\SerializedName("connector")
     * @Serializer\Type("string")
     */
    private $connector;

    /**
     * @var string
     *
     * @Serializer\SerializedName("userSession")
     * @Serializer\Type("string")
     */
    private $userSession;

    /**
     * @var array
     *
     * @Serializer\SerializedName("images")
     * @Serializer\Type("array")
     */
    private $images;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("correctedElevation")
     * @Serializer\Type("boolean")
     */
    private $correctedElevation;

    /**
     * @var string
     *
     * @Serializer\SerializedName("thumbnail")
     * @Serializer\Type("string")
     */
    private $thumbnail;

    /**
     * @var array
     *
     * @Serializer\SerializedName("dataSummaries")
     * @Serializer\Type("array")
     */
    private $dataSummaries;

    /**
     * @var string
     *
     * @Serializer\SerializedName("tags")
     * @Serializer\Type("array")
     */
    private $tags;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("trackFlag")
     * @Serializer\Type("boolean")
     */
    private $trackFlag;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("datastreamFlag")
     * @Serializer\Type("boolean")
     */
    private $datastreamFlag;

    /**
     * @var string
     *
     * @Serializer\SerializedName("globalChallenge")
     * @Serializer\Type("string")
     */
    private $globalChallenge;

    /**
     * @var array
     *
     * @Serializer\SerializedName("availableDatatypes")
     * @Serializer\Type("array")
     */
    private $availableDatatypes;

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
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getSport(): ?string
    {
        return $this->sport;
    }

    /**
     * @param string $sport
     */
    public function setSport(string $sport): void
    {
        $this->sport = $sport;
    }

    /**
     * @return UserDevice
     */
    public function getUserDevice(): ?UserDevice
    {
        return $this->userDevice;
    }

    /**
     * @param UserDevice $userDevice
     */
    public function setUserDevice(UserDevice $userDevice): void
    {
        $this->userDevice = $userDevice;
    }

    /**
     * @return DateTime
     */
    public function getStartdate(): ?DateTime
    {
        return $this->startdate;
    }

    /**
     * @param DateTime $startdate
     */
    public function setStartdate(DateTime $startdate): void
    {
        $this->startdate = $startdate;
    }

    /**
     * @return string
     */
    public function getStartdateTimezone(): ?string
    {
        return $this->startdateTimezone;
    }

    /**
     * @param string $startdateTimezone
     */
    public function setStartdateTimezone(string $startdateTimezone): void
    {
        $this->startdateTimezone = $startdateTimezone;
    }

    /**
     * @return int
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return float
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getElevation(): ?float
    {
        return $this->elevation;
    }

    /**
     * @param float $elevation
     */
    public function setElevation(float $elevation): void
    {
        $this->elevation = $elevation;
    }

    /**
     * @return bool
     */
    public function isManual(): ?bool
    {
        return $this->manual;
    }

    /**
     * @param bool $manual
     */
    public function setManual(bool $manual): void
    {
        $this->manual = $manual;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getConnector(): ?string
    {
        return $this->connector;
    }

    /**
     * @param string $connector
     */
    public function setConnector(string $connector): void
    {
        $this->connector = $connector;
    }

    /**
     * @return string
     */
    public function getUserSession(): ?string
    {
        return $this->userSession;
    }

    /**
     * @param string $userSession
     */
    public function setUserSession(string $userSession): void
    {
        $this->userSession = $userSession;
    }

    /**
     * @return array
     */
    public function getImages(): ?array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return bool
     */
    public function isCorrectedElevation(): ?bool
    {
        return $this->correctedElevation;
    }

    /**
     * @param bool $correctedElevation
     */
    public function setCorrectedElevation(bool $correctedElevation): void
    {
        $this->correctedElevation = $correctedElevation;
    }

    /**
     * @return string
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return array
     */
    public function getDataSummaries(): ?array
    {
        return $this->dataSummaries;
    }

    /**
     * @param array $dataSummaries
     */
    public function setDataSummaries(array $dataSummaries): void
    {
        $this->dataSummaries = $dataSummaries;
    }

    /**
     * @return string
     */
    public function getTags(): ?string
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function isTrackFlag(): ?bool
    {
        return $this->trackFlag;
    }

    /**
     * @param bool $trackFlag
     */
    public function setTrackFlag(bool $trackFlag): void
    {
        $this->trackFlag = $trackFlag;
    }

    /**
     * @return bool
     */
    public function isDatastreamFlag(): ?bool
    {
        return $this->datastreamFlag;
    }

    /**
     * @param bool $datastreamFlag
     */
    public function setDatastreamFlag(bool $datastreamFlag): void
    {
        $this->datastreamFlag = $datastreamFlag;
    }

    /**
     * @return string
     */
    public function getGlobalChallenge(): ?string
    {
        return $this->globalChallenge;
    }

    /**
     * @param string $globalChallenge
     */
    public function setGlobalChallenge(string $globalChallenge): void
    {
        $this->globalChallenge = $globalChallenge;
    }

    /**
     * @return array
     */
    public function getAvailableDatatypes(): ?array
    {
        return $this->availableDatatypes;
    }

    /**
     * @param array $availableDatatypes
     */
    public function setAvailableDatatypes(array $availableDatatypes): void
    {
        $this->availableDatatypes = $availableDatatypes;
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
}
