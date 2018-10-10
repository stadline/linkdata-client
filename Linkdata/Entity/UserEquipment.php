<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class UserEquipment extends ProxyObject
{
    /**
     * @var int
     *
     * @Groups({"equipment_norm"})
     */
    private $id;

    /**
     * @var User
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $user;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $category;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $brand;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $name;

    /**
     * @var array
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $sumups = [];

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $sports;

    /**
     * @var \DateTime
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $updatedAt;

    private $userIri;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User|string
     */
    public function getUser()
    {
        return $this->hydrate($this->user);
    }

    public function getUserId(): string
    {
        if (!$this->userIri) {
            $this->userIri = $this->user;
        }

        // Parse iri to get id.
        return \explode('/', $this->userIri)[3];
    }

    public function getUserIri()
    {
        return $this->userIri;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getSumups(): ?array
    {
        return $this->sumups;
    }

    /**
     * @param array $sumups
     */
    public function setSumups($sumups)
    {
        $this->sumups = $sumups;
    }

    /**
     * @return mixed
     */
    public function getSports(): ?array
    {
        return $this->sports;
    }

    /**
     * @param mixed $sports
     */
    public function setSports($sports)
    {
        $this->sports = $sports;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
