<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class SubActivity
{
    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $from;

    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $sportId;

    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $duration;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $dataSummaries = [];

    public function getFrom(): int
    {
        return $this->from;
    }

    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    public function getSportId(): int
    {
        return $this->sportId;
    }

    public function setSportId(int $sportId): void
    {
        $this->sportId = $sportId;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getDataSummaries(): array
    {
        return $this->dataSummaries;
    }

    public function setDataSummaries(array $dataSummaries): void
    {
        $this->dataSummaries = $dataSummaries;
    }


}
