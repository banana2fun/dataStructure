<?php

namespace Api\Services\Cart\Booking\Hotel;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use HotelsAPIService;
use Illuminate\Support\Facades\Log;

/**
 * Class BookingHotelService
 * Сервси бронирования отелей
 *
 * @package Api\Services\Cart\Booking\Hotel
 */
class BookingHotelService implements IBookingService
{
    /** @var BookingHotelCreateRequestService  */
    private $requestService;
    /** @var HotelsAPIService  */
    private $apiService;

    /**
     * BookingHotelService constructor.
     *
     * @param BookingHotelCreateRequestService $requestService
     * @param HotelsAPIService                 $apiService
     */
    public function __construct(BookingHotelCreateRequestService $requestService, HotelsAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод броинрвоания отелей
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
                'service' => 'accommodation',
                'bookingRequest' => $request,
                'response' => $response
            ]);
        } catch (\Throwable $e) {
            Log::info('restApiBookingError', [
                'service' => 'accommodation',
                'exception' => $e
            ]);
            $bookingResponse->errors[] = $e->getMessage();
        }
    }
}