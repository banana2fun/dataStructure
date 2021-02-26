<?php

namespace Api\Http\Responses\Cart;

use Api\Helper\ApiStatusCode;
use Api\Models\Cart\Actualize\{AirFlightActualize, HotelActualize, InsuranceActualize, TransferActualize};

/**
 * Class ActualizeResponse
 * Класс для отдачи результатов актуализации на фронт
 *
 * @package Api\Http\Responses\Cart
 */
class ActualizeResponse
{
    /** @var int Поле каунтер для фронта */
    public $actualizeId = 1;

    /** @var HotelActualize Информация об актуализации отелей */
    public $accommodation;

    /** @var TransferActualize Информация об актуализации трансферов */
    public $transfer;

    /** @var InsuranceActualize Информация об актуализации страховок */
    public $insurance;

    /** @var AirFlightActualize Информация об актуализации авиа */
    public $flight;

    /** @var array Сырая актуализация */
    public $rawActualize;

    /** @var int Статус код ответа */
    public $code = ApiStatusCode::SUCCESS;

    public function setStatusCode(): void
    {
        if (!empty($this->accommodation->errors)) {
            $this->code = ApiStatusCode::ACTUALIZE_CHANGE;
        } else {
            $this->accommodation = null;
        }
        if (!empty($this->transfer->errors)) {
            $this->code = ApiStatusCode::ACTUALIZE_CHANGE;
        } else {
            $this->transfer = null;
        }
        if (!empty($this->insurance->errors)) {
            $this->code = ApiStatusCode::ACTUALIZE_CHANGE;
        } else {
            $this->insurance = null;
        }
        if (!empty($this->flight->errors)) {
            $this->code = ApiStatusCode::ACTUALIZE_CHANGE;
        } else {
            $this->flight = null;
        }
    }
}