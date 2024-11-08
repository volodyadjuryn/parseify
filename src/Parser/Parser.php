<?php

namespace App\Parser;

interface Parser
{
    /**
     * @return ProductDTO[]
     */
    public function parse(string $url): iterable;
}
