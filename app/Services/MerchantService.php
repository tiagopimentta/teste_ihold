<?php

namespace App\Services;

use App\Repositories\MerchantRepository;

class MerchantService extends BaseService
{
    protected MerchantRepository $merchantRepository;

    public function __construct(MerchantRepository $repository)
    {
        $this->orderRepository = $repository;
        parent::__construct($repository);
    }
}
