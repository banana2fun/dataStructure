<?php

namespace Api\Http\Resources\Cart;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ActualizeResource
 * Ресурс для выдачи результата актуализации корзины
 *
 * @package Api\Http\Resources\Cart
 */
class ActualizeResource extends JsonResource
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
                'actualizeId' => $this->actualizeId,
                'errors' => $this->when($this->accommodation || $this->transfer || $this->insurance || $this->flight,
                    [
                        'hotel' => $this->when($this->accommodation, $this->accommodation),
                        'transfer' => $this->when($this->transfer, $this->transfer),
                        'insurance' => $this->when($this->insurance, $this->insurance),
                        'aviaticket' => $this->when($this->flight, $this->flight),
                    ]
                )
            ]
        ];
    }

    /**
     * Customize the response for a request.
     *
     * @param Request      $request
     * @param JsonResponse $response
     *
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->code);
    }
}
