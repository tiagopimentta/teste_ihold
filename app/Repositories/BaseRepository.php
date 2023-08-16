<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->getModel()->forceCreate($this->formatParams($params));
    }

    /**
     * @param array $params
     * @param string $value
     * @param null $default
     * @return mixed
     */
    public function getAttribute(array $params, string $value, $default = null): mixed
    {
        return (isset($params[$value])) ? $params[$value] : $default;
    }

    /**
     * @param array $params
     * @param array $with
     * @param int|null $perPage
     * @return mixed
     */
    public function getPaginationList(array $params, array $with = [], int $perPage = null)
    {
        $perPage = $params['per_page'] ?? $params['perPage'] ?? $perPage;
        if ($perPage) {
            return $this->getModel()->with($with)->simplePaginate($perPage)->withQueryString();
        }
        return $this->getModel()->with($with)->simplePaginate()->withQueryString();
    }

    /**
     * @param array $params
     * @return array
     */
    public function formatParams(array $params): array
    {
        return $params;
    }
}

