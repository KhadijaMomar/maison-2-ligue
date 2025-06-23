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
      @livewireStyles
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
            <h1>Bienvenue sur l'intranet 🚀</h1>
            <p>La plate-forme de l’entreprise qui vous permet de retouver tous vos collaborateurs</p>
        </section>
        <section class="bars">
        </section>
         @livewire('search-utilisateurs', ['isAdminView' => false])
        
        <button class="button">Dire bonjour a quelqu’un d’autre</button>
    </main>
    <footer class="footer">
        <p>© - khadidiatou - 2025 <img src="https://img.shields.io/badge/Intranet-Active-brightgreen" alt="badge"></p>
    </footer>
    <script>
        document.getElementById('logout-trigger').addEventListener('click', function() {
            document.getElementById('logout-form').submit();
        });
    </script>
     @livewireScripts
</body>
</html>
