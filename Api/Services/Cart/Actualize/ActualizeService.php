<?php

namespace Api\Services\Cart\Actualize;

use Api\Exceptions\Cart\{ActualizeCriticalException, ActualizeException};
use Api\Factories\APIServicesActualizeFactory;
use Api\Http\FillableRequests\Cart\ActualizeRQ;
use Api\Http\Responses\Cart\ActualizeResponse;
use Exception;

/**
 * Class ActualizeService сервис для CartController
 * Класс сервис для актуализации корзины
 *
 * @package Api\Services\Cart\Actualize
 */
class ActualizeService
{
    /** @var ActualizeResponse  */
    private $response;

    /**
     * ActualizeService constructor.
     *
     * @param ActualizeResponse $response
     */
    public function __construct(ActualizeResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Общий метод для актуализации
     *
     * @param ActualizeRQ $actualizeRQ
     * @return ActualizeResponse
     * @throws ActualizeCriticalException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws ActualizeException
     */
    public function actualize(ActualizeRQ $actualizeRQ): ActualizeResponse
    {
        foreach ($actualizeRQ->getServices() as $serviceId) {
            try {
                $service = APIServicesActualizeFactory::makeActualizeServices((int)$serviceId);
                $service->actualize($this->response, $actualizeRQ);
            } catch (ActualizeException $e) {
                throw new ActualizeException($e->getActualizeId(), $serviceId, $e->getMessage());
            } catch (Exception $e) {
                throw new ActualizeCriticalException(
                    $actualizeRQ->getActualizeId(),
                    $serviceId,
                    'Внимание! Предложение более недоступно, необходимо повторить поиск'
                );
            }
        }
        $this->response->setStatusCode();
        return $this->response;
    }
}
