<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
        parent::__construct($repository);
    }
}
