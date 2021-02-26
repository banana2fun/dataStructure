<?php

namespace Api\Services\Cart\Booking;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;

/**
 * Interface IBookingService
 *
 * @package Api\Services\Cart\Booking
 */
interface IBookingService
{
    /**
     * Метод бронирования
     *
     * @param BookingRQ       $bookingRQ
     * @param BookingResponse $bookingResponse
     * @param array|null      $actualize
     * @return void
     */
    public function booking(BookingRQ $bookingRQ, BookingResponse $bookingResponse, ?array $actualize): void;
}