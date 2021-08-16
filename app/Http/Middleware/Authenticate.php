<?php

namespace App\Http\Middleware;

use Closure;
use Helper\ResponseService;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Authenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return ResponseService::responseJson(CODE_UNAUTHORIZED, '', 'token not provided');
        }
        try {
            $user = auth('user')->user();
        } catch (TokenExpiredException $e) {
            return ResponseService::responseJson(CODE_UNAUTHORIZED, '', 'token expire');
        } catch (JWTException $e) {
            return ResponseService::responseJson(CODE_UNAUTHORIZED, $e->getMessage(), 'Exception');
        }

        if (!$user) {
            return ResponseService::responseJson(CODE_NOT_FOUND, '', 'user not found');
        }
        return $next($request);

    }
}
