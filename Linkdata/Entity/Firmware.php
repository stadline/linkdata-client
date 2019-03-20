<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method DeviceModel getModel()
 * @method void        setModel(DeviceModel $model)
 * @method string      getVersion()
 * @method void        setVersion(string $version)
 * @method string      getRevisionDate()
 * @method void        setRevisionDate(string $revisionDate)
 * @method string      getPath()
 * @method void        setPath(string $path)
 * @method bool        isIsLastFirmware()
 * @method void        setIsLastFirmware(bool $isLastFirmware)
 * @method bool        isActive()
 * @method void        setActive(bool $active)
 * @method string      getCreatedAt()
 * @method void        setCreatedAt(string $createdAt)
 * @method string      getUpdatedAt()
 * @method void        setUpdatedAt(string $updatedAt)
 */
class Firmware
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
     * @var string
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
     * @var string
     * @Groups({"firmware_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"firmware_norm"})
     */
    public $updatedAt;

    public function __toString(): string
    {
        return \sprintf('%s | %s (#%s)', $this->model, $this->version, $this->id);
    }
}
