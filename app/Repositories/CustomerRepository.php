<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends AbstractRepository
{

    /**
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }


    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function attach(int $id, array $data)
    {

        $customer = $this->find($id);
        return $customer->requests()->attach($data);

    }

}
