<?php

namespace Api\Services\Cart\Actualize;

use Api\Http\FillableRequests\Cart\{ActualizeRQ, Models\FlightActualizeData};
use Api\Http\Responses\Cart\ActualizeResponse;
use AviaticketActualizeRQ;
use AviaticketActualizeRS;
use HunterEngine;

/**
 * Class FlightActualizeService
 * Сервис актуализации авиа
 *
 * @package Api\Services\Cart\Actualize
 */
class FlightActualizeService extends ServiceActualize implements IActualizeService
{
    /**
     * Актуализируем предложение
     *
     * @param ActualizeResponse $response
     * @param ActualizeRQ       $actualizeRQ
     * @return void
     * @throws \Exception
     */
    public function actualize(ActualizeResponse $response, ActualizeRQ $actualizeRQ): void
    {
        $flightData = $actualizeRQ->getAirFlightData();
        $request = $this->getRequest($actualizeRQ, $flightData);
        $rawResponse = $this->apiService->actualize($request);
        $this->fillResponse($response, $actualizeRQ, $rawResponse);
    }

    /**
     * Формируем реквест
     *
     * @param ActualizeRQ         $actualizeRQ
     * @param FlightActualizeData $flightData
     * @return AviaticketActualizeRQ
     */
    private function getRequest(ActualizeRQ $actualizeRQ, FlightActualizeData $flightData): AviaticketActualizeRQ
    {
        $request = AviaticketActualizeRQ::make($flightData->getSearchId(), null, $flightData->getRecommendationId());
        $request->setCurrency($actualizeRQ->getCurrency());
        return $request;
    }

    /**
     * Заполняем ответ
     *
     * @param ActualizeResponse     $response
     * @param ActualizeRQ           $actualizeRQ
     * @param AviaticketActualizeRS $rawResponse
     * @return void
     */
    private function fillResponse(ActualizeResponse $response, ActualizeRQ $actualizeRQ,
                                  AviaticketActualizeRS $rawResponse): void
    {
        $this->actualize->handleActualize($rawResponse, $actualizeRQ->actualizeId);
        $response->flight = $this->actualize;
        $response->rawActualize[HunterEngine::TYPE_AVIATICKETS] = $rawResponse;
    }
}