<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method string    getCategory()
 * @method void      setCategory(string $category)
 * @method string    getBrand()
 * @method void      setBrand(string $brand)
 * @method string    getName()
 * @method void      setName(string $name)
 * @method array     getSumups()
 * @method void      setSumups(array $sumups)
 * @method array     getSportsAutoAssigned()
 * @method void      setSportsAutoAssigned(array $sports)
 * @method \DateTime getStartDate()
 * @method void      setStartDate(\DateTime $startDate)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class UserEquipment extends ProxyObject
{
    /**
     * @var int
     *
     * @Groups({"equipment_norm"})
     */
    public $id;

    /**
     * @var User
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $user;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $category;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $brand;

    /**
     * @var string
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $name;

    /**
     * @var array
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $sumups = [];

    /**
     * @var Sport[]
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $sportsAutoAssigned;

    /**
     * @var \DateTime
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $startDate;

    /**
     * @var \DateTime
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     *
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    public $updatedAt;
}
