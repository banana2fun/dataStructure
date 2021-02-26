<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class TransferActualizeData
 * Информация для акутализации трансферов
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class TransferActualizeData extends ActualizeData
{
    /** @var string */
    public $transferId;
    /** @var string */
    public $vehicleId;

    /**
     * @return string|null
     */
    public function getTransferId(): ?string
    {
        return $this->transferId;
    }

    /**
     * @param string|null $transferId
     * @return TransferActualizeData
     */
    public function setTransferId(?string $transferId): self
    {
        $this->transferId = $transferId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVehicleId(): ?string
    {
        return $this->vehicleId;
    }

    /**
     * @param string|null $vehicleId
     * @return TransferActualizeData
     */
    public function setVehicleId(?string $vehicleId): self
    {
        $this->vehicleId = $vehicleId;
        return $this;
    }
}