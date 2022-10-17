<?php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Model\MediaType;
use ApiPlatform\Core\OpenApi\Model\Response;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;

final class MovieApiFactory implements OpenApiFactoryInterface{

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $randomItem = $openApi->getPaths()->getPath('/api/movies/random');
        $getItem = $openApi->getPaths()->getPath('/api/movies/{id}');
        $randomOperation = $randomItem->getGet();
        $getOperation = $getItem->getGet();
        $randomOperation->addResponse($getOperation->getResponses()[200],200);
        $randomOperation = $randomOperation->withDescription('Retrieve random Movie resource')->withSummary('Retrieve random Movie resource');
        $randomItem = $randomItem->withGet($randomOperation);
        $openApi->getPaths()->addPath('/api/movies/random', $randomItem);
        return $openApi;
    }
}