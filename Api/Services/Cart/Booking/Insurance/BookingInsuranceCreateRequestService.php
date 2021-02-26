<?php

namespace Api\Services\Cart\Booking\Insurance;

use Api\Exceptions\Service\Insurance\InsuranceSumPerPersonException;
use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingInfo, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use BookingCustomer;
use HunterEngine;
use Illuminate\Support\Carbon;
use InsuranceBookingRQ;
use InsuranceBookingTourist;
use Onex\DBPackage\Models\Rate;

/**
 * Class BookingInsuranceCreateRequestService
 * Сервис для формирования реквеста в движок бронирования страховок
 *
 * @package Api\Services\Cart\Booking\Insurance
 */
class BookingInsuranceCreateRequestService extends BookingCreateRequestService
{
    /** @var InsuranceBookingRQ  */
    private $request;
    /** @var BookingCustomer  */
    private $customer;
    /** @var Rate */
    private $rate;

    /**
     * BookingInsuranceCreateRequestService constructor.
     *
     * @param InsuranceBookingRQ $request
     * @param BookingCustomer    $customer
     * @param Rate               $rate
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(InsuranceBookingRQ $request, BookingCustomer $customer, Rate $rate)
    {
        parent::__construct();
        $this->request = $request;
        $this->customer = $customer;
        $this->rate = $rate;
    }

    /**
     * Получаем реквест
     *
     * @param BookingRQ $bookingRQ
     * @return InsuranceBookingRQ
     * @throws InsuranceSumPerPersonException
     */
    public function getRequest(BookingRQ $bookingRQ): InsuranceBookingRQ
    {
        $this->getTourists($bookingRQ);
        $this->fillRequest($bookingRQ);

        return $this->request;
    }

    /**
     * Заполняем реквест
     *
     * @param BookingRQ $bookingRQ
     * @return void
     * @throws InsuranceSumPerPersonException
     */
    protected function fillRequest(BookingRQ $bookingRQ ): void
    {
        if ($bookingRQ->getBookingInfo()->getSumPerPerson()) {
            $this->convertCurrencyToEUR($bookingRQ->getBookingInfo());
        }
        $this->request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
        $this->request->currency = $this->usersRepo->getUserCurrencyNS();
        $this->fillCustomer($this->customer);
        $this->request->customer = $this->customer;
        $this->request->orderId = $bookingRQ->getOrderId() ?? '';
        $this->request->searchId = $bookingRQ->getBookingInfo()->getInsuranceSearchId();
        $this->fillTourists($bookingRQ);
        $this->request->resultId = $bookingRQ->getBookingInfo()->getInsuranceResultId();
        $sumPerPerson = $bookingRQ->getBookingInfo()->getSumPerPerson();
        $this->request->cancelTrip = isset($sumPerPerson);
        $this->request->sumPerPerson = $sumPerPerson ?? '100';
    }

    /**
     * Заполняем туристов
     *
     * @param BookingRQ $bookingRQ
     * @return void
     */
    protected function fillTourists(BookingRQ $bookingRQ): void
    {
        /** @var BookingTourist $tourist */
        foreach ($bookingRQ->getTourists() as $id => $tourist) {
            $this->request->tourists[$id] = new InsuranceBookingTourist();
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
        }
    }

    /**
     * Конвертирует пришедшую стоимость на человека в евро
     *
     * @param BookingInfo $bookingInfo Массив с отвалидированными данными из реквеста на страховку на отмену
     * @return void
     * @throws InsuranceSumPerPersonException
     */
    private function convertCurrencyToEUR(BookingInfo $bookingInfo): void
    {
        $ratios = $this->rate->ratios($bookingInfo->getCurrency());
        $sumPerPerson = floor($bookingInfo->getSumPerPerson() * $ratios['EUR']);
        $bookingInfo->setSumPerPerson($sumPerPerson);
        $bookingInfo->setCurrency(HunterEngine::CURRENCY_DEFAULT);
        if ($sumPerPerson < 100 || $sumPerPerson > 5000) {
            throw new InsuranceSumPerPersonException(
                'Сумма страховки на человека должна быть в диапазоне от 100 до 5000 EUR. Ваша сумма равна '
                . $bookingInfo->getSumPerPerson() . ' ' . $bookingInfo->getCurrency()
            );
        }
    }
}