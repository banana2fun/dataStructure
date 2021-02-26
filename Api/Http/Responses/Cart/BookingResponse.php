<?php

namespace Api\Http\Responses\Cart;

/**
 * Class BookingResponse
 * Класс для овтета бронирования
 *
 * @package Api\Http\Responses\Cart
 */
class BookingResponse
{
    /** @var int Номер заказа */
    public $orderId;

    /** @var array Массив с ошибками */
    public $errors = [];
}