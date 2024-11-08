<?php

namespace App\Controller;

use App\Pagination\FractalPaginationAdapter;
use App\Pagination\PaginationUrlGeneratorInterface;
use App\Repository\ProductFetcher;
use App\Transformer\ProductTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    private const string RESOURCE_KEY = 'product';

    public function __construct(
        private readonly Manager $fractalManager,
    ) {
    }

    #[Route('/products')]
    public function index(Request $request, ProductFetcher $productFetcher, ProductTransformer $transformer, PaginationUrlGeneratorInterface $paginationUrlGenerator): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $pagination = $productFetcher->getPaginated($page, $limit);

        $resource = new Collection($pagination->getItems(), $transformer, self::RESOURCE_KEY);
        $resource->setPaginator(new FractalPaginationAdapter($pagination, $paginationUrlGenerator));

        return new JsonResponse($this->fractalManager->createData($resource)->toArray());
    }
}
