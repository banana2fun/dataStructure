<?php

namespace Api\Services\Cart\Booking\Visa;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use App\Logs\Facades\Log;
use VisasAPIService;

/**
 * Class BookingVisaService
 * Сервис бронирования виз
 *
 * @package Api\Services\Cart\Booking\Visa
 */
class BookingVisaService implements IBookingService
{
    /** @var BookingVisaCreateRequestService  */
    private $requestService;
    /** @var VisasAPIService  */
    private $apiService;

    /**
     * BookingVisaService constructor.
     *
     * @param BookingVisaCreateRequestService $requestService
     * @param VisasAPIService                 $apiService
     */
    public function __construct(BookingVisaCreateRequestService $requestService, VisasAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод броинрвоания виз
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
                    'service' => 'visa',
                    'bookingRequest' => $request,
                    'response' => $response
                ]);
            } catch (\Throwable $e) {
                Log::info('restApiBookingError', [
                    'service' => 'visa',
                    'exception' => $e
                ]);
                $bookingResponse->errors[] = $e->getMessage();
            }
        }
    }
}