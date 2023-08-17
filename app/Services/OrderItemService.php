<?php

namespace App\Services;

use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;

class OrderItemService extends BaseService
{
    protected OrderItemRepository $orderItemRepository;

    public function __construct(OrderItemRepository $repository)
    {
        $this->orderItemRepository = $repository;
        parent::__construct($repository);
    }
}
