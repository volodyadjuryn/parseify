<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepositoryManager implements ProductRepositoryInterface
{
    /**
     * @param iterable|ProductRepositoryInterface[] $repositories
     */
    public function __construct(
        private readonly iterable $repositories,
    ) {
    }

    public function add(Product $product): void
    {
        foreach ($this->repositories as $repository) {
            $repository->add($product);
        }
    }

    public function save(): void
    {
        foreach ($this->repositories as $repository) {
            $repository->save();
        }
    }
}
