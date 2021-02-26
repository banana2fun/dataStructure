<?php

namespace Api\Http\Responses\Cart;

/**
 * Class ImportantInfoResponse
 * Класс с важной информацией по отелю для отдачи на фронт
 * @package Api\Http\Responses\Cart
 */
class ImportantInfoResponse
{
    /** @var array Массив с ремарками */
    public $remarks = [];

    /** @var string Дополнительная информация */
    public $additionalInfo;

    /** @var array Массив с важной информацией */
    public $importantInfo = [];
}