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
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login', ['titre' => 'Connexion']);
    }
     public function creer()
    {
        return view('creer'); // Retourne la vue 'creer'
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

        $rules = [
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // L'email doit être unique SAUF pour l'utilisateur actuel
                Rule::unique('utilisateur', 'email')->ignore($utilisateur->id),
            ],
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:32768',
            'est_admin' => 'nullable|boolean',
            'civilite' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'est_admin' => 'nullable|boolean',
        ];

        // Rendre les champs de mot de passe conditionnellement requis
        // S'ils sont fournis, ils doivent être au moins de 6 caractères et confirmés
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            // Si aucun mot de passe n'est fourni, assurez-vous qu'ils ne soient pas validés comme "required"
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }


        $data = $request->validate($rules);

        // Gérer l'upload de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($utilisateur->photo && file_exists(public_path('storage/img/' . $utilisateur->photo))) {
                unlink(public_path('storage/img/' . $utilisateur->photo));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/img'), $filename);
            $data['photo'] = $filename;
        } else {
            // Si aucune nouvelle photo n'est uploadée, garder l'ancienne
            // Et ne pas unset la clé, si vous voulez conserver la valeur existante
            // C'est déjà géré par la validation si photo est nullable
        }

        // Si un nouveau mot de passe est fourni, le hasher
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Si le mot de passe est vide, retirez-le des données à mettre à jour pour ne pas écraser l'existant
            unset($data['password']);
        }

        
        // Si la checkbox n'est pas cochée, elle ne sera pas présente dans $request->all().
        // Donc, on la définit explicitement à false si elle n'est pas présente.
        $data['est_admin'] = $request->has('est_admin');

        $utilisateur->update($data);

        return redirect()->route('dashboardAdmin')
            ->with('success', 'Collaborateur mis à jour avec succès.');
    }

     public function destroy($id)
    {
        $collab = Utilisateur::findOrFail($id);
        // Supprimer la photo associée si elle existe
        if ($collab->photo && file_exists(public_path('storage/img/' . $collab->photo))) {
            unlink(public_path('storage/img/' . $collab->photo));
        }
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
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateur,email', // L'email doit être unique pour la création
            'password' => 'required|string|min:6|confirmed', // Mot de passe obligatoire à la création
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:32768',
            'est_admin' => 'nullable|boolean', // Gérer le statut d'admin
            'civilite' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
             'est_admin' => 'nullable|boolean',
        ]);

        // Hachage du mot de passe
        $data['password'] = Hash::make($data['password']);
        $data['est_admin'] = $request->has('est_admin'); 
        // Gérer l'upload de la photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/img'), $filename);
            $data['photo'] = $filename;
        } else {
            $data['photo'] = null; // Aucune photo uploadée
        }

        // Assurez-vous que 'est_admin' est défini à true si la checkbox est cochée, sinon false
        $data['est_admin'] = $request->has('est_admin');

        Utilisateur::create($data);

        return redirect()->route('dashboardAdmin')->with('success', 'Utilisateur ajouté avec succès !');
    }
}
