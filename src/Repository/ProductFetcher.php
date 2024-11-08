<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\PaginationInterface;

interface ProductFetcher
{
    public function findByLink(string $link): ?Product;

    public function getPaginated(int $page = 1, $limit = 10): PaginationInterface;
}
