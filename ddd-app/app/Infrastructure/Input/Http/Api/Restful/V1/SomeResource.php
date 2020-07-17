<?php


namespace App\Infrastructure\Input\Http\Api\Restful\V1;


use App\Domain\UseCase\UpdateResource;
use App\Infrastructure\Input\Http\Api\Restful\AbstractRestfulResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class SomeResource extends AbstractRestfulResource
{
    public function get(Request $request): JsonResponse
    {
        $resource = DB::table('resources')->find($request->id);

        return new JsonResponse($resource);
    }

    public function put(Request $request)
    {
        $this->commandBus->handle(new UpdateResource(
            $request->id,
            $request->input('name'),
            $request->input('attr'),
        ));

        return new Response('', 204);
    }
}
