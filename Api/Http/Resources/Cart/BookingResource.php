<?php

namespace Api\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BookingResource
 * Ресурс для выдачи результата бронирования
 *
 * @package Api\Http\Resources\Cart
 */
class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => [
                'orderId' => (int)$this->orderId,
                'errors' => $this->errors
            ]
        ];
    }
}
