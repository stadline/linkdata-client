<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;


class UserMeasureGoal extends ProxyObject
{
    /**
     * @var int
     * @Groups({"user_measure_goal_norm", "user.migration"})
     */
    private $id;

    /**
     * @var User
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm", "user.migration"})
     */
    private $user;

    /**
     * @var Datatype
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm", "user.migration"})
     */
    private $datatype;

    /**
     * @var float
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm", "user.migration"})
     */
    private $initial;

    /**
     * @var float
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm", "user.migration"})
     */
    private $goal;

    /**
     * @var DateTime
     */
    private $startdate;

    /**
     * @var string
     */
    private $startdateTimezone;

    /**
     * @var DateTime
     * @Groups({"user_measure_goal_norm", "user.migration"})
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Groups({"user_measure_goal_norm", "user.migration"})
     */
    private $updatedAt;

    private $datatypeIri;

    public function __construct()
    {
        $this->startdate = new DateTime();
        $this->startdateTimezone = '+00.00';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getDatatype(): Datatype
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

    public function getInitial(): ?float
    {
        return $this->initial;
    }

    public function setInitial(?float $initial): void
    {
        $this->initial = $initial;
    }

    public function getGoal(): float
    {
        return $this->goal;
    }

    public function setGoal(float $goal): void
    {
        $this->goal = $goal;
    }

    /**
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm", "user.migration"})
     */
    public function getStartdate(): DateTime
    {
        return \DateTime::createFromFormat(
            'Y-m-d H:i:s',
            $this->startdate->format('Y-m-d H:i:s'),
            new \DateTimeZone($this->startdateTimezone)
        );
    }

    public function getStartdateForTimezonable(): DateTime
    {
        return $this->startdate;
    }

    public function setStartdate(DateTime $startdate): void
    {
        $this->startdate = $startdate;
    }

    public function getStartdateTimezone(): string
    {
        return $this->startdateTimezone;
    }

    public function setStartdateTimezone(string $startdateTimezone): void
    {
        $this->startdateTimezone = $startdateTimezone;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
