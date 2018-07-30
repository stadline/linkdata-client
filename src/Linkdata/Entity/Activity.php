<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class Activity extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"activity_norm"})
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $name;

    /**
     * @var User
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    protected $user;

    /**
     * @var Sport
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    protected $sport;

    /**
     * @var string
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    protected $userDevice;

    /**
     * @var string
     */
    private $startdate;

    /**
     * @var string
     */
    private $startstringzone;

    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $duration;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $latitude;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $longitude;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $elevation;

    /**
     * @var bool
     */
    private $manual;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $comment;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $connector;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $userSession;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $images;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    private $correctedElevation;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $thumbnail;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $dataSummaries;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $tags;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    private $trackFlag;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    private $datastreamFlag;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    private $globalChallenge;

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    private $availableDatatypes;

    /**
     * @var string
     * @Groups({"activity_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"activity_norm"})
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
    public function setId(?string $id): void
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
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->hydrate($this->user);
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->hydrate($this->sport);
    }

    public function setSport($sport): void
    {
        $this->sport = $sport;
    }

    /**
     * @return string
     */
    public function getUserDevice(): ?string
    {
        return $this->userDevice;
    }

    /**
     * @param string $userDevice
     */
    public function setUserDevice(?string $userDevice): void
    {
        $this->userDevice = $userDevice;
    }

    /**
     * @return string
     */
    public function getStartdate(): ?string
    {
        return $this->startdate;
    }

    /**
     * @param string $startdate
     */
    public function setStartdate(?string $startdate): void
    {
        $this->startdate = $startdate;
    }

    /**
     * @return string
     */
    public function getStartstringzone(): ?string
    {
        return $this->startstringzone;
    }

    /**
     * @param string $startstringzone
     */
    public function setStartstringzone(?string $startstringzone): void
    {
        $this->startstringzone = $startstringzone;
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
    public function setDuration(?int $duration): void
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
    public function setLatitude(?float $latitude): void
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
    public function setLongitude(?float $longitude): void
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
    public function setElevation(?float $elevation): void
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
    public function setManual(?bool $manual): void
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
    public function setComment(?string $comment): void
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
    public function setConnector(?string $connector): void
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
    public function setUserSession(?string $userSession): void
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
    public function setImages(?array $images): void
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
    public function setCorrectedElevation(?bool $correctedElevation): void
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
    public function setThumbnail(?string $thumbnail): void
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
    public function setDataSummaries(?array $dataSummaries): void
    {
        $this->dataSummaries = $dataSummaries;
    }

    /**
     * @return array
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(?array $tags): void
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
    public function setTrackFlag(?bool $trackFlag): void
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
    public function setDatastreamFlag(?bool $datastreamFlag): void
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
    public function setGlobalChallenge(?string $globalChallenge): void
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
    public function setAvailableDatatypes(?array $availableDatatypes): void
    {
        $this->availableDatatypes = $availableDatatypes;
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
}
