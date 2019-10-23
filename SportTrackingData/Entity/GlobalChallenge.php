<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use SportTrackingDataSdk\ClientHydra\Utils\TranslatedPropertiesTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string         getId()
 * @method void           setId(string $id)
 * @method array          getTranslatedNames()
 * @method void           setTranslatedNames(array $translatedNames)
 * @method Datatype       getTargetDatatype()
 * @method void           setTargetDatatype(Datatype $targetDatatype)
 * @method null|array     getTranslatedBeforeMessage()
 * @method void           setTranslatedBeforeMessage(?array $translatedBeforeMessage)
 * @method null|array     getTranslatedCurrentMessage()
 * @method void           setTranslatedCurrentMessage(?array $translatedCurrentMessage)
 * @method null|array     getTranslatedAfterMessage()
 * @method void           setTranslatedAfterMessage(?array $translatedAfterMessage)
 * @method null|\DateTime getPublishDate()
 * @method void           setPublishDate(?\DateTime $publishDate)
 * @method null|\DateTime getStartedAt()
 * @method void           setStartedAt(?\DateTime $startedAt)
 * @method null|\DateTime getEndedAt()
 * @method void           setEndedAt(?\DateTime $endedAt)
 * @method null|int       getTarget()
 * @method void           setTarget(?int $target)
 * @method int            getResult()
 * @method void           setResult(int $result)
 * @method null|string    getImageUrl()
 * @method void           setImageUrl(?string $imageUrl)
 * @method bool           isActive()
 * @method void           setActive(bool $active)
 * @method \DateTime      getCreatedAt()
 * @method void           setCreatedAt(\DateTime $createdAt)
 * @method \DateTime      getUpdatedAt()
 * @method void           setUpdatedAt(\DateTime $updatedAt)
 */
class GlobalChallenge extends ProxyObject
{
    use TranslatedPropertiesTrait;

    const STATE_BEFORE = -1;
    const STATE_CURRENT = 0;
    const STATE_AFTER = 1;

    /**
     * @var string
     * @Groups({"global_challenge_norm"})
     */
    public $id;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedNames;

    /**
     * @var Datatype
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $targetDatatype;

    /**
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedBeforeMessage;

    /**
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedCurrentMessage;

    /**
     * @var ?array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $translatedAfterMessage;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $publishDate;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $startedAt;

    /**
     * @var ?\DateTime
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $endedAt;

    /**
     * @var ?int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $target;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $result = 0;

    /**
     * @var ?string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $imageUrl;

    /**
     * @var bool
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    public $active = true;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"global_challenge_norm"})
     */
    public $updatedAt;

    /**
     * @var ?string
     * @Groups({"global_challenge_norm"})
     */
    public $country;

    public function getNameByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedNames', $locale);
    }

    public function getBeforeMessageByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedBeforeMessage', $locale);
    }

    public function getCurrentMessageByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedCurrentMessage', $locale);
    }

    public function getAfterMessageByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedAfterMessage', $locale);
    }

    /**
     * Returns challenge state (BEFORE / CURRENT / AFTER).
     *
     * @throws \Exception
     *
     * @return int
     */
    public function getState()
    {
        $now = new \DateTime();
        $startedAt = $this->getStartedAtAsDateTimeObject();
        $endedAt = $this->getEndedAtAsDateTimeObject();

        if ($startedAt > $now) {
            return self::STATE_BEFORE;
        }
        if ($this->endedAt && $now >= $endedAt) {
            return self::STATE_AFTER;
        }

        return self::STATE_CURRENT;
    }

    /**
     * @throws \Exception
     *
     * @return \DateTime
     */
    public function getStartedAtAsDateTimeObject()
    {
        return null !== $this->getStartedAt() ? new \DateTime($this->getStartedAt()) : null;
    }

    /**
     * @throws \Exception
     *
     * @return \DateTime
     */
    public function getEndedAtAsDateTimeObject()
    {
        return null !== $this->getEndedAt() ? new \DateTime($this->getEndedAt()) : null;
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function isOver()
    {
        return self::STATE_AFTER === $this->getState();
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function isInProgress()
    {
        return self::STATE_CURRENT === $this->getState();
    }

    /**
     * @return float between 0 and 100
     */
    public function getProgress()
    {
        return 100 * $this->getResult() / $this->getTarget();
    }

    /**
     * @throws \Exception
     *
     * @return bool
     */
    public function isNotStarted()
    {
        return self::STATE_BEFORE === $this->getState();
    }

    /**
     * @return bool
     */
    public function isDistance()
    {
        return Datatype::DISTANCE === $this->getTargetDatatype()->getId();
    }
}
