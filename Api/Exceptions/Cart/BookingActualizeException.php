<?php

namespace Api\Exceptions\Cart;

use Api\Exceptions\ApiException;
use Api\Http\Responses\Cart\ActualizeResponse;

/**
 * Class BookingActualizeException
 * Исключение при актуализации перед бронированием
 *
 * @package Api\Exceptions\Cart
 */
class BookingActualizeException extends ApiException
{
    /** @var ActualizeResponse  */
    public $actualizeResponse;

    /**
     * BookingActualizeException constructor.
     *
     * @param ActualizeResponse $actualizeResponse
     */
    public function __construct(ActualizeResponse $actualizeResponse)
    {
        parent::__construct();
        $this->actualizeResponse = $actualizeResponse;
    }
}