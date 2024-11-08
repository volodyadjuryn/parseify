<?php

namespace App\Parser;

readonly class ProductDTO
{
    public function __construct(
        public string $name,
        public int $price,
        public string $imageUrl,
        public string $link,
    ) {
    }
}
