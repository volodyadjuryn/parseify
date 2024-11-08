<?php

namespace App\Pagination;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaginationUrlGenerator implements PaginationUrlGeneratorInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function generate(int $page): string
    {
        $request = $this->requestStack->getMainRequest();

        $currentRouteName = $request->get('_route');

        parse_str((string) $request->getQueryString(), $queryParams);

        $queryParams['page'] = $page;

        return $this->urlGenerator->generate($currentRouteName, $queryParams);
    }
}
