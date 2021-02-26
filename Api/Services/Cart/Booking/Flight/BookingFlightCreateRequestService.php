<?php

namespace Api\Services\Cart\Booking\Flight;

use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use AviaticketBookingRQ;
use AviaticketBookingTourist;
use AviaticketDocument;
use BookingCustomer;
use HunterEngine;
use Illuminate\Support\Carbon;
use Search;

/**
 * Class BookingFlightCreateRequestService
 * Сервис для формирования реквеста в движок бронирования авиа
 *
 * @package Api\Services\Cart\Booking\Flight
 */
class BookingFlightCreateRequestService extends BookingCreateRequestService
{
    /** @var AviaticketBookingRQ */
    private $request;
    /** @var BookingCustomer */
    private $customer;

    /**
     * BookingFlightCreateRequestService constructor.
     *
     * @param AviaticketBookingRQ $request
     * @param BookingCustomer     $customer
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AviaticketBookingRQ $request, BookingCustomer $customer)
    {
        parent::__construct();
        $this->request = $request;
        $this->customer = $customer;
    }

    /**
     * Получаем реквест
     *
     * @param BookingRQ $bookingRQ
     * @param array     $actualize
     * @return AviaticketBookingRQ
     */
    public function getRequest(BookingRQ $bookingRQ, array $actualize): AviaticketBookingRQ
    {
        $this->getTourists($bookingRQ);
        $this->fillRequest($bookingRQ, $actualize);

        return $this->request;
    }

    /**
     * Заполняем реквест
     *
     * @param BookingRQ $bookingRQ
     * @param array     $actualize
     * @return void
     */
    protected function fillRequest(BookingRQ $bookingRQ, array $actualize): void
    {
        $actualizeFlight = $actualize[HunterEngine::TYPE_AVIATICKETS];
        $bookingInfo = $bookingRQ->getBookingInfo();
        $this->request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
        $this->request->currency = $this->usersRepo->getUserCurrencyNS();
        $this->request->orderId = $bookingRQ->getOrderId() ?? '';
        $this->request->searchId = $bookingInfo->getFlightSearchId();
        $this->fillTourists($bookingRQ);
        $this->request->recommendationId = $bookingInfo->getRecommendationId();
        $this->request->actualizeCode = $actualizeFlight->actualizeCode;
        $this->fillCustomer($this->customer);
        $this->request->customer = $this->customer;
        $this->request->markup = 0;
        $this->request->markupType = 'A';
    }

    /**
     * Заполняем туристов
     *
     * @param BookingRQ $bookingRQ
     * @return void
     */
    protected function fillTourists(BookingRQ $bookingRQ): void
    {
        $lastFlightDate = $this->getLastFlightDate($bookingRQ);

        /** @var BookingTourist $tourist */
        foreach ($bookingRQ->getTourists() as $id => $tourist) {
            $this->request->tourists[$id] = new AviaticketBookingTourist();

            $this->request->tourists[$id]->name = $tourist->getName();
            $this->request->tourists[$id]->surname = $tourist->getSurname();
            $this->request->tourists[$id]->middleName = $tourist->getMiddleName();
            $this->request->tourists[$id]->gender = $tourist->getGender();
            $this->request->tourists[$id]->birthday = $tourist->getBirthday();

            $this->request->tourists[$id]->passportNumber = $tourist->getDocumentNumber();
            $this->request->tourists[$id]->passportValidity = Carbon::parse($tourist->getExpirationDate())->timestamp;
            $documentTypeId = $this->dicDocumentTypeRepo->getByCode($tourist->getDocumentType())->id;
            $this->request->tourists[$id]->documentTypeId = $documentTypeId;

            $this->request->tourists[$id]->phone = $tourist->getPhone();
            $this->request->tourists[$id]->email = $tourist->getEmail();
            $this->request->tourists[$id]->touristId = $tourist->getId() ?? '';
            $this->request->tourists[$id]->countryId = $tourist->getCitizen();

            $this->fillAviaticketDocument($id, $tourist);
            $this->request->tourists[$id]->passengerCategory = $this->getPassengerCategory($tourist, $lastFlightDate);
        }
    }

    /**
     * Вычисляем дату последнего перелёта
     *
     * @param BookingRQ $bookingRQ
     * @return Carbon
     */
    protected function getLastFlightDate(BookingRQ $bookingRQ): Carbon
    {
        $search = Search::readFromRedis($bookingRQ->getBookingInfo()->getFlightSearchId());
        $lastFlightDate = collect($search->request->routes)->pluck('date')->max();
        return Carbon::parse($lastFlightDate);
    }

    /**
     * Заполняем авиадокументы
     *
     * @param int            $id
     * @param BookingTourist $tourist
     * @return void
     */
    protected function fillAviaticketDocument(int $id, BookingTourist $tourist): void
    {
        $this->request->tourists[$id]->document = new AviaticketDocument();
        $this->request->tourists[$id]->document->type = $tourist->getDocumentType();
        $this->request->tourists[$id]->document->expirationDate = $tourist->getExpirationDate();
        $this->request->tourists[$id]->document->number = $tourist->getDocumentNumber();
    }

    /**
     * Определяем категорию пассажира
     *
     * @param BookingTourist $tourist
     * @param Carbon         $lastFlightDate
     * @return string
     */
    protected function getPassengerCategory(BookingTourist $tourist, Carbon $lastFlightDate): string
    {
        $touristBirthday = Carbon::parse($tourist->getBirthday());
        $touristAges = $lastFlightDate->diff($touristBirthday)->y;
        switch ($touristAges) {
            case ($touristAges >= 12):
                $passengerCategory = 'ADULT';
                break;
            case ($touristAges < 2):
                $passengerCategory = 'INFANT';
                break;
            default:
                $passengerCategory = 'CHILD';
                break;
        }
        return $passengerCategory;
    }
}