<?php

namespace App\Pagination;

interface PaginationInterface
{
    public function count(): int;

    public function getLastPage(): int;

    public function getTotalItems(): int;

    public function getCurrentPage(): int;

    public function getItemsPerPage(): int;

    public function getItems(): array;
}
