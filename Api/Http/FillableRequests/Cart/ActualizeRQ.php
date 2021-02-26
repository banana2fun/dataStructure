<?php

namespace Api\Http\FillableRequests\Cart;

use Api\Http\FillableRequests\Cart\Models\{FlightActualizeData,
    HotelActualizeData,
    InsuranceActualizeData,
    TransferActualizeData
};
use HunterEngine;

/**
 * Class ActualizeRQ
 * Реквест для заполнения актуализации
 *
 * @package Api\Http\FillableRequests\Cart
 */
class ActualizeRQ
{
    public const DEFAULT_ACTUALIZE_ID = 1;
    private const ACTUALIZED_SERVICES = [
        HunterEngine::TYPE_HOTEL,
        HunterEngine::TYPE_TRANSFER,
        HunterEngine::TYPE_AVIATICKETS,
        HunterEngine::TYPE_INSURANCES,
    ];

    /** int Id актуализации*/
    public $actualizeId;
    /** string Валюта */
    public $currency;
    /** @var array */
    public $services;
    /** @var HotelActualizeData */
    public $hotelData;
    /** @var TransferActualizeData */
    public $transferData;
    /** @var InsuranceActualizeData */
    public $insuranceData;
    /** @var FlightActualizeData */
    public $airFlightData;

    /**
     * @return int|null
     */
    public function getActualizeId(): ?int
    {
        return $this->actualizeId;
    }

    /**
     * @param int|null $actualizeId
     * @return ActualizeRQ
     */
    public function setActualizeId(?int $actualizeId): self
    {
        $this->actualizeId = $actualizeId ?? self::DEFAULT_ACTUALIZE_ID;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return ActualizeRQ
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency ?? 'RUB';
        return $this;
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param array $services
     * @return ActualizeRQ
     */
    public function setServices(array $services): self
    {
        $this->services = array_intersect(array_map('intval', $services), self::ACTUALIZED_SERVICES);
        return $this;
    }

    /**
     * @return HotelActualizeData
     */
    public function getHotelData(): HotelActualizeData
    {
        return $this->hotelData;
    }

    /**
     * @param HotelActualizeData $hotelData
     * @return ActualizeRQ
     */
    public function setHotelData(HotelActualizeData $hotelData): self
    {
        $this->hotelData = $hotelData;
        return $this;
    }

    /**
     * @return TransferActualizeData
     */
    public function getTransferData(): TransferActualizeData
    {
        return $this->transferData;
    }

    /**
     * @param TransferActualizeData $transferData
     * @return ActualizeRQ
     */
    public function setTransferData(TransferActualizeData $transferData): self
    {
        $this->transferData = $transferData;
        return $this;
    }

    /**
     * @return InsuranceActualizeData
     */
    public function getInsuranceData(): InsuranceActualizeData
    {
        return $this->insuranceData;
    }

    /**
     * @param InsuranceActualizeData $insuranceData
     * @return ActualizeRQ
     */
    public function setInsuranceData(InsuranceActualizeData $insuranceData): self
    {
        $this->insuranceData = $insuranceData;
        return $this;
    }

    /**
     * @return FlightActualizeData
     */
    public function getAirFlightData(): FlightActualizeData
    {
        return $this->airFlightData;
    }

    /**
     * @param FlightActualizeData $airFlightData
     * @return ActualizeRQ
     */
    public function setAirFlightData(FlightActualizeData $airFlightData): self
    {
        $this->airFlightData = $airFlightData;
        return $this;
    }
}