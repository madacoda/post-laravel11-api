<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Repository
{
    protected $model;

    /**
     * get all data
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->latest()->get();
    }

    public function paginate($limit = 10)
    {
        return $this->model->latest()->paginate($limit);
    }

    /**
     * store data
     *
     * @param array $data
     * @return Model
     */
    public function store(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * find data by id
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * update data by id
     *
     * @param array $data
     * @param int $id
     * @return Model
     * @return mixed
     */
    public function update(array $input, int $id)
    {
        $model = $this->find($id);
        if ($model) {
            $model->update($input);
            return $model;
        }
        return 0;
    }

    /**
     * delete data by id
     *
     * @param int $id
     * @return Model
     * @return mixed
     */
    public function destroy(int $id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return 0;
    }
}
