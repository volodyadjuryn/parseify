<?php

namespace App\Parser;

use App\Support\UrlHelper;

class SolmarParser extends HtmlParser
{
    protected function containProducts(\DOMXPath $xpath): bool
    {
        return 1 === $xpath->query("//div[contains(@class, 's-catalog__list')]")->count();
    }

    protected function parseProducts(\DOMXPath $xpath, string $baseUrl): array
    {
        /** @var \DOMNodeList $productNodeList */
        $productNodeList = $xpath->query("//div[contains(@class, 's-catalog__item')]");

        $parsedProducts = [];

        /** @var \DOMElement $productDomElement */
        foreach ($productNodeList as $productDomElement) {

            $parsedProducts[] = new ProductDTO(
                $this->parseProductName($xpath, $productDomElement),
                $this->parseProductPrice($xpath, $productDomElement),
                $this->parseProductImage($xpath, $productDomElement, $baseUrl),
                $this->parseProductLink($xpath, $productDomElement, $baseUrl)
            );
        }

        return $parsedProducts;
    }

    private function parseProductLink(\DOMXPath $xpath, \DOMElement $productDomElement, string $baseUrl): string
    {
        $href = $xpath->query(".//a[contains(@class, 's-product__link')]", $productDomElement)
            ->item(0)
            ->getAttribute('href');

        return UrlHelper::makeUrlAbsolute($href, $baseUrl);
    }

    private function parseProductName(\DOMXPath $xpath, \DOMElement $productDomElement): string
    {
        $title = $xpath->query(".//a[contains(@class, 's-product__title')]", $productDomElement)
            ->item(0)
            ->getAttribute('title');

        return trim($title);

    }

    private function parseProductImage(\DOMXPath $xpath, \DOMElement $productDomElement, string $baseUrl)
    {
        $src = $xpath->query(".//div[contains(@class, 's-product__image-wrapper')]//img", $productDomElement)
            ->item(0)
            ->getAttribute('src');

        return UrlHelper::makeUrlAbsolute($src, $baseUrl);
    }

    private function parseProductPrice(\DOMXPath $xpath, \DOMElement $productDomElement): int
    {
        $rawPrice = $xpath->query(".//div[contains(@class, 's-product__new-price')]", $productDomElement)
            ->item(0)
            ->textContent;

        return intval(preg_replace('/\s+/', '', $rawPrice));
    }
}
