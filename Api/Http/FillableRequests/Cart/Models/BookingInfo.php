<?php

namespace Api\Http\FillableRequests\Cart\Models;

/**
 * Class BookingInfo
 * Класс с информацией для бронирования
 *
 * @package Api\Http\FillableRequests\Cart\Models
 */
class BookingInfo
{
    /** @var string id поиска размещений*/
    public $accommodationSearchId;

    /** @var string id поиска страховок*/
    public $insuranceSearchId;
    /** @var string id страховки*/
    public $insuranceResultId;
    /** @var int сумма на человека*/
    public $sumPerPerson;
    /** @var string Валюта суммы*/
    public $currency;

    /** @var string Код авиаперелёта для трансфера туда*/
    public $flightCode;
    /** @var int Номер авиаперелёта для трансфера туда*/
    public $flightNumber;
    /** @var string Код авиаперелёта для трансфера обратно*/
    public $returnFlightCode;
    /** @var int Номер авиаперелёта для трансфера обратно*/
    public $returnFlightNumber;
    /** @var string id поиска трансферов*/
    public $transferSearchId;
    /** @var string id траснсфера*/
    public $transferId;
    /** @var string id машины*/
    public $vehicleId;

    /** @var int Количесвто взрослых*/
    public $adults;
    /** @var int Количество детей*/
    public $children;
    /** @var string Место встречи*/
    public $meetingPlace;
    /** @var string Id поиска экскурсий*/
    public $excursionSearchId;
    /** @var BookingInfoExcursion[] Массив с экскурсиями*/
    public $excursions = [];

    /** @var string id поиска авиа*/
    public $flightSearchId;
    /** @var string id перелёта*/
    public $recommendationId;
    
    /** @var string id поиска виз*/
    public $visaSearchId;
    /** @var string Дата начала поездки*/
    public $startDate;
    /** @var string Дата окончания поездки*/
    public $endDate;

    /**
     * @return string|null
     */
    public function getAccommodationSearchId(): ?string
    {
        return $this->accommodationSearchId;
    }

    /**
     * @param string|null $accommodationSearchId
     * @return BookingInfo
     */
    public function setAccommodationSearchId(?string $accommodationSearchId): self
    {
        $this->accommodationSearchId = $accommodationSearchId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInsuranceSearchId(): ?string
    {
        return $this->insuranceSearchId;
    }

    /**
     * @param string|null $insuranceSearchId
     * @return BookingInfo
     */
    public function setInsuranceSearchId(?string $insuranceSearchId): self
    {
        $this->insuranceSearchId = $insuranceSearchId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInsuranceResultId(): ?string
    {
        return $this->insuranceResultId;
    }

    /**
     * @param string|null $insuranceResultId
     * @return BookingInfo
     */
    public function setInsuranceResultId(?string $insuranceResultId): self
    {
        $this->insuranceResultId = $insuranceResultId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSumPerPerson(): ?int
    {
        return $this->sumPerPerson;
    }

    /**
     * @param int|null $sumPerPerson
     * @return BookingInfo
     */
    public function setSumPerPerson(?int $sumPerPerson): self
    {
        $this->sumPerPerson = $sumPerPerson;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     * @return BookingInfo
     */
    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFlightCode(): ?string
    {
        return $this->flightCode;
    }

    /**
     * @param string|null $flightCode
     * @return BookingInfo
     */
    public function setFlightCode(?string $flightCode): self
    {
        $this->flightCode = $flightCode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFlightNumber(): ?int
    {
        return $this->flightNumber;
    }

    /**
     * @param int|null $flightNumber
     * @return BookingInfo
     */
    public function setFlightNumber(?int $flightNumber): self
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnFlightCode(): ?string
    {
        return $this->returnFlightCode;
    }

    /**
     * @param string|null $returnFlightCode
     * @return BookingInfo
     */
    public function setReturnFlightCode(?string $returnFlightCode): self
    {
        $this->returnFlightCode = $returnFlightCode;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getReturnFlightNumber(): ?int
    {
        return $this->returnFlightNumber;
    }

    /**
     * @param int|null $returnFlightNumber
     * @return BookingInfo
     */
    public function setReturnFlightNumber(?int $returnFlightNumber): self
    {
        $this->returnFlightNumber = $returnFlightNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransferSearchId(): ?string
    {
        return $this->transferSearchId;
    }

    /**
     * @param string|null $transferSearchId
     * @return BookingInfo
     */
    public function setTransferSearchId(?string $transferSearchId): self
    {
        $this->transferSearchId = $transferSearchId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransferId(): ?string
    {
        return $this->transferId;
    }

    /**
     * @param string|null $transferId
     * @return BookingInfo
     */
    public function setTransferId(?string $transferId): self
    {
        $this->transferId = $transferId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVehicleId(): ?string
    {
        return $this->vehicleId;
    }

    /**
     * @param string|null $vehicleId
     * @return BookingInfo
     */
    public function setVehicleId(?string $vehicleId): self
    {
        $this->vehicleId = $vehicleId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAdults(): ?int
    {
        return $this->adults;
    }

    /**
     * @param int|null $adults
     * @return BookingInfo
     */
    public function setAdults(?int $adults): self
    {
        $this->adults = $adults;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getChildren(): ?int
    {
        return $this->children;
    }

    /**
     * @param int|null $children
     * @return BookingInfo
     */
    public function setChildren(?int $children): self
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMeetingPlace(): ?string
    {
        return $this->meetingPlace;
    }

    /**
     * @param string|null $meetingPlace
     * @return BookingInfo
     */
    public function setMeetingPlace(?string $meetingPlace): self
    {
        $this->meetingPlace = $meetingPlace;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExcursionSearchId(): ?string
    {
        return $this->excursionSearchId;
    }

    /**
     * @param string|null $excursionSearchId
     * @return BookingInfo
     */
    public function setExcursionSearchId(?string $excursionSearchId): self
    {
        $this->excursionSearchId = $excursionSearchId;
        return $this;
    }

    /**
     * @return BookingInfoExcursion[]|null
     */
    public function getExcursions(): ?array
    {
        return $this->excursions;
    }

    /**
     * @param BookingInfoExcursion[]|null $excursions
     * @return BookingInfo
     */
    public function setExcursions(?array $excursions): self
    {
        $this->excursions = $excursions;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFlightSearchId(): ?string
    {
        return $this->flightSearchId;
    }

    /**
     * @param string|null $flightSearchId
     * @return BookingInfo
     */
    public function setFlightSearchId(?string $flightSearchId): self
    {
        $this->flightSearchId = $flightSearchId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRecommendationId(): ?string
    {
        return $this->recommendationId;
    }

    /**
     * @param string|null $recommendationId
     * @return BookingInfo
     */
    public function setRecommendationId(?string $recommendationId): self
    {
        $this->recommendationId = $recommendationId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVisaSearchId(): ?string
    {
        return $this->visaSearchId;
    }

    /**
     * @param string|null $visaSearchId
     * @return BookingInfo
     */
    public function setVisaSearchId(?string $visaSearchId): self
    {
        $this->visaSearchId = $visaSearchId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @param string|null $startDate
     * @return BookingInfo
     */
    public function setStartDate(?string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @param string|null $endDate
     * @return BookingInfo
     */
    public function setEndDate(?string $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}