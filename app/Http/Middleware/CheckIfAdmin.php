<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    /**
     * Vérifie si l'utilisateur connecté a le rôle "admin".
     */
    private function checkIfUserIsAdmin($user)
    {
        return $user && $user->hasRole('Admin'); // Vérifie si l'utilisateur a le rôle 'admin'
    }

    /**
     * Gère la réponse en cas d'accès non autorisé.
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return redirect()->route('home'); // Redirige vers la page de connexion
    }

    /**
     * Gère l'accès à l'admin panel.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !$this->checkIfUserIsAdmin(Auth::user())) {
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }
}
