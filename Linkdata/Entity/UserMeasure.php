<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method Datatype  getDatatype()
 * @method void      setDatatype(Datatype $datatype)
 * @method string    getDateTimezone()
 * @method void      setDateTimezone(string $dateTimezone)
 * @method float     getValue()
 * @method void      setValue(float $value)
 * @method \DateTime getDate()
 * @method void      setDate(\DateTime $date)
 * @method string    getCreatedAt()
 * @method void      setCreatedAt(string $createdAt)
 * @method string    getUpdatedAt()
 * @method void      setUpdatedAt(string $updatedAt)
 */
class UserMeasure extends ProxyObject
{
    public const USER_DEFAULT_HEARTRATE_REST = 70;
    public const USER_CHILDREN_DEFAULT_HEARTRATE_REST = 95;

    /**
     * @var string
     * @Groups({"user_measure_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $user;

    /**
     * @var Datatype
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $datatype;

    /**
     * @var float
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $value;

    /**
     * @var DateTime
     */
    public $date;

    /**
     * @var string
     */
    public $dateTimezone;

    /**
     * @var string
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $updatedAt;

    public function __construct()
    {
        $this->dateTimezone = '+00.00';
    }
}
