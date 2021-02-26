<?php

namespace Api\Factories;

use Api\Models\Cart\Actualize\ApiActualize;
use Api\Services\Cart\Actualize\IActualizeService;
use IAPIActualize;

/**
 * Class APIServicesActualizeFactory
 * Фабрика для актуализации
 *
 * @package Api\Factories
 */
class APIServicesActualizeFactory
{
    /**
     * @param int $serviceId
     * @return IActualizeService
     */
    public static function makeActualizeServices(int $serviceId): IActualizeService
    {
        $apiService = self::makeApiServiceWhitActualize($serviceId);
        $actualizeClass = self::makeActualizeClass($serviceId);
        return app()->makeWith(IActualizeService::class, [
            'serviceId' => $serviceId,
            'apiService' => $apiService,
            'actualizeClass' => $actualizeClass
        ]);
    }

    /**
     * @param int $serviceId
     * @return IAPIActualize
     */
    public static function makeApiServiceWhitActualize(int $serviceId): IAPIActualize
    {
        return app()->makeWith(IAPIActualize::class, ['serviceId' => $serviceId]);
    }

    /**
     * @param int $serviceId
     * @return ApiActualize
     */
    public static function makeActualizeClass(int $serviceId): ApiActualize
    {
        return app()->makeWith(ApiActualize::class, ['serviceId' => $serviceId]);
    }
}