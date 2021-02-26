<?php

namespace Api\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ActualizeResource
 * Ресурс для выдачи результата актуализации корзины
 * @package Api\Http\Resources\Cart
 */
class ActualizeErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => [
                'actualizeId' => $this->actualizeId,
                'errors' => [
                    [
                        'source' => $this->source,
                        'code' => $this->code,
                        'title' => $this->title,
                        'detail' => $this->detail
                    ]
                ]
            ]
        ];
    }

    /**
     * Customize the response for a request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Http\JsonResponse $response
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->code);
    }
}
