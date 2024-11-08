<?php

namespace App\Transformer;

use App\Entity\Product;
use League\Fractal\TransformerAbstract;

final class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'link' => $product->getLink(),
            'imageUrl' => $product->getImageUrl(),
            'price' => $product->getPrice(),
        ];

    }
}
