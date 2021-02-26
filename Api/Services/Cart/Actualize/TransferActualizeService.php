<?php

namespace Api\Services\Cart\Actualize;

use Api\Http\FillableRequests\Cart\{ActualizeRQ, Models\TransferActualizeData};
use Api\Http\Responses\Cart\ActualizeResponse;
use HunterEngine;
use TransferActualizeRQ;
use TransferActualizeRS;

/**
 * Class TransferActualizeService
 * Сервис для актуализации трансферов
 *
 * @package Api\Services\Cart\Actualize
 */
class TransferActualizeService extends ServiceActualize implements IActualizeService
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
        $transferData = $actualizeRQ->getTransferData();
        $request = $this->getRequest($actualizeRQ, $transferData);
        $rawResponse = $this->apiService->actualize($request);
        $this->fillResponse($response, $actualizeRQ, $rawResponse);
    }

    /**
     * Формируем реквест
     *
     * @param ActualizeRQ           $actualizeRQ
     * @param TransferActualizeData $transferData
     * @return TransferActualizeRQ
     */
    private function getRequest(ActualizeRQ $actualizeRQ, TransferActualizeData $transferData): TransferActualizeRQ
    {
        $request = TransferActualizeRQ::make($transferData->getSearchId(), $transferData->getTransferId(),
            $transferData->getVehicleId());
        $request->setCurrency($actualizeRQ->getCurrency());
        return $request;
    }

    /**
     * Заполняем ответ
     *
     * @param ActualizeResponse   $response
     * @param ActualizeRQ         $actualizeRQ
     * @param TransferActualizeRS $rawResponse
     * @return void
     */
    private function fillResponse(ActualizeResponse $response, ActualizeRQ $actualizeRQ,
                                  TransferActualizeRS $rawResponse): void
    {
        $this->actualize->handleActualize($rawResponse, $actualizeRQ->actualizeId);
        $response->transfer = $this->actualize;
        $response->rawActualize[HunterEngine::TYPE_TRANSFER] = $rawResponse;
    }
}