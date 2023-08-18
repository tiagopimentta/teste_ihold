<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'merchant_name' => $this->resource->merchant_name,
            'created_at' => $this->resource->created_at,
            'admin_id' => $this->resource->admin_id,
            'products' => ProductResource::collection($this->resource->products),
            'admin' => new UserResource($this->resource->admin)
        ];
    }
}
