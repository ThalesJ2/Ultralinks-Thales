<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class UserProtected extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {

            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json([
                    'messageError' => "Unauthorized",
                    'message'=>'Token is invalid',
                    'statusCode' => 401,
                    'timestamp' => date("Y-m-d h:i:sa")
                ], 401);
            }
            else
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json([
                    'messageError' => "Unauthorized",
                    'message'=>'Token is expired',
                    'statusCode' => 401,
                    'timestamp' => date("Y-m-d h:i:sa")
                ], 401);
            }

            else
                return response()->json([
                    'messageError' => "Unauthorized",
                    'message'=>'Authorization Token not Found',
                    'statusCode' => 401,
                    'timestamp' => date("Y-m-d h:i:sa")
                ], 401);

        }

        return $next($request);
    }
}
