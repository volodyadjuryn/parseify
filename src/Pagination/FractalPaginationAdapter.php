<?php

namespace App\Pagination;

use League\Fractal\Pagination\PaginatorInterface as FractalPaginationBaseInterface;

final class FractalPaginationAdapter implements FractalPaginationBaseInterface
{
    public function __construct(
        private PaginationInterface $pagination,
        private PaginationUrlGeneratorInterface $paginationUrlGenerator,
    ) {
    }

    public function getCurrentPage(): int
    {
        return $this->pagination->getCurrentPage();
    }

    public function getLastPage(): int
    {
        return $this->pagination->getLastPage();
    }

    public function getTotal(): int
    {
        return $this->pagination->getTotalItems();
    }

    public function getCount(): int
    {
        return $this->pagination->count();
    }

    public function getPerPage(): int
    {
        return $this->pagination->getItemsPerPage();
    }

    public function getUrl(int $page): string
    {
        return $this->paginationUrlGenerator->generate($page);
    }
}
