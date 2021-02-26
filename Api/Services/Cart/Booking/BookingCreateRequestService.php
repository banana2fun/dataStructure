<?php

namespace Api\Services\Cart\Booking;

use Api\Http\FillableRequests\Cart\BookingRQ;
use BookingCustomer;
use Onex\DBPackage\Factories\RepositoryFactory;
use Onex\DBPackage\Models\BookingRemark;
use Onex\DBPackage\Repositories\Interfaces\{IDicDocumentTypeRepo, IOrderTouristsRepo, IUsersRepo};

class BookingCreateRequestService
{
    /** @var IUsersRepo  */
    protected $usersRepo;
    /** @var IDicDocumentTypeRepo  */
    protected $dicDocumentTypeRepo;
    /** @var IOrderTouristsRepo  */
    protected $orderTouristsRepo;

    /**
     * BookingCreateRequestService constructor.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->usersRepo = RepositoryFactory::makeUsersRepo();
        $this->dicDocumentTypeRepo = RepositoryFactory::makeDicDocumentTypeRepo();
        $this->orderTouristsRepo = RepositoryFactory::makeOrderTouristsRepo();
    }

    /**
     * Получаем туристов из заказа
     *
     * @param BookingRQ $bookingRQ
     * @return void
     */
    protected function getTourists(BookingRQ $bookingRQ): void
    {
        if ($bookingRQ->getOrderId()) {
            $orderTourists = $this->orderTouristsRepo->findByOrderId($bookingRQ->getOrderId());
            $touristCount = count($orderTourists);
            for ($i = 0; $i < $touristCount; $i++) {
                $bookingRQ->tourists[$i]->id = $bookingRQ->getTourists()[$i]->id ?? $orderTourists[$i]->getId();
            }
        }
    }

    /**
     * Заполняем кастомера
     *
     * @param BookingCustomer $customer
     * @return void
     */
    protected function fillCustomer(BookingCustomer $customer): void
    {
        $customer->name = 'Dummy';
        $customer->surname = 'Dummy';
        $customer->phone = BookingCustomer::DEFAULT_PHONE;
        $customer->email = BookingCustomer::DEFAULT_EMAIL;
    }

    /**
     * Заполняем ремарки
     *
     * @param BookingRemark $remark
     * @return void
     */
    protected function fillRemark(BookingRemark $remark): void
    {
        $remark->message = '';
    }
}