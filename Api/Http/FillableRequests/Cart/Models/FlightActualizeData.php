<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class FlightActualizeData
 * Информация для акутализации авиа
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class FlightActualizeData extends ActualizeData
{
    /** @var string */
    public $recommendationId;

    /**
     * @return string|null
     */
    public function getRecommendationId(): ?string
    {
        return $this->recommendationId;
    }

    /**
     * @param string|null $recommendationId
     * @return FlightActualizeData
     */
    public function setRecommendationId(?string $recommendationId): self
    {
        $this->recommendationId = $recommendationId;
        return $this;
    }
}