<?php

namespace App\Repository;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function save(): void;
}
