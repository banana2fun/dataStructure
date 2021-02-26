<?php

namespace Api\Models;

/**
 * Class ApiPrice
 * Клас с ценой, наценкой и валютой
 *
 * @package Api\Models
 */
class ApiPrice
{
    /** @var int Стоимость */
    public $amount = 0;

    /** @var int Наценка */
    public $markup = 0;

    /** @var string Валюта */
    public $currency;

    /**
     * ApiHotelPrice constructor.
     *
     * @param float  $amount   Стоимость
     * @param float  $markup   Наценка
     * @param string $currency Валюта
     */
    public function __construct(float $amount, ?float $markup, string $currency)
    {
        $this->amount = ceil($amount) ?? 0;
        $this->markup = ceil($markup) ?? 0;
        $this->currency = $currency;
    }
}