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
 * @method Datatype  getDatatype()
 * @method void      setDatatype(Datatype $datatype)
 * @method float     getValue()
 * @method void      setValue(float $value)
 * @method \DateTime getDate()
 * @method void      setDate(\DateTime $date)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
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
     * @var \DateTime
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $date;

    /**
     * @var \DateTime
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_measure_norm", "user_measure_denorm"})
     */
    public $updatedAt;
}
