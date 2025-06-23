 <!DOCTYPE html> 
            <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
                            <h1>{{$titre}}</h1>
                            <!--<h1>Bienvenue sur l'intranet</h1>-->
                            <p>La plate-forme de l’entreprise qui vous permet de retouver tous vos collaborateurs</p>
                        </section>
                        <section class="bars">
                        </section>
                        <section class="sec-accueil-bien">
                        <p>Avez vous dit bonjour a :</p>
                        <section class="carte-accueil">
                            <div class="img">
                            <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                            </div>
                        <div class="items">
                                <div class="p">
                                    <p>Quentin Roger (36 ans)</p>
                                    <p>Saint pierre, France</p>
                                </div>
                                
                                <div class="social-icons">
                                    <div>
                                        <a href=""><i class='bx bxs-envelope'></i></a>
                                        <span>quentin.roger@example.com</span>
                                    </div>
                                    <div>
                                        <a href=""><i class='bx bxs-phone-call'></i></a>
                                        <span>04-78-23-87-90</span>
                                    </div>
                                    <div>
                                        <a href=""><i class='bx bxs-cake'></i></a>
                                        <span>Anniversaire : 11 Décembre</span>
                                    </div>
                                </div>
                        </div>
                        </section>
                        <button class="button">Dire bonjour</button>
                        <button class="button">Dire bonjour a quelqu’un d’autre</button>
        </section>
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
