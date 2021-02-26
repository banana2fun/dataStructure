<?php

namespace Api\Models\Cart\Actualize;

use Api\Models\ApiPrice;
use InsuranceActualizeRS;

/**
 * Class InsuranceActualize
 * Класс для актуализации страховки
 *
 * @package Api\Models\Cart\Actualize
 */
class InsuranceActualize extends ApiActualize
{
    /**
     * Обработка актуализации
     *
     * @param InsuranceActualizeRS $transferActualizeRS Сырая актуализация из поискового движка
     * @param int                  $actualizeId         Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleActualize(InsuranceActualizeRS $transferActualizeRS, int $actualizeId): void
    {
        $this->validateActualize($transferActualizeRS, $actualizeId);
        $this->price = new ApiPrice(
            $transferActualizeRS->result->price,
            $transferActualizeRS->result->markPrice,
            $transferActualizeRS->result->currency
        );
        $this->insuranceResultId = $transferActualizeRS->result->id;
        if (empty($this->code)) {
            $this->code[] = self::MATCH;
        }
    }

    /**
     * Метод для валидации результатов актуализации
     *
     * @param InsuranceActualizeRS $transferActualizeRS Сырая актуализация из поискового движка
     * @param int                  $actualizeId         Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function validateActualize(InsuranceActualizeRS $transferActualizeRS, int $actualizeId): void
    {
        $this->checkResults($transferActualizeRS, $actualizeId);
        $this->checkPrice($transferActualizeRS);
    }
}