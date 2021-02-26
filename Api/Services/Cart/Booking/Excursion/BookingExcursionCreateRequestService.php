<?php

namespace Api\Services\Cart\Booking\Excursion;

use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingInfoExcursion, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use BookingCustomer;
use ExcursionBookingRemark;
use ExcursionBookingRQ;
use ExcursionBookingTourist;
use HunterEngine;
use Illuminate\Support\Carbon;

/**
 * Class BookingExcursionCreateRequestService
 * Сервис для формирования реквеста в движок бронирования экскурсий
 *
 * @package Api\Services\Cart\Booking\Excursion
 */
class BookingExcursionCreateRequestService extends BookingCreateRequestService
{
    private $response = [];

    /**
     * Формирует реквесты
     *
     * @param BookingRQ $bookingRQ
     * @return array
     */
    public function getRequests(BookingRQ $bookingRQ): array
    {
        /** @var BookingInfoExcursion $excursion */
        foreach ($bookingRQ->getBookingInfo()->getExcursions() as $excursion) {
            $request = new ExcursionBookingRQ();
            $request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
            $request->currency = $this->usersRepo->getUserCurrencyNS();
            $request->customer = new BookingCustomer();
            $this->fillCustomer($request->customer);
            $request->orderId = $bookingRQ->getOrderId() ?? '';
            $request->searchId = $bookingRQ->getBookingInfo()->getExcursionSearchId();
            $this->fillTourists($bookingRQ, $request);
            $request->excursionId = $excursion->getExcursionId();
            $request->date = Carbon::createFromFormat('d.m.Y', $excursion->getDate())->format('Y-m-d');
            $request->time = $excursion->getTime();
            $request->adults = $bookingRQ->getBookingInfo()->getAdults();
            $request->children = $bookingRQ->getBookingInfo()->getChildren();
            $request->meetingPlace = $bookingRQ->getBookingInfo()->getMeetingPlace();
            $request->remarks[] = new ExcursionBookingRemark();
            $this->response[] = $request;
        }
        return $this->response;
    }

    /**
     * Заполняем туристов
     *
     * @param BookingRQ          $bookingRQ
     * @param ExcursionBookingRQ $request
     * @return void
     */
    protected function fillTourists(BookingRQ $bookingRQ, ExcursionBookingRQ $request): void
    {
        /** @var BookingTourist $tourist */
        foreach ($bookingRQ->getTourists() as $tourist) {
            $requestTourist = new ExcursionBookingTourist();
            $requestTourist->name = 'TEST';
            $requestTourist->surname = 'TEST';
            $requestTourist->middleName = 'TEST';
            $requestTourist->gender = $tourist->getGender();
            $requestTourist->birthday = $tourist->getBirthday();

            $requestTourist->passportNumber = $tourist->getDocumentNumber();
            $requestTourist->passportValidity = Carbon::parse($tourist->getExpirationDate())->timestamp;
            $documentTypeId = $this->dicDocumentTypeRepo->getByCode($tourist->getDocumentType())->id;
            $requestTourist->documentTypeId = $documentTypeId;

            $requestTourist->phone = $tourist->getPhone();
            $requestTourist->email = $tourist->getEmail();
            $requestTourist->countryId = $tourist->getCitizen();
            $request->tourists[] = $requestTourist;
            $request->phone = $tourist->getPhone();
            break;
        }
    }
}