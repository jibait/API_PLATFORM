<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MovieRepository;

final class RandomMovie{

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function __invoke()
    {
        return $this->movieRepository->getRandomMMovie();
    }
}