<?php


namespace App\Infrastructure\Input\Http\Api\Restful\V1;


use App\Domain\UseCase\CreateResource;
use App\Domain\UseCase\CreateResourceUseCase;
use App\Infrastructure\Input\Http\Api\Restful\AbstractRestfulResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SomeResourceCollection extends AbstractRestfulResource
{
    private CreateResourceUseCase $useCase;

    public function __construct(CreateResourceUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function get(Request $request): JsonResponse
    {
        return new JsonResponse([
            [
                'id'   => '1',
                'name' => 'resource name',
                'attr' => 'resource attr',
            ],
            [
                'id'   => '2',
                'name' => 'resource name',
                'attr' => 'resource attr',
            ]
        ]);
    }

    public function post(Request $request)
    {
        $result = $this->useCase->execute(new CreateResource(
            $request->input('name'),
            $request->input('attr'),
        ));

        return new JsonResponse([
            'id'   => $result->aggregateRootList()->first()->id(),
            'name' => $result->aggregateRootList()->first()->name(),
            'attr' => $result->aggregateRootList()->first()->attr(),
        ]);
    }
}
