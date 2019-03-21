<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int         getId()
 * @method void        setId(int $id)
 * @method DeviceModel getModel()
 * @method void        setModel(DeviceModel $model)
 * @method string      getVersion()
 * @method void        setVersion(string $version)
 * @method \DateTime   getRevisionDate()
 * @method void        setRevisionDate(\DateTime $revisionDate)
 * @method string      getPath()
 * @method void        setPath(string $path)
 * @method bool        isIsLastFirmware()
 * @method void        setIsLastFirmware(bool $isLastFirmware)
 * @method bool        isActive()
 * @method void        setActive(bool $active)
 * @method \DateTime   getCreatedAt()
 * @method void        setCreatedAt(\DateTime $createdAt)
 * @method \DateTime   getUpdatedAt()
 * @method void        setUpdatedAt(\DateTime $updatedAt)
 */
class Firmware extends ProxyObject
{
    /**
     * @var int
     * @Groups({"firmware_norm"})
     */
    public $id;

    /**
     * @var DeviceModel
     * @Groups({"firmware_norm"})
     */
    public $model;

    /**
     * @var string
     * @Groups({"firmware_norm"})
     */
    public $version;

    /**
     * @var \DateTime
     * @Groups({"firmware_norm"})
     */
    public $revisionDate;

    /**
     * @var string
     * @Groups({"firmware_norm"})
     */
    public $path;

    /**
     * @var bool
     * @Groups({"firmware_norm"})
     */
    public $isLastFirmware = false;

    /**
     * @var bool
     * @Groups({"firmware_norm"})
     */
    public $active = true;

    /**
     * @var \DateTime
     * @Groups({"firmware_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"firmware_norm"})
     */
    public $updatedAt;

    public function __toString(): string
    {
        return \sprintf('%s | %s (#%s)', $this->model, $this->version, $this->id);
    }
}
