<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{

    /**
     * Find the register searching with the model_id.
     *
     * @param $value
     * @return Model|null
     */
    public function find($value): ?Model;

    /**
     * Return all registers.
     *
     * @return mixed
     */
    public function getAll();

}