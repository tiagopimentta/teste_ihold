<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository
{
    protected OrderItem $model;

    public function __construct(OrderItem $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $params
     * @param array $with
     * @param int|null $perPage
     * @return mixed
     */
   public function getPaginationList(array $params, array $with = [], int $perPage = null): mixed
   {
       return $this
           ->getModel()
           ->where('order_id', '=', $params['order_id'])
           ->with($with)
           ->simplePaginate($perPage)
           ->withQueryString();
   }
}
