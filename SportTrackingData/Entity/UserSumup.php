<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method string    getType()
 * @method void      setType(string $type)
 * @method User      getUser()
 * @method void      setUser(User $user)
 * @method Sport     getSport()
 * @method void      setSport(Sport $sport)
 * @method Datatype  getDatatype()
 * @method void      setDatatype(Datatype $datatype)
 * @method string    getPeriod()
 * @method void      setPeriod(string $period)
 * @method int       getValue()
 * @method void      setValue(int $value)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class UserSumup extends ProxyObject
{
    const MONTHLY_SUMUP = 'MonthlySumup';
    const YEARLY_SUMUP = 'YearlySumup';
    const LIFELY_SUMUP = 'LifelySumup';

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    public $id;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    public $type;

    /**
     * @var User
     * @Groups({"user_sumup_norm"})
     */
    public $user;

    /**
     * @var Sport
     * @Groups({"user_sumup_norm"})
     */
    public $sport;

    /**
     * @var Datatype
     * @Groups({"user_sumup_norm"})
     */
    public $datatype;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    public $period;

    /**
     * @var int
     * @Groups({"user_sumup_norm"})
     */
    public $value = 0;

    /**
     * @var \DateTime
     * @Groups({"user_sumup_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_sumup_norm"})
     */
    public $updatedAt;
}
