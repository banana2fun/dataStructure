<?php

namespace Api\Http\Requests\Cart;

use Api\Http\FillableRequests\Cart\ActualizeRQ;
use Api\Http\FillableRequests\Cart\Models\FlightActualizeData;
use Api\Http\FillableRequests\Cart\Models\HotelActualizeData;
use Api\Http\FillableRequests\Cart\Models\InsuranceActualizeData;
use Api\Http\FillableRequests\Cart\Models\TransferActualizeData;
use Api\Http\Requests\ValidateTrait;
use Illuminate\Foundation\Http\FormRequest;
use Onex\Engine2\components\HunterEngine;

/**
 * Class BookingActualizeRequest
 * Реквест для актуализации корзины
 * @package Api\Http\Requests\Cart
 */
class BookingActualizeRequest extends FormRequest
{
    use ValidateTrait;

    /**
     * Правила валидации реквеста для актуализации при бронировании
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'services' => 'required|array',
            'services.*' => 'present|exists:services,id|nullable',

            'bookingInfo' => 'required|array',

            'bookingInfo.accommodationSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_HOTEL), 'string', 'nullable'
            ],
            'bookingInfo.hotelId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_HOTEL), 'integer', 'nullable'
            ],
            'bookingInfo.accommodationId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_HOTEL), 'string', 'nullable'
            ],

            'bookingInfo.insuranceSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],
            'bookingInfo.insuranceResultId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],

            'bookingInfo.transferSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],
            'bookingInfo.transferId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],
            'bookingInfo.vehicleId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],

            'bookingInfo.aviaSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_AVIATICKETS), 'string', 'nullable'
            ],
            'bookingInfo.recommendationId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_AVIATICKETS), 'string', 'nullable'
            ]
        ];
    }

    /**
     * @param ActualizeRQ $request
     * @return ActualizeRQ
     */
    public function fillRequest(ActualizeRQ $request): ActualizeRQ
    {
        return $request
            ->setActualizeId($this->input('actualizeId'))
            ->setCurrency($this->input('currency'))
            ->setServices($this->input('services'))
            ->setHotelData($this->fillHotelData())
            ->setInsuranceData($this->fillInsuranceData())
            ->setTransferData($this->fillTransferData())
            ->setAirFlightData($this->fillFlightData());
    }

    /**
     * @return HotelActualizeData
     */
    private function fillHotelData(): HotelActualizeData
    {
        $hotelData = new HotelActualizeData();
        $hotelData
            ->setAccommodationId($this->input('bookingInfo.accommodationId'))
            ->setHotelId($this->input('bookingInfo.hotelId'))
            ->setSearchId($this->input('bookingInfo.accommodationSearchId'));
        return $hotelData;
    }

    /**
     * @return InsuranceActualizeData
     */
    private function fillInsuranceData(): InsuranceActualizeData
    {
        $insuranceData = new InsuranceActualizeData();
        $insuranceData
            ->setResultId($this->input('bookingInfo.insuranceResultId'))
            ->setSearchId($this->input('bookingInfo.insuranceSearchId'));
        return $insuranceData;
    }

    /**
     * @return TransferActualizeData
     */
    private function fillTransferData(): TransferActualizeData
    {
        $transferData = new TransferActualizeData();
        $transferData
            ->setVehicleId($this->input('bookingInfo.vehicleId'))
            ->setTransferId($this->input('bookingInfo.transferId'))
            ->setSearchId($this->input('bookingInfo.transferSearchId'));
        return $transferData;
    }

    /**
     * @return FlightActualizeData
     */
    private function fillFlightData(): FlightActualizeData
    {
        $flightData = new FlightActualizeData();
        $flightData
            ->setRecommendationId($this->input('bookingInfo.recommendationId'))
            ->setSearchId($this->input('bookingInfo.aviaSearchId'));
        return $flightData;
    }
}
