<?php

namespace Api\Services\Cart\Actualize;

use Api\Models\Cart\Actualize\ApiActualize;
use IAPIActualize;

/**
 * Class ServiceActualize
 * Абстрактный клас для актуализации услуг
 *
 * @package Api\Services\Cart\Actualize
 */
abstract class ServiceActualize
{
    protected $apiService;
    protected $actualize;

    /**
     * ServiceActualize constructor.
     *
     * @param IAPIActualize $apiService
     * @param ApiActualize  $actualize
     */
    public function __construct(IAPIActualize $apiService, ApiActualize $actualize)
    {
        $this->apiService = $apiService;
        $this->actualize = $actualize;
    }
}