<?php

namespace Api\Services\Cart\Booking\Hotel;

use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use HotelBookingCustomer;
use HotelBookingRQ;
use HotelBookingTourist;
use HunterEngine;
use Illuminate\Support\Carbon;
use Onex\DBPackage\Models\BookingRemark;

/**
 * Class BookingHotelCreateRequestService
 * Сервис для формирования реквеста в движок бронирования отелей
 *
 * @package Api\Services\Cart\Booking\Hotel
 */
class BookingHotelCreateRequestService extends BookingCreateRequestService
{
    /** @var HotelBookingRQ  */
    private $request;
    /** @var HotelBookingCustomer  */
    private $customer;
    /** @var BookingRemark  */
    private $remark;

    /**
     * BookingHotelCreateRequestService constructor.
     *
     * @param HotelBookingRQ       $request
     * @param HotelBookingCustomer $customer
     * @param BookingRemark        $remark
     */
    public function __construct(HotelBookingRQ $request, HotelBookingCustomer $customer, BookingRemark $remark)
    {
        parent::__construct();
        $this->request = $request;
        $this->customer = $customer;
        $this->remark = $remark;
    }

    /**
     * Получение реквеста
     *
     * @param BookingRQ $bookingRQ
     * @param array     $actualize
     * @return HotelBookingRQ
     */
    public function getRequest(BookingRQ $bookingRQ, array $actualize): HotelBookingRQ
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
        $hotelActualize = $actualize[HunterEngine::TYPE_HOTEL];
        $this->request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
        $this->request->currency = $this->usersRepo->getUserCurrencyNS();
        $this->fillCustomer($this->customer);
        $this->request->customer = $this->customer;
        $this->request->orderId = $bookingRQ->getOrderId() ?? '';
        $this->request->searchId = unserialize($hotelActualize->additionalInfo['search'])->code;
        $this->fillTourists($bookingRQ);
        $this->request->accomodationId = $hotelActualize->result->id;
        $this->request->hotelId = $hotelActualize->result->hotelId;
        $this->request->serviceType = HunterEngine::TYPE_HOTEL;
        $this->request->actualizeCode = $hotelActualize->actualizeCode;
        $this->request->additional['priceNet'] = $hotelActualize->result->price;
        $this->request->isOffline = $hotelActualize->isOfflineBooking;
        $this->fillRemark($this->remark);
        $this->request->remarks[] = $this->remark;
    }


    /**
     * Заполняем турситов
     *
     * @param BookingRQ $bookingRQ
     * @return void
     */
    protected function fillTourists(BookingRQ $bookingRQ): void
    {
        /** @var BookingTourist $tourist */
        foreach ($bookingRQ->getTourists() as $id => $tourist) {
            $this->request->tourists[$id] = new HotelBookingTourist();
            $this->request->tourists[$id]->roomId = $tourist->getRoomId();
            $this->request->tourists[$id]->name = $tourist->getName();
            $this->request->tourists[$id]->surname = $tourist->getSurname();
            $this->request->tourists[$id]->middleName = $tourist->getMiddleName();
            $this->request->tourists[$id]->gender = $tourist->getGender();
            $this->request->tourists[$id]->birthday = $tourist->getBirthday();

            $this->request->tourists[$id]->passportNumber = $tourist->getDocumentNumber();
            $this->request->tourists[$id]->passportValidity = Carbon::parse($tourist->getExpirationDate())->timestamp;
            $documentType = $this->dicDocumentTypeRepo->getByCode($tourist->getDocumentType());
            if ($documentType) {
                $this->request->tourists[$id]->documentTypeId = $documentType->id;
            }

            $this->request->tourists[$id]->phone = $tourist->getPhone();
            $this->request->tourists[$id]->email = $tourist->getEmail();
            $this->request->tourists[$id]->touristId = $tourist->getId() ?? '';
            $this->request->tourists[$id]->countryId = $tourist->getCitizen();
        }
    }
}