<?php

namespace App\Repositories;

use App\Models\Request;

class RequestRepository extends AbstractRepository
{


    /**
     * @param Request $requestModel
     */
    public function __construct(Request $requestModel)
    {
        parent::__construct($requestModel);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function attach(int $id, array $data)
    {

        $request = $this->find($id);
        return $request->products()->attach($data);

    }
}
