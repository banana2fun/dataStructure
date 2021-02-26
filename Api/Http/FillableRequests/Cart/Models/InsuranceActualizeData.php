<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class InsuranceActualizeData
 * Информация для акутализации страховок
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class InsuranceActualizeData extends ActualizeData
{
    /** @var string */
    public $resultId;

    /**
     * @return string|null
     */
    public function getResultId(): ?string
    {
        return $this->resultId;
    }

    /**
     * @param string|null $resultId
     * @return InsuranceActualizeData
     */
    public function setResultId(?string $resultId): self
    {
        $this->resultId = $resultId;
        return $this;
    }
}