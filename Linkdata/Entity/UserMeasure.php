<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserMeasure extends ProxyObject
{
    public const USER_DEFAULT_HEARTRATE_REST = 70;
    public const USER_CHILDREN_DEFAULT_HEARTRATE_REST = 95;

    /**
     * @var string
     * @Groups({"user_measure_norm"})
     */
    private $id;

    /**
     * @var User
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    private $user;

    /**
     * @var Datatype
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    private $datatype;

    /**
     * @var float
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    private $value;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $dateTimezone;

    /**
     * @var string
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    private $updatedAt;

    private $datatypeIri;

    public function __construct()
    {
        $this->dateTimezone = '+00.00';
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUser()
    {
        if (null !== $this->user) {
            $this->user->_hydrate();
        }
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getDatatype()
    {
        if (null !== $this->datatype) {
            $this->datatype->_hydrate();
        }
        return $this->datatype;
    }

    public function getDatatypeId(): int
    {
        return $this->getDatatype()->getId();
    }

    public function setDatatype(?Datatype $datatype): void
    {
        $this->datatype = $datatype;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public function getDate()
    {
        $date = new \DateTime($this->date);

        return $date->format('Y-m-d H:i:s');
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getDateTimezone(): string
    {
        return $this->dateTimezone;
    }

    public function setDateTimezone(string $dateTimezone): void
    {
        $this->dateTimezone = $dateTimezone;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
