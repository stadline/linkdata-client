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
    public $sports;

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
