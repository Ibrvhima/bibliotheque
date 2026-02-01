<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLecteur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur a des pénalités impayées
        if ($user->hasPenalitesImpayees()) {
            return redirect()->route('lecteur.emprunts')
                ->with('warning', 'Vous avez des pénalités impayées. Veuillez les régulariser.');
        }

        return $next($request);
    }
}
