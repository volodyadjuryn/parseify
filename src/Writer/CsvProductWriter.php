<?php

namespace App\Writer;

use App\Entity\Product;
use League\Csv\Writer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CsvProductWriter
{
    private const string FILE_OPEN_MODE = 'a+';

    public function __construct(
        private readonly NormalizerInterface $normalizer,
        private readonly string $filePath,
    ) {
    }

    /**
     * @param Product[] $products
     */
    public function write(array $products): void
    {
        $csv = Writer::createFromPath($this->filePath, self::FILE_OPEN_MODE);
        $data = $this->normalizer->normalize($products);
        $csv->insertAll($data);
    }
}
