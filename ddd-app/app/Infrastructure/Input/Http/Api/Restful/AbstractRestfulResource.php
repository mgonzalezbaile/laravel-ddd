<?php


namespace App\Infrastructure\Input\Http\Api\Restful;


use App\Infrastructure\Input\Http\Controller;
use Ddd\CommonCommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method ResponseInterface get(ServerRequestInterface $request)
 * @method ResponseInterface post(ServerRequestInterface $request)
 * @method ResponseInterface patch(ServerRequestInterface $request)
 * @method ResponseInterface put(ServerRequestInterface $request)
 * @method ResponseInterface delete(ServerRequestInterface $request)
 */
class AbstractRestfulResource extends Controller
{
    protected CommonCommandBus $commandBus;

    public function __construct(CommonCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $httpVerb = strtolower($request->getMethod());

        if (method_exists($this, $httpVerb)) {
            $response = $this->$httpVerb($request);
        } else {
            return new JsonResponse(strtoupper($httpVerb) . ' method is not allowed', 405);
        }

        return $response;
    }
}
