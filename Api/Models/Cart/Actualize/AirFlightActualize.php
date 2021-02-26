<?php

namespace Api\Models\Cart\Actualize;

use Api\Models\ApiPrice;
use AviaticketActualizeRS;

/**
 * Class AirFlightActualize
 * Класс для актуализации страховки
 *
 * @package Api\Models\Cart\Actualize
 */
class AirFlightActualize extends ApiActualize
{
    /**
     * Обработка актуализации
     *
     * @param AviaticketActualizeRS $airFlightActualizeRS Сырая актуализация из поискового движка
     * @param int                   $actualizeId          Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleActualize(AviaticketActualizeRS $airFlightActualizeRS, int $actualizeId): void
    {
        $this->validateActualize($airFlightActualizeRS, $actualizeId);
        $this->price = new ApiPrice(
            $airFlightActualizeRS->result->price,
            $airFlightActualizeRS->result->markPrice,
            $airFlightActualizeRS->result->currency
        );
        if (empty($this->code)) {
            $this->code[] = self::MATCH;
        }
    }

    /**
     * Метод для валидации результатов актуализации
     *
     * @param AviaticketActualizeRS $airFlightActualizeRS Сырая актуализация из поискового движка
     * @param int                   $actualizeId          Id актуализации
     * @return void
     * @throws \Api\Exceptions\Cart\ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function validateActualize(AviaticketActualizeRS $airFlightActualizeRS, int $actualizeId): void
    {
        $this->checkResults($airFlightActualizeRS, $actualizeId);
        $this->checkPrice($airFlightActualizeRS);
    }
}