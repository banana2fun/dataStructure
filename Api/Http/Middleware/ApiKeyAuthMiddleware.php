<?php

namespace Api\Http\Middleware;

use Api\Helper\ApiStatusCode;
use Api\Http\Resources\ErrorResource;
use Api\Http\Responses\ErrorResponse;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Onex\AuthPackage\Authentication;

/**
 * Class ApiKeyAuthMiddleware
 * Миддлваре для разовой авторизации пользователя по apiKey
 *
 * @package Api\Http\Middleware
 */
class ApiKeyAuthMiddleware
{
    /** @var Authentication */
    private $authentication;

    /**
     * ApiKeyAuthMiddleware constructor.
     *
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->headers->get('Authorization');
        try {
            $this->authentication->authorizeLaravelAndYiiByApiKey($apiKey);
        } catch (ModelNotFoundException $authenticationException) {
            $error = new ErrorResponse('apiKey', ApiStatusCode::AUTHORIZATION_ERROR,
                'Ошибка авторизации', 'Требуется авторизация');
            return new ErrorResource($error);
        }
        return $next($request);
    }
}
