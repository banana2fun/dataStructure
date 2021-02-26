<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class BookingInfoExcursion
 * Инофрмация для бронирования экскурсии
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class BookingInfoExcursion
{
    /** @var string id экскурсии*/
    public $excursionId;
    /** @var string Дата экскурсии*/
    public $date;
    /** @var string Время начала экскурсии*/
    public $time;

    /**
     * @return string|null
     */
    public function getExcursionId(): ?string
    {
        return $this->excursionId;
    }

    /**
     * @param string|null $excursionId
     * @return BookingInfoExcursion
     */
    public function setExcursionId(?string $excursionId): self
    {
        $this->excursionId = $excursionId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     * @return BookingInfoExcursion
     */
    public function setDate(?string $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string|null $time
     * @return BookingInfoExcursion
     */
    public function setTime(?string $time): self
    {
        $this->time = $time;
        return $this;
    }
}