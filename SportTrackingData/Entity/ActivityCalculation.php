<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string    getId()
 * @method void      setId(string $id)
 * @method Activity  getActivity()
 * @method void      setActivity(Activity $activity)
 * @method string    getType()
 * @method void      setType(string $type)
 * @method string    getStatus()
 * @method void      setStatus(string $status)
 * @method array     getData()
 * @method void      setData(array $data)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class ActivityCalculation extends ProxyObject
{
    /**
     * @var string
     * @Groups({"activity_calculation_norm"})
     */
    public $id;

    /**
     * @var Activity
     * @Groups({"activity_calculation_norm"})
     */
    public $activity;

    /**
     * @var string
     * @Groups({"activity_calculation_norm"})
     */
    public $type;

    /**
     * @var string
     * @Groups({"activity_calculation_norm"})
     */
    public $status;

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $data;

    /**
     * @var \DateTime
     * @Groups({"activity_calculation_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"activity_calculation_norm"})
     */
    public $updatedAt;
}
