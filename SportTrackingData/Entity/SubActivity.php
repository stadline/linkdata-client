<?php


namespace SportTrackingDataSdk\SportTrackingData\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int               getFrom()
 * @method void              setFrom(int $from)
 * @method int               getSportId()
 * @method void              setSportId(int $sportId)
 * @method int               getDuration()
 * @method void              setDuration(int $duration)
 * @method array             getDataSummaries()
 * @method void              setDataSummaries(array $dataSummaries)
 */
class SubActivity
{

    /**
     * @var int
     * @Groups({"sub_activity_norm", "sub_activity_denorm"})
     */
    public $from;

    /**
     * @var int
     * @Groups({"sub_activity_norm", "sub_activity_denorm"})
     */
    public $sportId;

    /**
     * @var int
     * @Groups({"sub_activity_norm", "sub_activity_denorm"})
     */
    public $duration;

    /**
     * @var array
     * @Groups({"sub_activity_norm", "sub_activity_denorm"})
     */
    public $dataSummaries = [];

}
