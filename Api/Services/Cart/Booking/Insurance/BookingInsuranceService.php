<?php

namespace Api\Services\Cart\Booking\Insurance;

use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\Responses\Cart\BookingResponse;
use Api\Services\Cart\Booking\IBookingService;
use App\Logs\Facades\Log;
use InsurancesAPIService;

/**
 * Class BookingInsuranceService
 * Сервис броинрования страховок
 *
 * @package Api\Services\Cart\Booking\Insurance
 */
class BookingInsuranceService implements IBookingService
{
    /** @var BookingInsuranceCreateRequestService  */
    private $requestService;
    /** @var InsurancesAPIService  */
    private $apiService;

    /**
     * BookingInsuranceService constructor.
     *
     * @param BookingInsuranceCreateRequestService $requestService
     * @param InsurancesAPIService                 $apiService
     */
    public function __construct(BookingInsuranceCreateRequestService $requestService, InsurancesAPIService $apiService)
    {
        $this->requestService = $requestService;
        $this->apiService = $apiService;
    }

    /**
     * Метод бронирования страховок
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
                'service' => 'insurance',
                'bookingRequest' => $request,
                'response' => $response
            ]);
        } catch (\Throwable $e) {
            Log::info('restApiBookingError', [
                'service' => 'insurance',
                'exception' => $e
            ]);
            $bookingResponse->errors[] = $e->getMessage();
        }
    }
}