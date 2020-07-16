<?php


namespace App\Infrastructure\Input\Http\Api\Restful\V1;


use App\Infrastructure\Input\Http\Api\Restful\AbstractRestfulResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SomeResource extends AbstractRestfulResource
{
    public function get(Request $request): JsonResponse
    {
        return new JsonResponse([
            'id'   => $request->id,
            'name' => 'resource name',
            'attr' => 'resource attr',
        ]);
    }

    public function put(Request $request)
    {
        return new JsonResponse([
            'id'   => $request->id,
            'name' => $request->input('name'),
            'attr' => $request->input('attr'),
        ]);
    }
}
