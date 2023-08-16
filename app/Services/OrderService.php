<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService extends BaseService
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
        parent::__construct($orderRepository);
    }
}
