<?php

namespace App\Http\Middleware;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException  $e) {
            // if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
            //     return response()->json(['error' => 'Token is Invalid']);
            // }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
            //     return response()->json(['error' => 'Token is Expired']);
            // }else{
            //     return response()->json(['error' => 'Authorization Token not found']);
            // }
            return response()->json(['error' => 'Unauthorized'], 401, ['X-Header-One' => 'Header Value']);
        }
        return $next($request);
    }
}
