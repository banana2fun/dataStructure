<?php

namespace Api\Exceptions\Cart;

use Api\Exceptions\ApiException;
use Api\Helper\ApiStatusCode;
use Api\Http\Resources\Cart\ActualizeErrorResource;
use Api\Http\Responses\Cart\ActualizeErrorResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Onex\DBPackage\Factories\RepositoryFactory;

/**
 * Class ActualizeException
 * Базовый класс ошибок актуализации для api
 *
 * @package Api\Exceptions\Cart
 */
class ActualizeException extends ApiException
{
    /** @var string источник ошибки */
    protected $source = 'actualize';

    /** @var string Заголовок ошибки */
    protected $title = 'Ошибка актуализации';

    /** @var int Код ответа */
    protected $code = ApiStatusCode::ACTUALIZE_ERROR;

    /** @var int Id актуализации */
    protected $actualizeId = 1;

    /**
     * ActualizeException constructor.
     *
     * @param int    $actualizeId
     * @param int    $serviceId
     * @param string $message
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(int $actualizeId, int $serviceId, string $message)
    {
        parent::__construct($message);
        $this->actualizeId = $actualizeId;
        $servicesRepo = RepositoryFactory::makeServicesRepo();
        $service = $servicesRepo->getByIdNS($serviceId);
        $this->source = $service->code;
    }

    /**
     * @return int
     */
    public function getActualizeId(): int
    {
        return $this->actualizeId;
    }

    /**
     * Отправляет ответ с текстом ошибки на фронт
     *
     * @return JsonResource
     */
    public function render(): JsonResource
    {
        $error = new ActualizeErrorResponse($this->getSource(), $this->getCode(), $this->getTitle(), $this->getMessage());
        $error->actualizeId = $this->actualizeId;
        return new ActualizeErrorResource($error);
    }
}