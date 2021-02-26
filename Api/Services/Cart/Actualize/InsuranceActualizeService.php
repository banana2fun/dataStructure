<?php

namespace Api\Services\Cart\Actualize;

use Api\Http\FillableRequests\Cart\{ActualizeRQ, Models\InsuranceActualizeData};
use Api\Http\Responses\Cart\ActualizeResponse;
use HunterEngine;
use InsuranceActualizeRQ;
use InsuranceActualizeRS;

/**
 * Class InsuranceActualizeService
 * Сервси актуализации страховок
 *
 * @package Api\Services\Cart\Actualize
 */
class InsuranceActualizeService extends ServiceActualize implements IActualizeService
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
        $insuranceData = $actualizeRQ->getInsuranceData();
        $request = $this->getRequest($actualizeRQ, $insuranceData);
        $rawResponse = $this->apiService->actualize($request);
        $this->fillResponse($response, $actualizeRQ, $rawResponse);
    }

    /**
     * Формируем реквест
     *
     * @param ActualizeRQ            $actualizeRQ
     * @param InsuranceActualizeData $insuranceData
     * @return InsuranceActualizeRQ
     */
    private function getRequest(ActualizeRQ $actualizeRQ, InsuranceActualizeData $insuranceData): InsuranceActualizeRQ
    {
        $request = InsuranceActualizeRQ::make($insuranceData->getSearchId(), null,
            $insuranceData->getResultId());
        $request->setCurrency($actualizeRQ->getCurrency());
        return $request;
    }

    /**
     * Заполняем ответ
     *
     * @param ActualizeResponse    $response
     * @param ActualizeRQ          $actualizeRQ
     * @param InsuranceActualizeRS $rawResponse
     * @return void
     */
    private function fillResponse(ActualizeResponse $response, ActualizeRQ $actualizeRQ,
                                  InsuranceActualizeRS $rawResponse): void
    {
        $this->actualize->handleActualize($rawResponse, $actualizeRQ->actualizeId);
        $response->insurance = $this->actualize;
        $response->rawActualize[HunterEngine::TYPE_INSURANCES] = $rawResponse;
    }
}