<?php

namespace Api\Http\Requests\Cart;

use Api\Http\FillableRequests\Cart\ActualizeRQ;
use Api\Http\FillableRequests\Cart\Models\FlightActualizeData;
use Api\Http\FillableRequests\Cart\Models\HotelActualizeData;
use Api\Http\FillableRequests\Cart\Models\InsuranceActualizeData;
use Api\Http\FillableRequests\Cart\Models\TransferActualizeData;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ActualizeRequest
 * Реквест для актуализации корзины
 *
 * @package Api\Http\Requests\Cart
 */
class ActualizeRequest extends FormRequest
{
    /**
     * Правила валидации реквеста для актуализации корзины
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'actualizeId' => 'integer|gte:0',
            'currency' => 'string|exists:currencies,code',
            'services' => 'required|array',
            'services.*' => 'exists:services,id|nullable',

            'accommodationSearchId' => 'required_with:hotelId,accommodationId|string|nullable',
            'hotelId' => 'required_with:accommodationId,accommodationSearchId|exists:hotels,id|nullable',
            'accommodationId' => 'required_with:accommodationSearchId,hotelId|string|nullable',

            'insuranceSearchId' => 'required_with:insuranceResultId|string|nullable',
            'insuranceResultId' => 'required_with:insuranceSearchId|string|nullable',

            'transferSearchId' => 'required_with:transferId,vehicleId|string|nullable',
            'transferId' => 'required_with:transferSearchId,vehicleId|string|nullable',
            'vehicleId' => 'required_with:transferSearchId,transferId|string|nullable',

            'aviaSearchId' => 'required_with:recommendationId|string|nullable',
            'recommendationId' => 'required_with:aviaSearchId|string|nullable'
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
            ->setAccommodationId($this->input('accommodationId'))
            ->setHotelId($this->input('hotelId'))
            ->setSearchId($this->input('accommodationSearchId'));
        return $hotelData;
    }

    /**
     * @return InsuranceActualizeData
     */
    private function fillInsuranceData(): InsuranceActualizeData
    {
        $insuranceData = new InsuranceActualizeData();
        $insuranceData
            ->setResultId($this->input('insuranceResultId'))
            ->setSearchId($this->input('insuranceSearchId'));
        return $insuranceData;
    }

    /**
     * @return TransferActualizeData
     */
    private function fillTransferData(): TransferActualizeData
    {
        $transferData = new TransferActualizeData();
        $transferData
            ->setVehicleId($this->input('vehicleId'))
            ->setTransferId($this->input('transferId'))
            ->setSearchId($this->input('transferSearchId'));
        return $transferData;
    }

    /**
     * @return FlightActualizeData
     */
    private function fillFlightData(): FlightActualizeData
    {
        $flightData = new FlightActualizeData();
        $flightData
            ->setRecommendationId($this->input('recommendationId'))
            ->setSearchId($this->input('aviaSearchId'));
        return $flightData;
    }
}
