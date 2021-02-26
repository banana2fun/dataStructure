<?php

namespace Api\Services\Cart\Booking\Excursion;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use App\Logs\Facades\Log;
use ExcursionsAPIService;

/**
 * Class BookingExcursionService
 * Сервис броинрвоая экскурсий
 *
 * @package Api\Services\Cart\Booking\Excursion
 */
class BookingExcursionService implements IBookingService
{
    /** @var BookingExcursionCreateRequestService  */
    private $requestService;
    /** @var ExcursionsAPIService  */
    private $apiService;

    /**
     * BookingExcursionService constructor.
     *
     * @param BookingExcursionCreateRequestService $requestService
     * @param ExcursionsAPIService                 $apiService
     */
    public function __construct(BookingExcursionCreateRequestService $requestService, ExcursionsAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод для броинрования экскурсий
     *
     * @param BookingRQ       $bookingRQ
     * @param BookingResponse $bookingResponse
     * @param array|null      $actualize
     * @return void
     */
    public function booking(BookingRQ $bookingRQ, BookingResponse $bookingResponse, ?array $actualize): void
    {
        $requests = $this->requestService->getRequests($bookingRQ);
        foreach ($requests as $request) {
            try {
                $response = $this->apiService->booking($request);
                $bookingResponse->orderId = $response->bookings[0]->orderId;
                Log::info('restApiBookingResponse', [
                    'service' => 'excursion',
                    'bookingRequest' => $request,
                    'response' => $response
                ]);
            } catch (\Throwable $e) {
                Log::info('restApiBookingError', [
                    'service' => 'excursion',
                    'exception' => $e
                ]);
                $bookingResponse->errors[] = $e->getMessage();
            }
        }
    }
}