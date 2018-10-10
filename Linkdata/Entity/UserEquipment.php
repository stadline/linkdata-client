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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sport", inversedBy="userEquipments")
     * @ORM\JoinTable(name="user_equipments_sport")
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $sports;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $createdAt;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"equipment_norm", "equipment_denorm"})
     */
    private $updatedAt;


}
