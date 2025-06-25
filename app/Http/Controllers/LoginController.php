<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class LoginController extends Controller

{
     /**
     * Affiche le formulaire de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login', ['titre' => 'Connexion']);
    }
    /**
     * Affiche le formulaire de création d'un nouvel utilisateur.
     *
     * @return \Illuminate\View\View
     */
     public function creer()
    {
        return view('creer'); // Retourne la vue 'creer'
    }
     /**
     * Gère la soumission du formulaire de connexion.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

  /**
     * Gère l'affichage de la page d'accueil avec un utilisateur aléatoire.
     *
     * @return \Illuminate\View\View
     */
      public function accueil()
        {
            $authenticatedUserId = null;
            if (Auth::guard('utilisateur')->check()) {
                $authenticatedUserId = Auth::guard('utilisateur')->id();
            }

            $query = Utilisateur::query();

            // Exclure l'utilisateur connecté si l'ID est disponible
            if ($authenticatedUserId) {
                $query->where('id', '!=', $authenticatedUserId);
            }

            $randomUser = $query->inRandomOrder()->first();

            return view('accueil', ['randomUser' => $randomUser]);
        }


       /**
     * Affiche le tableau de bord pour un utilisateur non administrateur.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function dashboard()
    {
        if (!Auth::guard('utilisateur')->check() || Auth::guard('utilisateur')->user()->est_admin == 1) {
            return redirect('/login')->withErrors(['error' => 'Veuillez vous connecter.']);
        }
        $utilisateurs = Utilisateur::all();
        return view('dashboard', compact('utilisateurs'));
    }
       /**
     * Affiche le tableau de bord pour l'administrateur.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
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
     * Affiche le formulaire de modification d'un utilisateur.
     *
     * @param int|null $id L'ID de l'utilisateur à modifier (null si c'est l'utilisateur connecté).
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function modifier($id = null)
    {
        $isSelfEdit = false;
        $utilisateur = null;

        if ($id === null) {
            // L'utilisateur essaie de modifier son propre profil
            $utilisateur = Auth::guard('utilisateur')->user();
            if (!$utilisateur) {
                // Cette situation ne devrait pas se produire si le middleware 'auth.utilisateur' est actif
                return redirect()->route('login')->withErrors(['error' => 'Veuillez vous connecter pour modifier votre profil.']);
            }
            $isSelfEdit = true;
        } else {
            // Un administrateur modifie un autre utilisateur
            // S'assurer que seul un admin peut faire cela
            if (!Auth::guard('utilisateur')->check() || !Auth::guard('utilisateur')->user()->est_admin) {
                return redirect()->route('accueil')->withErrors(['error' => 'Accès non autorisé.']);
            }
            $utilisateur = Utilisateur::findOrFail($id);
        }

        // Renvoie la même vue 'modifier'
        return view('modifier', [
            'utilisateur' => $utilisateur,
            'isSelfEdit' => $isSelfEdit, // Passe un flag à la vue
            'isEdit' => true // Indique que c'est un formulaire d'édition
        ]);
    }

   /**
     * Gère la soumission du formulaire de mise à jour d'un utilisateur.
     *
     * @param Request $request
     * @param int|null $id L'ID de l'utilisateur à modifier (null si c'est l'utilisateur connecté).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id = null)
    {
        $isSelfEdit = false;
        $utilisateur = null;
        $loggedInUser = Auth::guard('utilisateur')->user(); // Récupère l'utilisateur actuellement connecté

        // Vérifiez si l'utilisateur est connecté. Si non, redirigez-le vers la page de connexion.
        if (!$loggedInUser) {
            return redirect()->route('login')->withErrors(['error' => 'Session expirée. Veuillez vous reconnecter.']);
        }

        // Détermine si c'est une auto-modification de profil ou la modification d'un autre utilisateur par un admin
        if ($id === null) {
            // C'est une auto-modification (l'utilisateur modifie son propre profil)
            $utilisateur = $loggedInUser;
            $isSelfEdit = true;

            // Définir la route de redirection en fonction du statut 'est_admin' de l'utilisateur connecté
            $redirectRoute = $loggedInUser->est_admin ? 'dashboardAdmin' : 'dashboard';
        } else {
            // Un administrateur modifie un autre utilisateur (via un ID)
            // Assurez-vous que seul un administrateur peut effectuer cette action
            if (!$loggedInUser->est_admin) {
                return redirect()->route('accueil')->withErrors(['error' => 'Accès non autorisé.']);
            }
            $utilisateur = Utilisateur::findOrFail($id);
            // Lorsqu'un administrateur modifie un autre utilisateur, il doit toujours être redirigé vers dashboardAdmin
            $redirectRoute = 'dashboardAdmin';
        }

        // Règles de validation pour les données du formulaire
        $rules = [
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // L'email doit être unique SAUF pour l'utilisateur actuellement modifié
                Rule::unique('utilisateur', 'email')->ignore($utilisateur->id),
            ],
            'phone' => 'nullable|string|max:15',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'civilite' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB
        ];

        // Le mot de passe est optionnel en modification.
        // Si les champs password ou password_confirmation sont remplis, ils deviennent requis et doivent correspondre.
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            // Si les champs de mot de passe sont laissés vides, ils ne sont pas requis.
            // La règle 'nullable|string|min:6|confirmed' gère bien ça, mais on peut être plus explicite si besoin.
            // Pour éviter une erreur si 'password' n'est pas rempli et n'est pas "nullable" on ajoute 'nullable' si ce n'est pas déjà fait.
            // Cependant, la ligne 'nullable|string|min:6|confirmed' dans la validation gère déjà ce cas.
        }


        // Le champ 'est_admin' ne peut être modifié que par un administrateur et seulement pour les AUTRES utilisateurs.
        if (!$isSelfEdit) {
            $rules['est_admin'] = 'nullable|boolean';
        }

        // Valider les données de la requête
        $data = $request->validate($rules);

        // --- Traitement de la photo de profil ---
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe et n'est pas la photo par défaut
            if ($utilisateur->photo && file_exists(public_path('storage/img/' . $utilisateur->photo)) && $utilisateur->photo !== 'default.jpg') {
                unlink(public_path('storage/img/' . $utilisateur->photo));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/img'), $filename);
            $data['photo'] = $filename;
        } else {
            // Si aucune nouvelle photo n'est uploadée, assurez-vous de ne pas écraser l'ancienne photo par null
            // si le champ photo était présent dans la validation mais non rempli.
            if (array_key_exists('photo', $data)) {
                unset($data['photo']);
            }
        }

        // --- Traitement du mot de passe ---
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Si le mot de passe est vide, retirez-le des données à mettre à jour
            unset($data['password']);
        }

        // --- Gestion du statut administrateur ---
        // Empêcher un utilisateur de modifier son propre statut d'administrateur
        if ($isSelfEdit) {
            unset($data['est_admin']); // Retire le champ 'est_admin' des données à mettre à jour
        } else {
            // Si ce n'est pas une auto-modification (donc un admin modifie un autre utilisateur),
            // traitez la valeur de la checkbox 'est_admin'.
            $data['est_admin'] = $request->has('est_admin'); // true si cochée, false sinon
        }

        // Mettre à jour l'utilisateur dans la base de données
        $utilisateur->update($data);

        // Rediriger l'utilisateur vers la page appropriée avec un message de succès
        return redirect()->route($redirectRoute)->with('success', 'Profil mis à jour avec succès.');
    }
    /**
     * Supprime un utilisateur et sa photo associée.
     *
     * @param int $id L'ID de l'utilisateur à supprimer.
     * @return \Illuminate\Http\RedirectResponse
     */
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

       /**
     * Gère la création d'un nouvel utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
}
