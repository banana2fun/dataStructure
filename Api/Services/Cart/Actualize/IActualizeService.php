<?php

namespace Api\Services\Cart\Actualize;

use Api\Http\FillableRequests\Cart\ActualizeRQ;
use Api\Http\Responses\Cart\ActualizeResponse;

/**
 * Interface IActualizeService
 *
 * @package Api\Services\Cart\Actualize
 */
interface IActualizeService
{
    /**
     * Актуализируем предложение
     *
     * @param ActualizeResponse $response
     * @param ActualizeRQ       $actualizeRQ
     * @return void
     */
    public function actualize(ActualizeResponse $response, ActualizeRQ $actualizeRQ): void;
}