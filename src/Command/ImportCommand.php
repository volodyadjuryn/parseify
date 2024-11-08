<?php

namespace App\Command;

use App\Exception\BusinessException;
use App\Factory\ProductFactory;
use App\Parser\Parser;
use App\Repository\ProductFetcher;
use App\Repository\ProductRepositoryInterface;
use App\Support\UrlHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCommand extends Command
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductFetcher $productFetcher,
        private readonly Parser $parser,
        private readonly ProductFactory $productFactory,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:import');
        $this->addArgument('url', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $url = $input->getArgument('url');
        $this->validateUrl($url);


        try {
            list('added' => $added, 'skipped' => $skipped) = $this->import($url);
        } catch (BusinessException $e) {
            $io->error($e->getUserMessage());

            return Command::FAILURE;
        }

        $io->success(sprintf('Imported %s products, skipped %s', $added, $skipped));

        return Command::SUCCESS;
    }

    private function validateUrl(string $url): void
    {
        if (!UrlHelper::isUrlValid($url)) {
            throw new \RuntimeException(sprintf('Invalid url: %s', $url));
        }
    }

    private function import(string $url): array
    {
        $added = $skipped = 0;

        $parsedProducts = $this->parser->parse($url);
        foreach ($parsedProducts as $parsedProduct) {
            $product = $this->productFactory->createFromProductDto($parsedProduct);

            if ($this->productFetcher->findByLink($product->getLink())) {
                ++$skipped;
                continue;
            }

            $this->productRepository->add($product);
            ++$added;
        }

        $this->productRepository->save();

        return ['added' => $added, 'skipped' => $skipped];
    }
}
