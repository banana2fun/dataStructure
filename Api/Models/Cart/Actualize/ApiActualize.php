<?php

namespace Api\Models\Cart\Actualize;

use ActualizeRS;
use Api\Exceptions\Cart\ActualizeException;
use Api\Models\ApiPrice;

/**
 * Class ApiActualize
 * Базовый класс для ответа актуализации
 *
 * @package Api\Models\Cart\Actualize
 */
abstract class ApiActualize
{
    protected const MATCH = 'match';
    protected const PRICE_CHANGE = 'price_change';

    /** @var ApiPrice Цена, наценка и валюта */
    public $price;
    /** @var array Массив с кодами ошибок */
    public $code = [];
    /** @var array Массив с текстами ошибок */
    public $errors = [];
    /** @var int id сервиса*/
    protected $serviceId;

    /**
     * ApiActualize constructor.
     *
     * @param int $serviceId
     */
    public function __construct(int $serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * Проверяет наличие результатов в ответе актуализации
     *
     * @param ActualizeRS $actualizeRS Сырая актуализация из поискового движка
     * @param int         $actualizeId Id актуализации
     * @return void
     * @throws ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function checkResults(ActualizeRS $actualizeRS, int $actualizeId): void
    {
        if (!$actualizeRS->result || !$actualizeRS->previousResult) {
            throw new ActualizeException(
                $actualizeId,
                $this->serviceId,
                'Остутствуют результаты в ответе актуализации'
            );
        }
    }

    /**
     * Проверяет соответсвие цен
     *
     * @param ActualizeRS $actualizeRS Сырая актуализация из поискового движка
     * @return void
     */
    protected function checkPrice(ActualizeRS $actualizeRS): void
    {
        if (ceil($actualizeRS->result->price) !== ceil($actualizeRS->previousResult->price)) {
            $newPrice = ceil($actualizeRS->result->price);
            $currency = $actualizeRS->result->currency;
            $this->errors[] = transoe('actualizePriceChange') . $newPrice . ' ' . $currency;
            $this->code[] = self::PRICE_CHANGE;
        }
    }
}