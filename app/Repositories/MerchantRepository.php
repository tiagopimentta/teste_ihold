<?php

namespace App\Repositories;

use App\Models\Merchant;
use App\Models\Order;

class MerchantRepository extends BaseRepository
{
    protected Merchant $model;

    public function __construct(Merchant $model)
    {
        $this->model = $model;
    }
}
