<?php

namespace Api\Models\Cart\Actualize;

use Api\Exceptions\Cart\ActualizeException;
use Api\Models\ApiPrice;
use Api\Models\Services\Accommodation\{AccommodationMeals, AccommodationRoom};
use HotelAccomodationRoom;
use HotelActualizeRS;

/**
 * Class HotelActualize
 * Класс для информации о актуализации конкретного размещения
 *
 * @package Api\Models\Cart\Actualize
 */
class HotelActualize extends ApiActualize
{
    protected const MEAL_CHANGE = 'meal_change';
    protected const ROOM_CHANGE = 'room_change';

    /** @var AccommodationMeals Коды питания */
    public $meals;
    /** @var array Идентификаторы комнат */
    public $room = [];

    /**
     * Обработка актуализации
     *
     * @param HotelActualizeRS $hotelActualizeRS Сырая актуализация из поискового движка
     * @param int              $actualizeId      Id актуализации
     * @throws ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handleActualize(HotelActualizeRS $hotelActualizeRS, int $actualizeId): void
    {
        $this->validateActualize($hotelActualizeRS, $actualizeId);
        $this->price = new ApiPrice(
            $hotelActualizeRS->result->price,
            $hotelActualizeRS->result->markPrice,
            $hotelActualizeRS->result->currency
        );
        foreach ($hotelActualizeRS->result->rooms as $room) {
            $this->meals = new AccommodationMeals();
            $this->meals->mapped = $room->mealRu;
            $this->meals->supplier = $room->meal;
            $this->room[] = new AccommodationRoom($room->id, $room->roomTypeName, $room->nameRu ?? '');
        }
        if (empty($this->code)) {
            $this->code[] = self::MATCH;
        }
    }

    /**
     * Метод для валидации результатов актуализации
     *
     * @param HotelActualizeRS $hotelActualizeRS Сырая актуализация из поискового движка
     * @param int              $actualizeId      Id актуализации
     * @return void
     * @throws ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function validateActualize(HotelActualizeRS $hotelActualizeRS, int $actualizeId): void
    {
        $this->checkResults($hotelActualizeRS, $actualizeId);
        $this->checkPrice($hotelActualizeRS);
        foreach ($hotelActualizeRS->result->rooms as $id => $room) {
            $this->checkRoomAvailable($hotelActualizeRS, $id, $actualizeId);
            $previousRoom = $hotelActualizeRS->previousResult->rooms[$id];
            $this->checkMeal($room, $previousRoom);
            $this->checkRoom($room, $previousRoom);
        }
    }

    /**
     * Проверяет доступность комнаты
     *
     * @param HotelActualizeRS $hotelActualizeRS Сырая актуализация из поискового движка
     * @param string           $id               Id комнаты
     * @param int              $actualizeId      Id актуализации
     * @return void
     * @throws ActualizeException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function checkRoomAvailable(HotelActualizeRS $hotelActualizeRS, string $id, int $actualizeId): void
    {
        if (!$hotelActualizeRS->previousResult->rooms[$id]) {
            throw new ActualizeException(
                $actualizeId,
                $this->serviceId,
                'Внимание! Размещение в отеле недоступно, выберите другой вариант'
            );
        }
    }

    /**
     * Проверяет соответсвие питания
     *
     * @param HotelAccomodationRoom $room
     * @param HotelAccomodationRoom $previousRoom
     * @return void
     */
    private function checkMeal(HotelAccomodationRoom $room, HotelAccomodationRoom $previousRoom): void
    {
        if ($room->mealId != $previousRoom->mealId ||
            strtolower($room->mealRu) != strtolower($previousRoom->mealRu) ||
            strtolower($room->meal) != strtolower($previousRoom->meal)) {
            $this->errors[] = transoe('actualizeRoomMealChange');
            $this->code[] = self::MEAL_CHANGE;
        }
    }

    /**
     * Проверяет соответсвие комнат
     *
     * @param HotelAccomodationRoom $room
     * @param HotelAccomodationRoom $previousRoom
     * @return void
     */
    private function checkRoom(HotelAccomodationRoom $room, HotelAccomodationRoom $previousRoom): void
    {
        if ($room->supplierRoomTypeCode != $previousRoom->supplierRoomTypeCode ||
            strtolower($room->nameRu) != strtolower($previousRoom->nameRu) ||
            strtolower($room->name) != strtolower($previousRoom->name)
        ) {
            $this->errors[] = transoe('actualizeRoomChange');
            $this->code[] = self::ROOM_CHANGE;
        }
    }
}