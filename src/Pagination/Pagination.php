<?php

namespace App\Pagination;

final class Pagination implements PaginationInterface
{
    public function __construct(
        private array $items,
        private int $total,
        private int $currentPage,
        private int $limit,
    ) {
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getLastPage(): int
    {
        if (0 >= $this->limit) {
            return 1;
        }

        $page = (int) ceil($this->getTotalItems() / $this->limit);

        return $page ?: 1;
    }

    public function getTotalItems(): int
    {
        return $this->total;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getItemsPerPage(): int
    {
        return $this->limit;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
