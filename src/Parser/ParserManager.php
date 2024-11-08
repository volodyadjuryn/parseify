<?php

namespace App\Parser;

use App\Parser\Exception\DomainNotSupportedException;
use App\Support\UrlHelper;

class ParserManager implements Parser
{
    /**
     * @var array<string, Parser>
     */
    private array $parsers;

    public function __construct(
        iterable $parsers,
    ) {
        $this->parsers = iterator_to_array($parsers);
    }

    public function parse(string $url): iterable
    {
        $parser = $this->getParser($url);

        return $parser->parse($url);
    }

    private function getParser(string $url): Parser
    {
        $domain = UrlHelper::getDomain($url);

        if (!isset($this->parsers[$domain])) {
            throw new DomainNotSupportedException($url);
        }

        return $this->parsers[$domain];
    }
}
