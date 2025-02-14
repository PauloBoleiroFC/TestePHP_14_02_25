<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends AbstractRepository
{

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
}
