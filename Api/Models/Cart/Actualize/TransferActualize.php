<?php

namespace Api\Models\Cart\Actualize;

use Api\Models\ApiPrice;
use TransferActualizeRS;

/**
 * Class TransferActualize
 * Класс для актуализации трансферов
 *
 * @package Api\Models\Cart\Actualize
 */
class TransferActualize extends ApiActualize
{
    protected const VEHICLE_CHANGE = 'vehicle_change';

    /** @var string Идентификатор транспорта */
    public $vehicleId;

    /**
     * Обработка актуализации
     *
     * @param TransferActualizeRS $transferActualizeRS Сырая актуализация из поискового движка
     * @param int                 $actualizeId         Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleActualize(TransferActualizeRS $transferActualizeRS, int $actualizeId): void
    {
        $this->validateActualize($transferActualizeRS, $actualizeId);
        $this->price = new ApiPrice(
            $transferActualizeRS->result->price,
            $transferActualizeRS->result->markPrice,
            $transferActualizeRS->result->currency
        );
        $this->vehicleId = $transferActualizeRS->result->id;
        if (empty($this->code)) {
            $this->code[] = self::MATCH;
        }
    }

    /**
     * Метод для валидации результатов актуализации
     *
     * @param TransferActualizeRS $transferActualizeRS Сырая актуализация из поискового движка
     * @param int                 $actualizeId         Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function validateActualize(TransferActualizeRS $transferActualizeRS, int $actualizeId): void
    {
        $this->checkResults($transferActualizeRS, $actualizeId);
        $this->checkPrice($transferActualizeRS);
        $this->checkVehicle($transferActualizeRS);
    }

    /**
     * Метод для валидации транспортных средств
     *
     * @param TransferActualizeRS $transferActualizeRS Сырая актуализация из поискового движка
     * @return void
     */
    private function checkVehicle(TransferActualizeRS $transferActualizeRS): void
    {
        if ($transferActualizeRS->result->vehicleCode != $transferActualizeRS->previousResult->vehicleCode ||
            $transferActualizeRS->result->id != $transferActualizeRS->previousResult->id) {
            $this->errors[] = transoe('actualizeTransferChange');
            $this->code[] = self::VEHICLE_CHANGE;
        }
    }
}