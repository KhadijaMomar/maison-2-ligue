<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Collaborateur;
use App\Models\utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
      // Affiche le formulaire de connexion
      public function showLogin()
      {
        return view('auth.login', ['titre' => 'Connexion']);
      }
        public function handleLogin(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email:rfc,dns',
                'password' => 'required|min:6'
            ], [
                'email.required' => 'L\'adresse email est obligatoire',
                'password.min' => 'Le mot de passe doit contenir au moins 6 caractères'
            ]);
        
              // Tentative de connexion Admin
        if (Auth::guard('utilisateur')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $admin = Auth::guard('utilisateur')->user();
           // Session::put('admin', $admin);

            return redirect()->intended('/utilisateur/dashboard');
        }

        // Tentative de connexion Collaborateur
        // if (Auth::guard('collaborateur')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        //     $collaborateur = Auth::guard('collaborateur')->user();
        //    // Session::put('collaborateur', $collaborateur);

        //     return redirect()->intended('/collaborateur/dashboard');
        // }

        return back()->withErrors([
            'email' => 'Identifiants incorrects ou compte inexistant',
        ])->withInput($request->only('email'));
    }
    # Page après connexion
    public function dashboard()
    {
       
        
        if (!Auth::guard('utilisateur')->check()) {
            return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        return view('dashboard');
    }
     # Déconnexion
     public function logout()
     {
         Session::flush();
         return redirect('/login')->with('success', 'Déconnexion réussie.');
     }
}
