 <!DOCTYPE html> 
            <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
            
                    <title>connexion</title>
            
                    <!-- Fonts -->
                    <link rel="preconnect" href="https://fonts.bunny.net">
                    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
                    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
                </head>
                <body>
                    <header class="header">
                        <div class="logo">
                            <img src="{{ asset('storage/img/intranet.png') }}" alt="Photo">
                            <span>intranet</span>
                        </div>
                        <span>Connexion</span>
                    </header>
                    <main>
                        <section class="title">
                            <h1>{{$titre}}</h1>
                        </section>
                        <section class="bars">
                        </section>
                        <section class="carte">
                            <p>Bienvenue pour vous connecter a l’intranet 
                                veuiller saisir votre identifiant et mot de passe</p>
                            <section class="form">
                                <form action="" >
                                    <input type="text" placeholder="Votre email">
                                    <input type="text" placeholder="Votre mot de passe">
                                    <a href="accueil.html"><input type="button" value="Connexion"></a>
                                </form>
                            </section>
                        </section>
                    </main>
                    <footer class="footer">
                        <p>© - khadidiatou - 2025</p>
                    </footer>
</body>
</html>
