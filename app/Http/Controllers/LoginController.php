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
            // Redirige TOUS les utilisateurs, qu'ils soient admin ou non, vers la page d'accueil.
            return redirect()->intended(route('accueil')); 
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects ou compte inexistant',
        ])->withInput($request->only('email'));
    }
     public function accueil()
    {
        // Vérifie si l'utilisateur est connecté via le guard 'utilisateur'
        if (!Auth::guard('utilisateur')->check()) {
            return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        
      
        return view('accueil', ['titre' => 'Bienvenue sur l\'intranet']);
    
    }


    # Page après connexion
    public function dashboard()
    {
        if (!Auth::guard('utilisateur')->check()|| Auth::guard('utilisateur')->user()->est_admin == 1) {
            return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
         $utilisateurs = Utilisateur::all();
        return view('dashboard', compact('utilisateurs'));
    }

     public function dashboardAdmin()
    {
        // Vérifie si l'utilisateur est bien connecté via le guard 'utilisateur'
        // et s'il est bien un administrateur
        if (!Auth::guard('utilisateur')->check() || Auth::guard('utilisateur')->user()->est_admin == 0) {
            return redirect('/login')->withErrors(['error' => 'Accès non autorisé ou veuillez vous connecter.']);
        }
        $utilisateurs = Utilisateur::all();
        return view('dashboardAdmin', compact('utilisateurs'));
    }
     # Déconnexion
     public function logout()
     {
         Session::flush();
         return redirect('/login')->with('success', 'Déconnexion réussie.');
     }
     
     // Affiche le formulaire d'édition d'un collaborateur
     public function modifier($id)
     {
         $utilisateur = Utilisateur::findOrFail($id);
         return view('modifier', compact('utilisateur'));
     }

     // Met à jour le collaborateur en base de données
  public function update(Request $request, $id)
  {
      $utilisateur = Utilisateur::findOrFail($id);
     $data = $request->except('password');

if ($request->filled('password')) {
    $data['password'] = bcrypt($request->password);
}
    // Vérification et traitement de la photo
    $request->validate([
        'surname'    => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'email'  => 'nullable|email',
        'city'  => 'nullable|string|max:255',
        'country'   => 'nullable|string|max:255',
        'birthdate'   => 'nullable|date',
        'phone' => 'nullable|string|max:15',
        'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'est_admin' => 'nullable|boolean',
        'password' => 'nullable|string|min:6|confirmed',
    ]);
 if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/img'), $filename);
        $data['photo'] = $filename;
    }

    $utilisateur->update($data);
      $request->validate([
          'surname'    => 'nullable|string|max:255',
          'name' => 'nullable|string|max:255',
          'email'  => 'nullable|email',
          'city'  => 'nullable|string|max:255',
          'country'   => 'nullable|string|max:255',
          'birthdate'   => 'nullable|date',
          'phone' => 'nullable|string|max:15',
          'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'est_admin' => 'nullable|boolean',
          'password' => 'nullable|string|min:6|confirmed',
         
      ]);
    
      $utilisateur->update($request->only(['name', 'surname', 'email', 'city', 'country', 'birthdate', 'phone', 'photo', 'est_admin']));
    
      return redirect()->route('dashboardAdmin')
                       ->with('success', 'Collaborateur mis à jour avec succès.');
  }

  public function destroy($id)
{
    $collab = Utilisateur::findOrFail($id);
    $collab->delete();
    return redirect()->route('dashboardAdmin')->with('success', 'Utilisateur supprimé avec succès !');
}
}
