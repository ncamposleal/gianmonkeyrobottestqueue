<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ApiAuthentication
{
    public function handle($request, Closure $next)
    {
        Log::info('Iniciando Validacion de usuario');
        $token = $request->header('Authorization');
        Log::info('Header authorization' .$token);
        $user = \App\User::where('api_token', $token)->first();
        if ($user) {
            Log::info('Usuario existe'.$user);
            auth()->login($user);
            return $next($request);
        }
        
        Log::info('Usuario no existe');
        return response([
            'message' => 'Unauthenticated'
        ], 403);
    }
}