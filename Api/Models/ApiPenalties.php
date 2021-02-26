<?php

namespace Api\Models;

use HunterEngine;

/**
 * Class ApiPenalties
 * Класс с штрафными санкциями
 *
 * @package Api\Models
 */
class ApiPenalties
{
    /** @var int Время наступления штрафной санкции */
    public $from;

    /** @var int Время окончания штрафной санкции */
    public $to;

    /** @var string Штрафное действие */
    public $action;

    /** @var ApiPrice Цена, наценка и валюта */
    public $price;

    public function __construct(string $action)
    {
        switch ($action) {
            case HunterEngine::ACTION_MODIFY:
                $this->action = 'Изменение';
                break;
            case HunterEngine::ACTION_CANCEL:
                $this->action = 'Отмена';
                break;
            case HunterEngine::ACTION_BOOKING:
                $this->action = 'Бронирование';
                break;
            case HunterEngine::ACTION_CHECK:
                $this->action = 'Проверка';
                break;
        }
    }
}