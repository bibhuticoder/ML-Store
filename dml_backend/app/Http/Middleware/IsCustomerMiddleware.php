<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class IsCustomerMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $request->auth;
        if(!$user) return response()->json(['message' => 'Not Logged In'], 401);
        if($user.role != 1) return response()->json(['message' => 'Access denied'], 401);
        return $next($request);
    }
}