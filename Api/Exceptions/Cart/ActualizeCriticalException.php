<?php

namespace Api\Exceptions\Cart;

use Api\Helper\ApiStatusCode;

/**
 * Class ActualizeCriticalException
 * Исключение при критической ошибке актуализации
 *
 * @package Api\Exceptions\Cart
 */
class ActualizeCriticalException extends ActualizeException
{
    /** @var string Заголовок ошибки */
    protected $title = 'Критическая ошибка актуализации';

    /** @var int Код ответа */
    protected $code = ApiStatusCode::CRITICAL_ACTUALIZE_ERROR;
}