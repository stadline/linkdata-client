<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int       getId()
 * @method void      setId(int $id)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method Datatype  getDatatype()
 * @method void      setDatatype(Datatype $datatype)
 * @method null|float    getInitial()
 * @method void      setInitial(?float $initial)
 * @method float     getGoal()
 * @method void      setGoal($goalfloat)
 * @method \DateTime getStartdate()
 * @method void      setStartdate(\DateTime $startdate)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class UserMeasureGoal extends ProxyObject
{
    /**
     * @var int
     * @Groups({"user_measure_goal_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm"})
     */
    public $user;

    /**
     * @var Datatype
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm"})
     */
    public $datatype;

    /**
     * @var ?float
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm"})
     */
    public $initial;

    /**
     * @var float
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm"})
     */
    public $goal;

    /**
     * @var \DateTime
     * @Groups({"user_measure_goal_norm", "user_measure_goal_denorm"})
     */
    public $startdate;

    /**
     * @var \DateTime
     * @Groups({"user_measure_goal_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_measure_goal_norm"})
     */
    public $updatedAt;
}
