<?php

namespace App\Message;

use App\Repository\CsvProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SaveProductsToCSVAsyncMessageHandler
{
    public function __construct(
        private readonly CsvProductRepository $csvProductRepository,
    ) {
    }

    public function __invoke(SaveProductsToCSVAsyncMessage $message)
    {
        $products = $message->getProducts();

        foreach ($products as $product) {
            $this->csvProductRepository->add($product);
        }
        $this->csvProductRepository->saveSync();
    }
}
