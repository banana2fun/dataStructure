<?php

namespace Api\Http\Controllers;

use Api\Exceptions\Cart\BookingActualizeException;
use Api\Http\FillableRequests\Cart\{ActualizeRQ, BookingRQ};
use Api\Http\Middleware\{ApiKeyAuthMiddleware, ForceJsonResponse};
use Api\Http\Requests\Cart\{ActualizeRequest, BookingActualizeRequest, BookingRequest};
use Api\Http\Resources\Cart\{ActualizeResource, BookingResource};
use Api\Services\Cart\{Actualize\ActualizeService, Booking\BookingService};
use App\Http\Controllers\Controller;
use Exception;

/**
 * Class CartController
 * Контроллер корзины
 *
 * @package Api\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->middleware(ApiKeyAuthMiddleware::class);
        $this->middleware(ForceJsonResponse::class);
    }

    /**
     * Экшен актуализации размещения
     *
     * @param ActualizeRequest $request
     * @param ActualizeService $actualizeService
     * @return ActualizeResource
     * @throws \Api\Exceptions\Cart\ActualizeCriticalException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Api\Exceptions\Cart\ActualizeException
     */
    public function actualize(ActualizeRequest $request, ActualizeService $actualizeService)
    {
        $actualizeRQ = $request->fillRequest(new ActualizeRQ());
        $response = $actualizeService->actualize($actualizeRQ);
        return new ActualizeResource($response);

    }

    /**
     * Экшен бронирования
     *
     * @param BookingActualizeRequest $actualizeRequest
     * @param BookingRequest          $bookingRequest
     * @param BookingService          $bookingService
     *
     * @return BookingResource|ActualizeResource
     * @throws Exception
     */
    public function booking(BookingActualizeRequest $actualizeRequest, BookingRequest $bookingRequest,
                            BookingService $bookingService)
    {
        $bookingRQ = $bookingRequest->fillRequest(app()->make(BookingRQ::class));
        $actualizeRQ = $actualizeRequest->fillRequest(new ActualizeRQ());
        try {
            $response = $bookingService->booking($bookingRQ, $actualizeRQ);
        } catch (BookingActualizeException $e) {
            return new ActualizeResource($e->actualizeResponse);
        }

        return new BookingResource($response);
    }
}
