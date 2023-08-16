<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $repository;

    /**
     * @var Model
     */
    protected $entity;


        public function __construct($repository)
    {
        $this->repository = $repository;
    }

    function getRepository()
    {
        return $this->repository;
    }

    public function getPaginationList(array $params)
    {
        return $this->getRepository()->getPaginationList($params);
    }
}
