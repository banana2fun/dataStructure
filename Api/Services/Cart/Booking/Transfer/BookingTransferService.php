<?php

namespace Api\Services\Cart\Booking\Transfer;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use App\Logs\Facades\Log;
use TransfersAPIService;

/**
 * Class BookingTransferService
 * Сервис бронирования трансферов
 *
 * @package Api\Services\Cart\Booking\Transfer
 */
class BookingTransferService implements IBookingService
{
    /** @var BookingTransferCreateRequestService  */
    private $requestService;
    /** @var TransfersAPIService  */
    private $apiService;

    /**
     * BookingTransferService constructor.
     *
     * @param BookingTransferCreateRequestService $requestService
     * @param TransfersAPIService                 $apiService
     */
    public function __construct(BookingTransferCreateRequestService $requestService, TransfersAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод бронирования траснферов
     *
     * @param BookingRQ       $bookingRQ
     * @param BookingResponse $bookingResponse
     * @param array|null      $actualize
     * @return void
     */
    public function booking(BookingRQ $bookingRQ, BookingResponse $bookingResponse, ?array $actualize): void
    {
        try {
            $request = $this->requestService->getRequest($bookingRQ);
            $response = $this->apiService->booking($request);
            $bookingResponse->orderId = $response->bookings[0]->orderId;
            Log::info('restApiBookingResponse', [
                'service' => 'transfer',
                'bookingRequest' => $request,
                'response' => $response
            ]);
        } catch (\Throwable $e) {
            Log::info('restApiBookingError', [
                'service' => 'transfer',
                'exception' => $e
            ]);
            $bookingResponse->errors[] = $e->getMessage();
        }
    }
}