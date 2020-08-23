<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{

    /**
     * @var User
     */
    protected $model;

    public function setModel(Model $model): void
    {
        $this->model = $model;
    }


    /**
     * @param array $values
     * @param int $id
     * @return int
     */
    public function update(array $values, int $id)
    {
        return DB::table($this->model->getTable())
            ->where('id', $id)
            ->update($values);
    }

}