<?php

namespace App\Repository;

use App\Entity\Product;
use App\Message\SaveProductsToCSVAsyncMessage;
use App\Writer\CsvProductWriter;
use Symfony\Component\Messenger\MessageBusInterface;

class CsvProductRepository implements ProductRepositoryInterface
{
    private array $bufferedProducts = [];

    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly CsvProductWriter $csvProductWriter,
    ) {
    }

    public function add(Product $product): void
    {
        $this->bufferedProducts[] = $product;
    }

    public function save(): void
    {
        if (count($this->bufferedProducts) < 1) {
            return;
        }

        $bufferedProducts = $this->bufferedProducts;
        $this->bufferedProducts = [];
        $this->messageBus->dispatch(new SaveProductsToCSVAsyncMessage($bufferedProducts));
    }

    public function saveSync(): void
    {
        if (count($this->bufferedProducts) < 1) {
            return;
        }

        $bufferedProducts = $this->bufferedProducts;
        $this->bufferedProducts = [];
        $this->csvProductWriter->write($bufferedProducts);
    }
}
