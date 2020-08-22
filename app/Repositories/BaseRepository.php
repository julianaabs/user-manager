<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param $value
     * @return Model|null
     */
    public function find($value): ?Model
    {
        return $this->model::query()->find($value);
    }

    public function getAll()
    {
        return $this->model::all();
    }

}