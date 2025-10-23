<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtCookieMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Ambil token dari cookie
            $token = $request->cookie('pcys');

            if (!$token) {
                return response()->json(['message' => 'Token cookie missing'], 401);
            }

            // Set token ke JWTAuth dan autentikasi user
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 401);
            }

            // Set user ke request agar bisa dipakai di controller
            $request->merge(['auth_user' => $user]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Unauthenticated', 'error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
