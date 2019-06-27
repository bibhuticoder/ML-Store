<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        // dd($token);
        
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), array('HS256'));
        } catch(ExpiredException $e) {
            return response()->json([
                'message' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'An error while decoding token.'
            ], 400);
        }
        $user = User::find($credentials->sub);
        
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}