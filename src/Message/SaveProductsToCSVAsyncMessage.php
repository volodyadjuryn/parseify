<?php

namespace App\Message;

use App\Entity\Product;

class SaveProductsToCSVAsyncMessage
{
    /**
     * @param Product[] $products
     */
    public function __construct(
        private readonly array $products,
    ) {
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
