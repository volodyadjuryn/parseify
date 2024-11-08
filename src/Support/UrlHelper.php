<?php

namespace App\Support;

class UrlHelper
{
    public static function getDomain(string $url): string
    {
        $parsedUrl = parse_url($url);

        return $parsedUrl['host'];
    }

    public static function getBaseUrl(string $absoluteUrl): string
    {
        $parsedUrl = parse_url($absoluteUrl);

        return $parsedUrl['scheme'].'://'.$parsedUrl['host'];
    }

    public static function makeUrlAbsolute(string $relativeUrl, string $baseUrl): string
    {
        return str_starts_with($relativeUrl, 'http') ? $relativeUrl : $baseUrl.'/'.ltrim($relativeUrl, '/');
    }

    public static function isUrlValid(string $url): bool
    {
        return false !== filter_var($url, FILTER_VALIDATE_URL);
    }
}
