<?php

namespace Api\Services\Cart\Booking\Visa;

use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use HunterEngine;
use Illuminate\Support\Carbon;
use VisaBookingRQ;
use VisaBookingTourist;

/**
 * Class BookingVisaCreateRequestService
 * Сервис для формирования реквеста в движок бронирования виз
 *
 * @package Api\Services\Cart\Booking\Visa
 */
class BookingVisaCreateRequestService extends BookingCreateRequestService
{
    /** @var array */
    private $response = [];

    /**
     * Получаем реквест
     *
     * @param BookingRQ $bookingRQ
     * @return array
     */
    public function getRequests(BookingRQ $bookingRQ): array
    {
        $this->getTourists($bookingRQ);
        $this->fillRequests($bookingRQ);
        return $this->response;
    }

    /**
     * Заполняем реквест
     *
     * @param BookingRQ $bookingRQ
     * @return void
     */
    private function fillRequests(BookingRQ $bookingRQ): void
    {
        $visas = collect($bookingRQ->getTourists())->pluck('visaId')->unique();
        foreach ($visas as $visaId) {
            $request = new VisaBookingRQ();
            $request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
            $request->currency = $this->usersRepo->getUserCurrencyNS();
            $request->orderId = $bookingRQ->getOrderId() ?? '';
            $request->searchId = $bookingRQ->getBookingInfo()->getVisaSearchId();
            $this->fillTourists($bookingRQ, $visaId, $request);
            $request->startDate = $bookingRQ->getBookingInfo()->getStartDate();
            $request->endDate = $bookingRQ->getBookingInfo()->getEndDate();
            $this->response[] = $request;
        }
    }

    /**
     * Заполняем туристов
     *
     * @param BookingRQ     $bookingRQ
     * @param string        $visaId
     * @param VisaBookingRQ $request
     * @return void
     */
    private function fillTourists(BookingRQ $bookingRQ, string $visaId, VisaBookingRQ $request): void
    {
        /** @var BookingTourist $tourist */
        foreach ($bookingRQ->getTourists() as $id => $tourist) {
            if ($tourist->getVisaId() === $visaId) {
                $request->tourists[$id] = new VisaBookingTourist();
                $request->tourists[$id]->name = $tourist->getName();
                $request->tourists[$id]->surname = $tourist->getSurname();
                $request->tourists[$id]->middleName = $tourist->getMiddleName();
                $request->tourists[$id]->gender = $tourist->getGender();
                $request->tourists[$id]->birthday = $tourist->getBirthday();

                $request->tourists[$id]->passportNumber = $tourist->getDocumentNumber();
                $request->tourists[$id]->passportValidity = Carbon::parse($tourist->getExpirationDate())->timestamp;
                $documentTypeId = $this->dicDocumentTypeRepo->getByCode($tourist->getDocumentType())->id;
                $request->tourists[$id]->documentTypeId = $documentTypeId;
                $request->tourists[$id]->expireDate = $tourist->getExpirationDate();
                $request->tourists[$id]->documentType = $documentTypeId;

                $request->tourists[$id]->phone = $tourist->getPhone();
                $request->tourists[$id]->email = $tourist->getEmail();
                $request->tourists[$id]->touristId = $tourist->getId() ?? '';
                $request->tourists[$id]->countryId = $tourist->getCitizen();

                $request->tourists[$id]->variantId = $tourist->getVariantId();
                $request->visaId = $tourist->getVisaId();
            }
        }
    }
}