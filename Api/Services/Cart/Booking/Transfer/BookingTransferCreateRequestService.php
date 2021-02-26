<?php

namespace Api\Services\Cart\Booking\Transfer;

use Api\Http\FillableRequests\Cart\{BookingRQ, Models\BookingInfo, Models\BookingTourist};
use Api\Services\Cart\Booking\BookingCreateRequestService;
use HunterEngine;
use Illuminate\Support\Carbon;
use Onex\DBPackage\Factories\RepositoryFactory;
use Onex\DBPackage\Models\BookingRemark;
use Search;
use TransferBookingPoint;
use TransferBookingRQ;
use TransferBookingTourist;
use TransferPoint;
use TransferSearchRQ;

/**
 * Class BookingTransferCreateRequestService
 * Сервис для формирования реквеста в движок бронирования трансферов
 *
 * @package Api\Services\Cart\Booking\Transfer
 */
class BookingTransferCreateRequestService extends BookingCreateRequestService
{
    /** @var TransferBookingRQ  */
    private $request;

    /**
     * BookingTransferCreateRequestService constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        parent::__construct();
        $this->request = new TransferBookingRQ(null);
    }

    /**
     * Получаем реквест
     *
     * @param BookingRQ $bookingRQ
     * @return TransferBookingRQ
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRequest(BookingRQ $bookingRQ): TransferBookingRQ
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function fillRequest(BookingRQ $bookingRQ): void
    {
        $bookingInfo = $bookingRQ->getBookingInfo();
        $this->setTransferPoints($bookingInfo);
        $this->request->markupScheme = $bookingRQ->getApp() ?? HunterEngine::MARKUP_SCHEME_ONEX_STANDARD;
        $this->request->currency = $this->usersRepo->getUserCurrencyNS();
        $this->request->orderId = $bookingRQ->getOrderId() ?? '';
        $this->request->searchId = $bookingInfo->getTransferSearchId();
        $this->fillTourists($bookingRQ);
        $this->request->setPassengersCount(count($bookingRQ->getTourists()));
        $this->request->transferResultId = $bookingInfo->getTransferId();
        $this->request->vehicleId = $bookingInfo->getVehicleId();
        $this->request->flightCompanyName = $this->request->pointFrom->flightCompanyName;
        $this->request->flightNumber = $this->request->pointFrom->flightNumber;
        $this->request->destinationAddress = $this->request->pointTo->address;
        $this->request->returnFlightCompanyName = $bookingInfo->getReturnFlightCode();
        $this->request->pointTo->returnTransportCompanyName = $bookingInfo->getReturnFlightCode();
        $this->request->returnFlightNumber = $bookingInfo->getReturnFlightNumber();
        $this->request->pointTo->returnTransportNumber = $bookingInfo->getReturnFlightNumber();
        $this->request->namePlateText = $this->request->tourists[0]->name . ' ' . $this->request->tourists[0]->surname;
        $this->request->remarks[] = new BookingRemark();
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
            $this->request->tourists[$id] = new TransferBookingTourist();
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
     * Заполяем точки трансферов
     *
     * @param BookingInfo $bookingInfo
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setTransferPoints(BookingInfo $bookingInfo): void
    {
        $oldSearch = Search::readFromRedis($bookingInfo->getTransferSearchId());
        $params = $oldSearch->params;
        $this->setPointTo($params);
        $this->setPointFrom($bookingInfo, $params);
    }

    /**
     * Устанавливает току в
     *
     * @param TransferSearchRQ $params
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setPointTo(TransferSearchRQ $params): void
    {
        $pointTo = $this->getPoint($params->dropOffCityName, $params->dropOffCityId, $params->dropOffRouteId,
            $params->dropOffCode);
        $this->request->pointTo = new TransferBookingPoint($pointTo);
        $hotelsRepo = RepositoryFactory::makeHotelsRepo();
        $hotel = $hotelsRepo->getById($params->dropOffRouteId);
        $this->request->pointTo->address = $hotel->address . ' (Hotel: ' . $hotel->nameEn . ')';
    }

    /**
     * Устанавливает точку из
     *
     * @param BookingInfo      $bookingInfo
     * @param TransferSearchRQ $params
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setPointFrom(BookingInfo $bookingInfo, TransferSearchRQ $params): void
    {
        $pointFrom = $this->getPoint($params->pickUpCityName, $params->pickUpCityId, $params->pickUpRouteId,
            $params->pickUpCode);
        $this->request->pointFrom = new TransferBookingPoint($pointFrom);
        $this->request->pointFrom->time = $params->time;
        $this->request->pointFrom->flightCompanyName = $bookingInfo->getFlightCode();
        $this->request->pointFrom->transportCompanyName = $bookingInfo->getFlightCode();
        $this->request->pointFrom->flightNumber = $bookingInfo->getFlightNumber();
        $this->request->pointFrom->transportNumber = $bookingInfo->getFlightNumber();
        $this->request->pointFrom->address = $pointFrom->getName();
    }

    /**
     * Получаем точку
     *
     * @param string $cityName
     * @param int    $cityId
     * @param int    $routeId
     * @param string $code
     * @return TransferPoint
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getPoint(string $cityName, int $cityId, int $routeId, string $code): TransferPoint
    {
        $point['cityName'] = $cityName;
        $point['cityId'] = $cityId;
        $point['routeId'] = $routeId;
        $point['code'] = $code;
        return new TransferPoint($point);
    }
}