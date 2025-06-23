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
      @livewireStyles
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
                                 <i class='bx bx-user-plus'></i>
                                {{-- Nouveau lien pour ajouter un utilisateur --}}
                                <a href="{{ route('creerUtilisateur') }}">
                                    <span>Ajouter un utilisateur</span>
                                </a>
                            @else
                                {{-- Si l'utilisateur est connecté ET n'est PAS un administrateur (ou si Auth::check() est faux, mais le middleware gérera déjà ça) --}}
                                
                                <i class='bx bx-menu'></i> 
                                <a href="{{ route('dashboard') }}">
                                    <span>Liste</span>
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
    <main>
        <section class="title">
            <h1>Créer un nouvel utilisateur</h1>
        </section>
        <section class="bars"></section>

        {{-- Inclusion du partiel du formulaire --}}
        @include('partial.form_utilisateur', [
            'actionRoute' => route('storeUtilisateur'),
            'method' => 'POST',
            'isEdit' => false
        ])
    </main>
    <footer class="footer">
        <p>© - khadidiatou - 2025</p>
    </footer>
    <script>
        document.getElementById('logout-trigger').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>
</body>
</html>