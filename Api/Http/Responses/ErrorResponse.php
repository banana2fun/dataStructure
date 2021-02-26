<?php

namespace Api\Http\Responses;

/**
 * Class ErrorResponse
 * Класс базового элемента массива errors в нашем RS
 * @package Api\Http\Responses
 */
class ErrorResponse
{
    public $source;

    public $code;

    public $title;

    public $detail;

    /**
     * ErrorResponse constructor.
     * @param string $source Источник ошибки
     * @param int $code Код ответа Http
     * @param string $title Заголовок ошибки
     * @param string $detail Детальное описание ошибки
     */
    public function __construct(string $source, int $code, string $title, string $detail)
    {
        $this->source = $source;
        $this->code = $code;
        $this->title = $title;
        $this->detail = $detail;
    }
}