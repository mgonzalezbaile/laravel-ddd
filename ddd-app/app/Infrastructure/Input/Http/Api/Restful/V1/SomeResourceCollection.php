<?php


namespace App\Infrastructure\Input\Http\Api\Restful\V1;


use App\Infrastructure\Input\Http\Api\Restful\AbstractRestfulResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SomeResourceCollection extends AbstractRestfulResource
{
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
        return new JsonResponse([
            'id'   => '3',
            'name' => $request->input('name'),
            'attr' => $request->input('attr'),
        ]);
    }
}
