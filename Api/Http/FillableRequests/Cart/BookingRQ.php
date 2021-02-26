<?php

namespace Api\Http\FillableRequests\Cart;

use Api\Http\FillableRequests\Cart\Models\{BookingInfo, BookingTourist};

/**
 * Class BookingRQ
 * Реквест для заполнения данных бронирования
 *
 * @package Api\Http\FillableRequests\Cart
 */
class BookingRQ
{
    /** @var BookingTourist[] Информация о туристах */
    public $tourists = [];
    /** @var int id заказа */
    public $orderId;
    /** @var string Тип приложения запроса */
    public $app;
    /** @var array Массив с id услуг для бронирования */
    public $services = [];
    /** @var BookingInfo Информация для броинрвоания */
    public $bookingInfo;

    /**
     * BookingRQ constructor.
     *
     * @param BookingInfo $bookingInfo
     */
    public function __construct(BookingInfo $bookingInfo)
    {
        $this->bookingInfo = $bookingInfo;
    }

    /**
     * @return array
     */
    public function getTourists(): array
    {
        return $this->tourists;
    }

    /**
     * @param array $tourists
     * @return BookingRQ
     */
    public function setTourists(array $tourists): self
    {
        $this->tourists = $tourists;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @param int|null $orderId
     * @return BookingRQ
     */
    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApp(): ?string
    {
        return $this->app;
    }

    /**
     * @param string|null $app
     * @return BookingRQ
     */
    public function setApp($app): self
    {
        $this->app = $app;
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
     * @return BookingRQ
     */
    public function setServices(array $services): self
    {
        $this->services = array_filter($services, 'strlen');
        return $this;
    }

    /**
     * @return BookingInfo
     */
    public function getBookingInfo(): BookingInfo
    {
        return $this->bookingInfo;
    }

    /**
     * @param BookingInfo $bookingInfo
     * @return $this
     */
    public function setBookingInfo(BookingInfo $bookingInfo): self
    {
        $this->bookingInfo = $bookingInfo;
        return $this;
    }
}