<?php

namespace Api\Http\Responses\Cart;

use Api\Http\Responses\ErrorResponse;

/**
 * Class ActualizeErrorResponse
 * Класс для ответа с ошибками актуализации
 * @package Api\Http\Responses\Cart
 */
class ActualizeErrorResponse extends ErrorResponse
{
    /** @var int Id актуализации */
    public $actualizeId = 1;
}