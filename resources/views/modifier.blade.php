{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>

</head>
<body>
    <h2>Bienvenue, {{ session('admin_email') }}</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Se déconnecter</button>
    </form>
    
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
     <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
 </head>
</head>
<body>
            <header class="header">
                        <div class="logo">
                            <img src="{{ asset('storage/img/intranet.png') }}" alt="">
                            <span>intranet</span>
                        </div>
                        <div class="logo2"  style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
                             @if(Auth::guard('utilisateur')->check() && Auth::guard('utilisateur')->user()->est_admin == 1)
                                {{-- Si l'utilisateur est connecté ET est un administrateur --}}
                                <i class='bx bx-menu'></i> 
                                <a href="{{ route('dashboardAdmin') }}">
                                    <span>Liste</span>
                                </a>
                            @else
                                {{-- Si l'utilisateur est connecté ET n'est PAS un administrateur (ou si Auth::check() est faux, mais le middleware gérera déjà ça) --}}
                                
                                <i class='bx bx-menu'></i> 
                                <a href="{{ route('dashboard') }}">
                                    <span>Liste</span>
                                </a>
                                 <i class='bx bx-user-plus'></i>
                                {{-- Nouveau lien pour ajouter un utilisateur --}}
                                <a href="{{ route('creerUtilisateur') }}">
                                    <span>Ajouter un utilisateur</span>
                                </a>
                            @endif
                           
                            @if(Auth::guard('utilisateur')->check())

                            <img src="{{ asset('storage/img/' . Auth::guard('utilisateur')->user()->photo) }}" alt="Photo de profil">
                             <span>{{ Auth::guard('utilisateur')->user()->name }}</span>
                            @else
                            <span>Non connecté</span>
                            @endif
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                             <i class='bx bx-power-off'></i>
                            <div id="logout-trigger" class="logout-trigger">
                            <span>Deconnexion</span>
                            </div>  
                        </div>
                    </header>
    <main>
        <section class="title">
             <h1>Modifier un membre</h1>
        </section>
        <section class="bars">
        </section>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <section class="form-search">
            <form action="{{ route('update', $utilisateur->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label for="civilite">*Civilité: </label>
                    <input type="text" name="civilite" value="{{ $utilisateur->civilite }}" placeholder="Homme">
                </div>
                <div>
                    <label for="categorie">*Categorie: </label>
                    <input type="text" name="categorie" value="{{ $utilisateur->categorie }}" placeholder="Client">
                </div>
                <div>
                    <label for="surname">*Nom: </label>
                    <input type="text" name="surname" value="{{ $utilisateur->surname }}" placeholder="Doe">
                </div>
                <div>
                    <label for="name">*Prenom: </label>
                    <input type="text" name="name" value="{{ $utilisateur->name }}" placeholder="John">
                </div>
                <div>
                    <label for="mail">*Email: </label>
                    <input type="mail" name="email" value="{{ $utilisateur->email }}" placeholder="example@gmail.com">
                </div>
                <div>
                    <label for="birth">*Date de naissance: </label>
                    <input type="date" name="birthdate" value="{{ $utilisateur->birthdate }}">
                </div>
                <div>
                    <label for="password">*Mot de passe: </label>
                    <input type="text" name="password" placeholder="min 8 caractères">
                </div>
                <div>
                    <label for="password">*Confirmation: </label>
                    <input type="text" name="password_confirmation" placeholder="min 8 caractères">
                </div>
                <div>
                    <label for="tel">*Telephone: </label>
                    <input type="text" name="phone" value="{{ $utilisateur->phone }}" placeholder="07 65 48 09 75">
                </div>
                <div>
                    <label for="pays">*Pays: </label>
                    <input type="text" name="country" value="{{ $utilisateur->country }}" placeholder="France">
                </div>
               <div>
                    <label for="photo">*Url de la photo: </label>
                    <input type="file" name="photo" id="photo"  accept="image/*" >
                    @if($utilisateur->photo)
                        <p>Photo actuelle: <img src="{{ asset('storage/img/' . $utilisateur->photo) }}" alt="Photo actuelle" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;"></p>
                    @endif
                </div>
                <button type="submit" class="button">Modifier le collaborateur</button>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>© - khadidiatou - 2025 <img src="https://img.shields.io/badge/Intranet-Active-brightgreen" alt="badge"></p>
    </footer>
    <script>
        document.getElementById('logout-trigger').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>
</body>
</html>