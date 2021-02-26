<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class ActualizeData
 * Общий класс для актуализации сервисов
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class ActualizeData
{
    /** @var string id поиска услуги*/
    public $searchId;

    /**
     * @return string|null
     */
    public function getSearchId(): ?string
    {
        return $this->searchId;
    }

    /**
     * @param string|null $searchId
     * @return ActualizeData
     */
    public function setSearchId(?string $searchId): self
    {
        $this->searchId = $searchId;
        return $this;
    }
}