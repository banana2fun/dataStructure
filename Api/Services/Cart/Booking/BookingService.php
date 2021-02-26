<?php

namespace Api\Services\Cart\Booking;

use Api\Exceptions\Cart\BookingActualizeException;
use Api\Factories\ApiServicesFactory;
use Api\Helper\ApiStatusCode;
use Api\Http\FillableRequests\Cart\ActualizeRQ;
use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Actualize\ActualizeService;

/**
 * Class BookingService
 * Класс сервис для бронирования
 *
 * @package Api\Services\Cart
 */
class BookingService
{
    /** @var ActualizeService  */
    private $actualizeService;
    /** @var BookingResponse  */
    private $response;

    /**
     * BookingService constructor.
     *
     * @param ActualizeService $actualizeService
     * @param BookingResponse  $response
     */
    public function __construct(ActualizeService $actualizeService, BookingResponse $response)
    {
        $this->actualizeService = $actualizeService;
        $this->response = $response;
    }

    /**
     * Метод для бронирования услуг из корзины
     *
     * @param BookingRQ   $bookingRQ
     * @param ActualizeRQ $actualizeRQ
     * @return BookingResponse
     * @throws BookingActualizeException
     * @throws \Api\Exceptions\Cart\ActualizeCriticalException
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function booking(BookingRQ $bookingRQ, ActualizeRQ $actualizeRQ): BookingResponse
    {
        $actualize = $this->actualize($actualizeRQ);

        foreach ($bookingRQ->services as $serviceId) {
            $service = ApiServicesFactory::makeBookingServices($serviceId);
            $service->booking($bookingRQ, $this->response, $actualize);
            $bookingRQ->setOrderId($bookingRQ->getOrderId() ?? $this->response->orderId);
        }

        return $this->response;
    }

    /**
     * Актуализация перед бронированием
     *
     * @param ActualizeRQ $actualizeData
     * @return array|null
     * @throws BookingActualizeException
     * @throws \Api\Exceptions\Cart\ActualizeCriticalException
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function actualize(ActualizeRQ $actualizeData): ?array
    {
        $actualize = $this->actualizeService->actualize($actualizeData);
        if ($actualize->code !== ApiStatusCode::SUCCESS) {
            throw new BookingActualizeException($actualize);
        }
        return $actualize->rawActualize;
    }
}
