<?php

namespace Api\Factories;

use Api\Services\Cart\Booking\IBookingService;
use Api\Services\Interfaces\Helper\IRatesServices;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ApiServicesFactory
 * Фабрика для создания сервисов API приложения
 *
 * @package Api\Factories
 */
class ApiServicesFactory
{
    /**
     * @return IRatesServices
     * @throws BindingResolutionException
     */
    public static function makeRatesService(): IRatesServices
    {
        return app()->make(IRatesServices::class);
    }

    /**
     * @param int $serviceId
     * @return IBookingService
     */
    public static function makeBookingServices(int $serviceId): IBookingService
    {
        return app()->makeWith(IBookingService::class, ['serviceId' => $serviceId]);
    }
}
