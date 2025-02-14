<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function find(int $id)
    {
        return $this->model::findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        $data = $this->model::find($id);
        if($data){
            $data->delete();
        }
    }


}
