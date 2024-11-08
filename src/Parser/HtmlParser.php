<?php

namespace App\Parser;

use App\Exception\BusinessException;
use App\Support\UrlHelper;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class HtmlParser implements Parser
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function parse(string $url): iterable
    {
        $html = $this->retrievePage($url);
        $parsedPage = $this->parsePage($html);

        if (!$this->containProducts($parsedPage)) {
            throw new BusinessException('Page doesn\'t contain products');
        }

        $baseUrl  = UrlHelper::getBaseUrl($url);

        return $this->parseProducts($parsedPage, $baseUrl);
    }

    private function retrievePage(string $url): string
    {
        $response = $this->httpClient->request('GET', $url, [
            'headers' => ['Accept' => 'application/json'],
        ]);

        try {
            return $response->getContent();
        } catch (HttpExceptionInterface $e) {
            throw new BusinessException(sprintf('Can\'t get page "%s", status code: %s ', $url, $e->getResponse()->getStatusCode()));
        }
    }

    private function parsePage(string $html): \DOMXPath
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        return new \DOMXPath($dom);
    }

    abstract protected function containProducts(\DOMXPath $xpath): bool;

    /**
     * TODO pass $base to build absolute url don't fit to method declaration, need to think the better way.
     *
     * @return ProductDTO[]
     */
    abstract protected function parseProducts(\DOMXPath $xpath, string $baseUrl): array;
}
