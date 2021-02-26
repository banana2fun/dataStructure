<?php

namespace Api\Services\Cart\Actualize;

use Api\Http\FillableRequests\Cart\{ActualizeRQ, Models\HotelActualizeData};
use Api\Http\Responses\Cart\ActualizeResponse;
use HotelActualizeRQ;
use HotelActualizeRS;
use HunterEngine;

/**
 * Class HotelActualizeService
 * Сервис актуализации отелей
 *
 * @package Api\Services\Cart\Actualize
 */
class HotelActualizeService extends ServiceActualize implements IActualizeService
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
        $hotelData = $actualizeRQ->getHotelData();
        $request = $this->getRequest($actualizeRQ, $hotelData);
        $rawResponse = $this->apiService->actualize($request);
        $this->fillResponse($response, $actualizeRQ, $rawResponse);
    }

    /**
     * Формируем реквсет
     *
     * @param ActualizeRQ        $actualizeRQ
     * @param HotelActualizeData $hotelData
     * @return HotelActualizeRQ
     */
    private function getRequest(ActualizeRQ $actualizeRQ, HotelActualizeData $hotelData): HotelActualizeRQ
    {
        $request = HotelActualizeRQ::make($hotelData->getSearchId(), $hotelData->getHotelId(),
            $hotelData->getAccommodationId());
        $request->setCurrency($actualizeRQ->getCurrency());
        return $request;
    }

    /**
     * Заполняем ответ
     *
     * @param ActualizeResponse $response
     * @param ActualizeRQ       $actualizeRQ
     * @param HotelActualizeRS  $rawResponse
     * @return void
     */
    private function fillResponse(ActualizeResponse $response, ActualizeRQ $actualizeRQ,
                                  HotelActualizeRS $rawResponse): void
    {
        $this->actualize->handleActualize($rawResponse, $actualizeRQ->actualizeId);
        $response->accommodation = $this->actualize;
        $response->rawActualize[HunterEngine::TYPE_HOTEL] = $rawResponse;
    }
}