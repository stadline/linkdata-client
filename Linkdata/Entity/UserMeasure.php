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

    public function getUser(): User
    {
        return $this->hydrate($this->user);
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getDatatype(): ?Datatype
    {
        $this->datatypeIri = $this->datatype;

        return $this->hydrate($this->datatype);
    }

    public function getDatatypeId(): string
    {
        if (!$this->datatypeIri) {
            $this->datatypeIri = $this->datatype;
        }

        // Parse iri to get id.
        return \explode('/', $this->datatypeIri)[3];
    }

    public function setDatatype($datatype): void
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
    public function getDate(): DateTime
    {
        return \DateTime::createFromFormat(
            'Y-m-d H:i:s',
            $this->date->format('Y-m-d H:i:s'),
            new \DateTimeZone($this->dateTimezone)
        );
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
