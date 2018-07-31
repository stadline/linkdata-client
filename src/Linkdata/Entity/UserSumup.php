<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserSumup extends ProxyObject
{
    const MONTHLY_SUMUP = 'MonthlySumup';
    const YEARLY_SUMUP = 'YearlySumup';

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    private $id;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    private $type;

    /**
     * @var User
     * @Groups({"user_sumup_norm"})
     */
    protected $user;

    /**
     * @var Sport
     * @Groups({"user_sumup_norm"})
     */
    protected $sport;

    /**
     * @var Datatype
     * @Groups({"user_sumup_norm"})
     */
    private $datatype;
    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    private $period;

    /**
     * @var int
     * @Groups({"user_sumup_norm"})
     */
    private $value;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->value = 0;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getUser(): User
    {
        return $this->hydrate($this->user);
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getSport(): ?Sport
    {
        return $this->hydrate($this->sport);
    }

    public function setSport($sport): void
    {
        $this->sport = $sport;
    }

    public function getDatatype(): ?Datatype
    {
        return $this->hydrate($this->datatype);
    }

    public function setDatatype($datatype): void
    {
        $this->datatype = $datatype;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
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
}
