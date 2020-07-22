<?php


namespace App\Infrastructure\Input\Http\Api\Restful\V1;


use App\Domain\UseCase\CreateResource;
use App\Infrastructure\Input\Http\Api\Restful\AbstractRestfulResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class SomeResourceCollection extends AbstractRestfulResource
{
    public function get(Request $request): JsonResponse
    {
        $resources = DB::table('resources')
            ->where($this->filteredByQueryParams($request))
            ->paginate();

        return new JsonResponse($resources);
    }

    private function filteredByQueryParams(Request $request): ?array
    {
        $byName = $request->query('name') ? ['name', '=', $request->query('name')] : [];
        $byAttr = $request->query('attr') ? ['attr', '=', $request->query('attr')] : [];
        $byId   = $request->query('id') ? ['id', '=', $request->query('id')] : [];

        $query = [$byName, $byAttr, $byId];

        return array_values(array_filter($query));
    }

    public function post(Request $request)
    {
        $result = $this->commandBus->handle(new CreateResource(
            $request->input('name'),
            $request->input('attr'),
        ));

        return new JsonResponse(['id' => $result->entities()->first()->id()]);
    }
}
