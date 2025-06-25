{{--
Ce partiel est utilisé pour les formulaires de création et de modification d'utilisateur.
Variables requises:
- $actionRoute: La route Laravel à laquelle le formulaire doit être soumis (e.g., 'storeUtilisateur' ou 'update').
- $method: La méthode HTTP du formulaire ('POST' pour création, 'PUT' pour modification).
- $isEdit: Booléen indiquant si c'est un formulaire de modification (true) ou de création (false).
- $utilisateur (optionnel): L'objet utilisateur si $isEdit est true.
--}}
@php
    $isSelfEdit = $isSelfEdit ?? false; // Initialise si non défini, important !
@endphp
<section class="form-search">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $actionRoute }}" method="POST" enctype="multipart/form-data" class="form-add-edit">
        @csrf
        @if ($isEdit)
            @method($method) {{-- Utilise PUT pour la modification --}}
        @endif

        <div>
            <label for="surname">*Nom: </label>
            <input type="text" name="surname" value="{{ old('surname', $isEdit ? $utilisateur->surname : '') }}" placeholder="Dupont" required>
        </div>
        <div>
            <label for="name">*Prénom: </label>
            <input type="text" name="name" value="{{ old('name', $isEdit ? $utilisateur->name : '') }}" placeholder="Jean" required>
        </div>
      
        <div>
            <label for="phone">*Téléphone: </label>
            <input type="text" name="phone" value="{{ old('phone', $isEdit ? $utilisateur->phone : '') }}" placeholder="07 65 48 09 75">
        </div>
        <div>
            <label for="country">*Pays: </label>
            <input type="text" name="country" value="{{ old('country', $isEdit ? $utilisateur->country : '') }}" placeholder="France">
        </div>
        <div>
            <label for="city">*Ville: </label>
            <input type="text" name="city" value="{{ old('city', $isEdit ? $utilisateur->city : '') }}" placeholder="Paris">
        </div>
        <div>
            <label for="civilite">*Civilité: </label>
            <select name="civilite" id="civilite">
                <option value="">Sélectionner</option>
                <option value="Homme" {{ old('civilite', $isEdit ? $utilisateur->civilite : '') == 'Homme' ? 'selected' : '' }}>Homme</option>
                <option value="Femme" {{ old('civilite', $isEdit ? $utilisateur->civilite : '') == 'Femme' ? 'selected' : '' }}>Femme</option>
            </select>
        </div>
          <div>
            <label for="email">*Email: </label>
            <input type="email" name="email" value="{{ old('email', $isEdit ? $utilisateur->email : '') }}" placeholder="jean.dupont@example.com" required>
        </div>
        <div>
            <label for="password">*Mot de passe: </label>
            {{-- Le champ password est toujours saisissable. Le 'required' dépend de $isEdit --}}
            <input type="password" name="password" placeholder="{{ $isEdit ? 'Laisser vide pour ne pas changer' : 'min 6 caractères' }}" {{ $isEdit ? '' : 'required' }}>
        </div>
        <div>
            <label for="password_confirmation">*Confirmation: </label>
            <input type="password" name="password_confirmation" placeholder="{{ $isEdit ? 'Confirmer le nouveau mot de passe' : 'min 6 caractères' }}" {{ $isEdit ? '' : 'required' }}>
        </div>
        <div>
            <label for="birthdate">*Date de naissance: </label>
            <input type="date" name="birthdate" value="{{ old('birthdate', $isEdit ? $utilisateur->birthdate : '') }}">
        </div>
        
        <div>
            <label for="categorie">*Catégorie: </label>
            <input type="text" name="categorie" value="{{ old('categorie', $isEdit ? $utilisateur->categorie : '') }}" placeholder="Développeur">
        </div>
        <div>
            <label for="photo">*Photo de profil: </label>
            <input type="file" name="photo" id="photo" accept="image/*">
            @if($isEdit && $utilisateur->photo)
                <p>Photo actuelle: <img src="{{ asset('storage/img/' . $utilisateur->photo) }}" alt="Photo actuelle" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"></p>
            @endif
        </div>
             @if (!$isSelfEdit)
            <div>
                <label for="est_admin">Est administrateur: </label>
                <input type="checkbox" name="est_admin" value="1" {{ old('est_admin', $isEdit && $utilisateur->est_admin) ? 'checked' : '' }}>
            </div>
        @else
            {{-- <p>Votre statut d'administrateur ne peut pas être modifié ici.</p> --}}
        @endif
        <button type="submit" class="button">{{ $isEdit ? 'Modifier le collaborateur' : 'Ajouter le collaborateur' }}</button>
    </form>
</section>