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
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param $value
     * @return Model|null
     */
    public function find($value): ?Model
    {
        return $this->getModel()::query()->find($value);
    }

    public function getAll()
    {
        return $this->getModel()::all();
    }

}