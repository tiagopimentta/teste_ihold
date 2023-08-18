<?php

namespace App\Services;
use App\Models\Merchant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use App\Repositories\ProductRepository;
use Exception;

class ProductService extends BaseService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
        parent::__construct($repository);

    }

    public function save(array $params): Model
    {
        $user = Auth::user();
        $merchant = Merchant::find($params['merchant_id']);
        if($user->id != $merchant->admin_id){

            throw new Exception('Você não pode cadastrar um produto');
       }
        return parent::save($params);
    }

}
