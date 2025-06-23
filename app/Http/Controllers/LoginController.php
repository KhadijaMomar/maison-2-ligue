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
        if (!Auth::guard('utilisateur')->check()) {
            return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }

        // 1. Essayer de trouver un utilisateur aléatoire qui n'est PAS admin.
        $collaborateur = Utilisateur::where('est_admin', 0)
            ->inRandomOrder() // Sélectionne un enregistrement au hasard
            ->first();

        // 2. Si aucun non-admin n'est trouvé (par exemple, seulement des admins existent ou DB vide)
        if (!$collaborateur) {
            // Tente de trouver n'importe quel utilisateur aléatoire, y compris les admins,
            // au cas où il n'y aurait aucun collaborateur non-admin dans la BD.
            $collaborateur = Utilisateur::inRandomOrder()->first();
        }

        // 3. Passe le collaborateur (ou null si la DB est complètement vide) et le titre à la vue.
        return view('accueil', [
            'collaborateur' => $collaborateur, // Peut être null si la table 'utilisateur' est vide
            'titre' => 'Bienvenue sur l\'intranet'
        ]); // **********************************************************
    }

    # Page après connexion
    public function dashboard()
    {
        if (!Auth::guard('utilisateur')->check() || Auth::guard('utilisateur')->user()->est_admin == 1) {
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
    
    
    /**
     * Gère la déconnexion de l'utilisateur.
     *
     * Cette fonction termine la session de l'utilisateur et le redirige vers la page de connexion
     * avec un message de succès.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Affiche le formulaire d'édition d'un collaborateur.
     *
     * @param int $id L'ID du collaborateur à modifier.
     * @return \Illuminate\View\View
     */
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
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif|max:1048576',
            'est_admin' => 'nullable|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        // Gestion de l'upload de la photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Le chemin de sauvegarde est public_path('storage/img')
            // Assurez-vous que le dossier 'storage/img' existe et est accessible en écriture
            $file->move(public_path('storage/img'), $filename);
            $data['photo'] = $filename; // Enregistre le nom du fichier dans le tableau de données
        } else {
            unset($data['photo']); // Si aucune nouvelle photo n'est uploadée, ne pas essayer de mettre à jour le champ photo
        }

        $utilisateur->update($data);

        return redirect()->route('dashboardAdmin')
            ->with('success', 'Collaborateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $collab = Utilisateur::findOrFail($id);
        $collab->delete();
        return redirect()->route('dashboardAdmin')->with('success', 'Utilisateur supprimé avec succès !');
    }
    public function sayHello(Request $request, $id)
    {
        $collaborateur = Utilisateur::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Vous avez dit bonjour à ' . $collaborateur->name . ' ' . $collaborateur->surname . ' !'
        ]);
    }
}
