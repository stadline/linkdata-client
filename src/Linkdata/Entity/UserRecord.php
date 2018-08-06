<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserRecord extends ProxyObject
{
    const ALL = 'all';
    const DISTANCE200M = 'distance.200m';
    const DISTANCE400M = 'distance.400m';
    const DISTANCE804M = 'distance.804m';
    const DISTANCE1000M = 'distance.1000m';
    const DISTANCE1609M = 'distance.1609m';
    const DISTANCE3218M = 'distance.3218m';
    const DISTANCE5000M = 'distance.5000m';
    const DISTANCE10000M = 'distance.10000m';
    const DISTANCE21097M = 'distance.21097m';
    const DISTANCE42195M = 'distance.42195m';
    const DISTANCE80000M = 'distance.80000m';
    const DISTANCE100000M = 'distance.100000m';
    const SEARCHED_DISTANCES = [200, 400, 804, 1000, 1609, 3218, 5000, 10000, 21097, 42195, 80000, 100000];

    /**
     * @var string
     * @Groups({"user_record_norm"})
     */
    private $id;

    /**
     * @var User
     * @Groups({"user_record_norm"})
     */
    private $user;

    /**
     * @var Datatype
     * @Groups({"user_record_norm"})
     */
    private $datatype;

    /**
     * @var Activity
     * @Groups({"user_record_norm"})
     */
    private $activity;

    /**
     * @var Sport
     * @Groups({"user_record_norm"})
     */
    private $sport;

    /**
     * @var string
     * @Groups({"user_record_norm"})
     */
    private $type = 'all';

    /**
     * @var float
     * @Groups({"user_record_norm"})
     */
    private $value;

    /**
     * @var DateTime
     * @Groups({"user_record_norm"})
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Groups({"user_record_norm"})
     */
    private $updatedAt;

    private $datatypeIri;
    private $sportIri;
    private $activityIri;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getDatatype(): ?Datatype
    {
        return $this->datatype;
    }

    public function setDatatype(Datatype $datatype): void
    {
        $this->datatype = $datatype;
    }

    public function getDatatypeId(): string
    {
        if (!$this->datatypeIri) {
            $this->datatypeIri = $this->datatype;
        }

        // Parse iri to get id.
        return \explode('/', $this->datatypeIri)[3];
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(Sport $sport): void
    {
        $this->sport = $sport;
    }

    public function getSportId(): string
    {
        if (!$this->sportIri) {
            $this->sportIri = $this->sport;
        }

        // Parse iri to get id.
        return \explode('/', $this->sportIri)[3];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(Activity $activity): void
    {
        $this->activity = $activity;
    }

    public function getActivityId(): string
    {
        if (!$this->activityIri) {
            $this->activityIri = $this->activity;
        }

        // Parse iri to get id.
        return \explode('/', $this->activityIri)[3];
    }
}
