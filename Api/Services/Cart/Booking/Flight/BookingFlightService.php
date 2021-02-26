<?php

namespace Api\Services\Cart\Booking\Flight;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use App\Logs\Facades\Log;
use AviaticketsAPIService;

/**
 * Class BookingFlightService
 * Сервис броинрования авиа
 *
 * @package Api\Services\Cart\Booking\Flight
 */
class BookingFlightService implements IBookingService
{
    /** @var BookingFlightCreateRequestService  */
    private $requestService;
    /** @var AviaticketsAPIService  */
    private $apiService;

    /**
     * BookingFlightService constructor.
     *
     * @param BookingFlightCreateRequestService $requestService
     * @param AviaticketsAPIService             $apiService
     */
    public function __construct(BookingFlightCreateRequestService $requestService, AviaticketsAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод бронирования авиа
     *
     * @param BookingRQ       $bookingRQ
     * @param BookingResponse $bookingResponse
     * @param array|null      $actualize
     * @return void
     */
    public function booking(BookingRQ $bookingRQ, BookingResponse $bookingResponse, ?array $actualize): void
    {
        try {
            $request = $this->requestService->getRequest($bookingRQ, $actualize);
            $response = $this->apiService->booking($request);
            $bookingResponse->orderId = $response->bookings[0]->orderId;
            Log::info('restApiBookingResponse', [
                'service' => 'flight',
                'bookingRequest' => $request,
                'response' => $response
            ]);
        } catch (\Throwable $e) {
            Log::info('restApiBookingError', [
                'service' => 'flight',
                'exception' => $e
            ]);
            $bookingResponse->errors[] = $e->getMessage();
        }
    }
}