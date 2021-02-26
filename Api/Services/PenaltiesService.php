<?php

namespace Api\Services;

use Api\Models\{ApiPenalties, ApiPrice};
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class PenaltiesService
 * Базовый класс-сервис для штрафов
 *
 * @package Api\Services\Cart
 */
class PenaltiesService
{
    private $response;

    /**
     * PenaltiesService constructor.
     *
     * @param Collection $response
     */
    public function __construct(Collection $response)
    {
        $this->response = $response;
    }

    /**
     * Формирет ответ на фронт по штрафам отеля
     *
     * @param array $results Массив с штрафами по отелю
     * @return Collection
     */
    public function createPenaltiesResponse(array $results): Collection
    {
        foreach ($results as $result) {
            $penalty = new ApiPenalties($result->action);
            $penalty->from = is_null($result->from) ? $result->from : Carbon::parse($result->from)->timestamp;
            $penalty->to = is_null($result->to) ? $result->to : Carbon::parse($result->to)->timestamp;
            $penalty->price = new ApiPrice($result->price, $result->markPrice, $result->currency);
            $this->response->add($penalty);
        }
        return $this->response;
    }
}