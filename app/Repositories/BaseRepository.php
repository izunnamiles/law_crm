<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(
        public Model $model,
    ) {
    }

    public function find(int $id,  array $relation = []): ?Model
    {
        if ($relation){
            return $this->model::with($relation)->find($id);
        }
        return $this->model::find($id);
    }

    public function create(array $data): Model
    {
        return $this->model::create($data);
    }
}
