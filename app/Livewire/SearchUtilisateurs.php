<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\utilisateur; 
use Illuminate\Support\Facades\Auth;

class SearchUtilisateurs extends Component
{
    public $search = ''; // Propriété pour le champ de recherche général (nom, prénom, email)
    public $category = ''; // Propriété pour le champ de recherche par catégorie
    public $isAdminView = false;  //Propriété pour déterminer si c'est une vue administrateur

    // La méthode 'mount' est appelée lors de l'initialisation du composant.
    // Elle est utilisée pour initialiser les propriétés passées depuis la vue parente.
    public function mount($isAdminView = false)
    {
        $this->isAdminView = $isAdminView;
    }

    // La méthode 'rendering' est appelée avant que le composant ne soit rendu.
    // Nous définirons la logique de recherche ici.
    public function render()
    {
        $query = Utilisateur::query();

        // Exclure l'utilisateur actuellement connecté de la liste
        if (Auth::guard('utilisateur')->check()) {
            $query->where('id', '!=', Auth::guard('utilisateur')->id());
        }

        // Appliquer le filtre par terme de recherche général
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('surname', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Appliquer le filtre par catégorie
        if (!empty($this->category)) {
            $query->where('categorie', 'like', '%' . $this->category . '%');
        }

        $utilisateurs = $query->get();

        return view('livewire.search-utilisateurs', [
            'utilisateurs' => $utilisateurs,
        ]);
    }
}