<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\Pagination;
use App\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineORMProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface, ProductFetcher
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
        $this->em = $this->getEntityManager();
    }

    public function add(Product $product): void
    {
        $this->em->persist($product);
    }

    public function save(): void
    {
        $this->em->flush();
    }

    public function findByLink(string $link): ?Product
    {
        return $this->findOneBy(['link' => $link]);
    }

    public function getPaginated(int $page = 1, $limit = 10): PaginationInterface
    {
        $offset = ($page - 1) * $limit;

        $query = $this->createQueryBuilder('p')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $paginator = new Paginator($query);
        $totalItems = count($paginator);

        return new Pagination(
            iterator_to_array($paginator->getIterator(), false),
            $totalItems,
            $page,
            $limit
        );
    }
}
