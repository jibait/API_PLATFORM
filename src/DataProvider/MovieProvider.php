<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Movie;
use App\Repository\MovieRepository;

final class MovieProvider implements RestrictedDataProviderInterface, ContextAwareCollectionDataProviderInterface
{

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Movie::class;
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = []): iterable
    {
        $page = isset($context["filters"]) ? ($context["filters"]["page"] ?? 1): 1;
        return $this->movieRepository->getMovies((int) $page);
    }
}
