<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class HotelActualizeData
 * Информация для акутализации отеля
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class HotelActualizeData extends ActualizeData
{
    /** @var string id отеля */
    public $hotelId;
    /** @var string id размещения */
    public $accommodationId;

    /**
     * @return int|null
     */
    public function getHotelId(): ?int
    {
        return $this->hotelId;
    }

    /**
     * @param int|null $hotelId
     * @return HotelActualizeData
     */
    public function setHotelId(?int $hotelId): self
    {
        $this->hotelId = $hotelId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccommodationId(): ?string
    {
        return $this->accommodationId;
    }

    /**
     * @param string|null $accommodationId
     * @return HotelActualizeData
     */
    public function setAccommodationId(?string $accommodationId): self
    {
        $this->accommodationId = $accommodationId;
        return $this;
    }
}