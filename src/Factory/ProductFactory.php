<?php

namespace App\Factory;

use App\Entity\Product;
use App\Parser\ProductDTO;

class ProductFactory
{
    public function createFromProductDto(ProductDTO $productDto): Product
    {
        $product = new Product();
        $product
            ->setName($productDto->name)
            ->setPrice($productDto->price)
            ->setImageUrl($productDto->imageUrl)
            ->setLink($productDto->link);

        return $product;
    }
}
