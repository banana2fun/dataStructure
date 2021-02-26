<?php

namespace Api\Exceptions;

use Api\Http\Resources\ErrorResource;
use Api\Http\Responses\ErrorResponse;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ApiException
 * Базовый класс исключений для api
 *
 * @package Api\Exceptions
 */
class ApiException extends Exception
{
    /** @var string источник ошибки */
    protected $source;

    /** @var string Заголовок ошибки */
    protected $title;

    /**
     * Отправляет ответ с текстом ошибки на фронт
     *
     * @return JsonResource
     */
    public function render(): JsonResource
    {
        $error = new ErrorResponse($this->getSource(), $this->getCode(), $this->getTitle(), $this->getMessage());
        return new ErrorResource($error);
    }

    /**
     * Метод для получения источника ошибки
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Метод для получения заголовка ошибки
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
