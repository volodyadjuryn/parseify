<?php

namespace App\Pagination;

interface PaginationUrlGeneratorInterface
{
    public function generate(int $page): string;
}
