<?php

namespace Api\Http\Requests\Cart;


use Api\Http\FillableRequests\Cart\BookingRQ;
use Api\Http\FillableRequests\Cart\Models\BookingInfo;
use Api\Http\FillableRequests\Cart\Models\BookingInfoExcursion;
use Api\Http\FillableRequests\Cart\Models\BookingTourist;
use Api\Http\FillableRequests\IFillableRQ;
use Api\Http\Requests\ValidateTrait;
use Illuminate\Foundation\Http\FormRequest;
use Onex\Engine2\components\HunterEngine;

/**
 * Class BookingRequest
 * Реквест для бронирования выбранных сервисов
 *
 * @package Api\Http\Requests\Cart
 */
class BookingRequest extends FormRequest
{
    use ValidateTrait;

    /**
     * Правила валидации реквеста для бронирования выбранных сервисов
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tourists' => 'required|array',
            'tourists.*.name' => 'required|string',
            'tourists.*.surname' => 'required|string',
            'tourists.*.middleName' => 'string',
            'tourists.*.email' => [$this->getRequiredRuleForEmail(), 'string'],
            'tourists.*.gender' => 'required|string|in:m,f',
            'tourists.*.birthday' => [$this->getRequiredRuleForBirthday(), 'date_format:"d.m.Y"'],
            'tourists.*.documentNumber' => [$this->getRequiredRuleForDocuments(), 'integer'],
            'tourists.*.documentType' => [$this->getRequiredRuleForDocuments(), 'string'],
            'tourists.*.expirationDate' => [$this->getRequiredRuleForDocuments(), 'date', 'after:yesterday'],
            'tourists.*.citizen' => [$this->getRequiredRuleForCitizen(), 'exists:countries,code'],
            'tourists.*.roomId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_HOTEL), 'string', 'nullable'
            ],
            'tourists.*.phone' => [$this->getRequiredRuleForPhone(), 'regex:/^\+\d{10,14}$/'],
            'tourists.*.id' => 'exists:ordersTourists,id|nullable',
            'tourists.*.visaId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_VISAS), 'string', 'nullable'
            ],
            'tourists.*.variantId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_VISAS), 'string', 'nullable'
            ],

            'orderId' => 'integer|exists:orders,id|nullable',
            'app' => 'string|exists:apiApps,name',
            'services' => 'required|array',
            'services.*' => 'present|exists:services,id|nullable',

            'bookingInfo' => 'required|array',

            'bookingInfo.accommodationSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_HOTEL), 'string', 'nullable'
            ],

            'bookingInfo.insuranceSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],
            'bookingInfo.insuranceResultId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],
            'bookingInfo.sumPerPerson' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],
            'bookingInfo.currency' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_INSURANCES), 'string', 'nullable'
            ],

            'bookingInfo.flightCode' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],
            'bookingInfo.flightNumber' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],
            'bookingInfo.returnFlightCode' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
            ],
            'bookingInfo.returnFlightNumber' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_TRANSFER), 'string', 'nullable'
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

            'bookingInfo.adults' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_EXCURSIONS), 'string', 'nullable'
            ],
            'bookingInfo.children' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_EXCURSIONS), 'string', 'nullable'
            ],
            'bookingInfo.meetingPlace' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_EXCURSIONS), 'string', 'nullable'
            ],
            'bookingInfo.excursionSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_EXCURSIONS), 'string', 'nullable'
            ],
            'bookingInfo.excursions' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_EXCURSIONS), 'array', 'nullable'
            ],
            'bookingInfo.excursions.*' => 'array',
            'bookingInfo.excursions.*.excursionId' => 'string|nullable',
            'bookingInfo.excursions.*.date' => 'date_format:"d.m.Y"|after:yesterday|nullable',
            'bookingInfo.excursions.*.time' => 'string|nullable',

            'bookingInfo.aviaSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_AVIATICKETS), 'string', 'nullable'
            ],
            'bookingInfo.recommendationId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_AVIATICKETS), 'string', 'nullable'
            ],

            'bookingInfo.visaSearchId' => [
                $this->getRequiredRuleOnService(HunterEngine::TYPE_VISAS), 'string', 'nullable'
            ],

            'bookingInfo.startDate' => 'present|date_format:d.m.Y|after:yesterday|nullable',
            'bookingInfo.endDate' => 'present|date_format:d.m.Y|after:bookingInfo.startDate|nullable'
        ];
    }

    /**
     * @param BookingRQ $request
     * @return BookingRQ
     */
    public function fillRequest(BookingRQ $request): BookingRQ
    {
        $bookingTourists = $this->fillBookingTourists();
        $bookingInfo = $this->fillBookingInfo();

        return $request
            ->setApp($this->input('app'))
            ->setOrderId($this->input('orderId'))
            ->setServices($this->input('services'))
            ->setTourists($bookingTourists)
            ->setBookingInfo($bookingInfo);
    }


    /**
     * @return array
     */
    private function fillBookingTourists(): array
    {
        $bookingTourists = [];
        foreach ($this->input('tourists') as $tourist) {
            $bookingTourist = new BookingTourist();
            $bookingTourist
                ->setName($tourist['name'])
                ->setMiddleName($tourist['middleName'] ?? null)
                ->setSurname($tourist['surname'])
                ->setGender($tourist['gender'])
                ->setBirthday($tourist['birthday'] ?? null)
                ->setDocumentNumber($tourist['documentNumber'] ?? null)
                ->setDocumentType($tourist['documentType'] ?? null)
                ->setEmail($tourist['email'] ?? null)
                ->setCitizen($tourist['citizen'] ?? null)
                ->setRoomId($tourist['roomId'] ?? null)
                ->setPhone($tourist['phone'] ?? null)
                ->setId($tourist['id'] ?? null)
                ->setExpirationDate($tourist['expirationDate'] ?? null)
                ->setVisaId($tourist['visaId'] ?? null)
                ->setVariantId($tourist['variantId'] ?? null);
            $bookingTourists[] = $bookingTourist;
        }
        return $bookingTourists;
    }

    /**
     * @return BookingInfo
     */
    private function fillBookingInfo(): BookingInfo
    {
        $bookingExcursions = $this->fillBookingExcursions();
        $bookingInfo = new BookingInfo();
        $bookingInfo
            ->setAccommodationSearchId($this->input('bookingInfo.accommodationSearchId'))
            ->setInsuranceSearchId($this->input('bookingInfo.insuranceSearchId'))
            ->setInsuranceResultId($this->input('bookingInfo.insuranceResultId'))
            ->setSumPerPerson($this->input('bookingInfo.sumPerPerson'))
            ->setCurrency($this->input('bookingInfo.currency'))
            ->setFlightCode($this->input('bookingInfo.flightCode'))
            ->setFlightNumber($this->input('bookingInfo.flightNumber'))
            ->setReturnFlightCode($this->input('bookingInfo.returnFlightCode'))
            ->setReturnFlightNumber($this->input('bookingInfo.returnFlightNumber'))
            ->setTransferSearchId($this->input('bookingInfo.transferSearchId'))
            ->setTransferId($this->input('bookingInfo.transferId'))
            ->setVehicleId($this->input('bookingInfo.vehicleId'))
            ->setAdults($this->input('bookingInfo.adults'))
            ->setChildren($this->input('bookingInfo.children'))
            ->setMeetingPlace($this->input('bookingInfo.meetingPlace'))
            ->setExcursionSearchId($this->input('bookingInfo.excursionSearchId'))
            ->setExcursions($bookingExcursions)
            ->setFlightSearchId($this->input('bookingInfo.aviaSearchId'))
            ->setRecommendationId($this->input('bookingInfo.recommendationId'))
            ->setVisaSearchId($this->input('bookingInfo.visaSearchId'))
            ->setStartDate($this->input('bookingInfo.startDate'))
            ->setEndDate($this->input('bookingInfo.endDate'));
        return $bookingInfo;
    }

    /**
     * @return array
     */
    private function fillBookingExcursions(): array
    {
        $excursions = $this->input('bookingInfo.excursions') ?? [];
        $bookingExcursions = [];
        foreach ($excursions as $excursion) {
            $bookingExcursion = new BookingInfoExcursion();
            $bookingExcursion
                ->setExcursionId($excursion['excursionId'])
                ->setDate($excursion['date'])
                ->setTime($excursion['time']);
            $bookingExcursions[] = $bookingExcursion;
        }

        return $bookingExcursions;
    }

    /**
     * Возвращает правило обязательного заполнения дня рождения
     *
     * @return string
     */
    private function getRequiredRuleForBirthday()
    {
        $requireFor = [
            HunterEngine::TYPE_TRANSFER,
            HunterEngine::TYPE_CARS,
            HunterEngine::TYPE_AVIATICKETS,
            HunterEngine::TYPE_EXCURSIONS,
            HunterEngine::TYPE_VISAS,
            HunterEngine::TYPE_INSURANCES,
        ];
        $result = array_diff($requireFor, request('services'));
        if (count($requireFor) != count($result)) {
            return 'required';
        }

        return '';
    }

    /**
     * Возвращает правило обязательного заполнения документов
     *
     * @return string
     */
    private function getRequiredRuleForDocuments()
    {
        $requireFor = [
            HunterEngine::TYPE_AVIATICKETS,
            HunterEngine::TYPE_VISAS,
            HunterEngine::TYPE_INSURANCES,
        ];
        $result = array_diff($requireFor, request('services'));
        if (count($requireFor) != count($result)) {
            return 'required';
        }

        return '';
    }

    /**
     * Возвращает правило обязательного заполнения гражданства
     *
     * @return string
     */
    private function getRequiredRuleForCitizen()
    {
        $requireFor = [
            HunterEngine::TYPE_AVIATICKETS,
            HunterEngine::TYPE_VISAS,
        ];
        $result = array_diff($requireFor, request('services'));
        if (count($requireFor) != count($result)) {
            return 'required';
        }

        return '';
    }

    /**
     * Возвращает правило обязательного заполнения email
     *
     * @return string
     */
    private function getRequiredRuleForEmail()
    {
        $requireFor = [
            HunterEngine::TYPE_AVIATICKETS,
        ];
        $result = array_diff($requireFor, request('services'));
        if (count($requireFor) != count($result)) {
            return 'required';
        }

        return '';
    }

    /**
     * Возвращает правило обязательного заполнения номера телефона
     *
     * @return string
     */
    private function getRequiredRuleForPhone()
    {
        $requireFor = [
            HunterEngine::TYPE_AVIATICKETS,
            HunterEngine::TYPE_TRANSFER,
            HunterEngine::TYPE_CARS,
            HunterEngine::TYPE_EXCURSIONS,
        ];
        $result = array_diff($requireFor, request('services'));
        if (count($requireFor) != count($result)) {
            return 'required';
        }

        return '';
    }
}
