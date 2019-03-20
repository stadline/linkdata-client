<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string   getId()
 * @method void     setId(string $id)
 * @method string   getType()
 * @method void     setType(string $type)
 * @method User     getUser()
 * @method void     setUser(User $user)
 * @method Sport    getSport()
 * @method void     setSport(Sport $sport)
 * @method Datatype getDatatype()
 * @method void     setDatatype(Datatype $datatype)
 * @method string   getPeriod()
 * @method void     setPeriod(string $period)
 * @method int      getValue()
 * @method void     setValue(int $value)
 * @method string   getCreatedAt()
 * @method void     setCreatedAt(string $createdAt)
 * @method string   getUpdatedAt()
 * @method void     setUpdatedAt(string $updatedAt)
 */
class UserSumup extends ProxyObject
{
    const MONTHLY_SUMUP = 'MonthlySumup';
    const YEARLY_SUMUP = 'YearlySumup';

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
    public $value;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"user_sumup_norm"})
     */
    public $updatedAt;

    public function __construct()
    {
        $this->value = 0;
    }
}
