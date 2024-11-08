<?php

namespace App\Parser\Exception;

use App\Exception\BusinessException;

class DomainNotSupportedException extends BusinessException
{
    public function __construct(string $url)
    {
        parent::__construct(sprintf("Url '%s' is not a supported.", $url));
    }
}
