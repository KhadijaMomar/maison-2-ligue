<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->withErrors(['error' => 'Accès réservé aux administrateurs.']);
        }
        
          // Vérification supplémentaire optionnelle
        //   $admin = Auth::guard('admin')->user();
  
        //   // Exemple : Vérifier si le compte est actif
        //   if (!$admin->is_active) {
        //       Auth::guard('admin')->logout();
        //       return redirect()->route('login')->withErrors(['error' => 'Compte administrateur désactivé']);
        //   }
        return $next($request);
    }
}

