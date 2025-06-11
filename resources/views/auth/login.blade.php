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
                <h1>Connexion</h1>
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            </section>
            <section class="bars">
            </section>
            <section class="carte">
                <p>Bienvenue pour vous connecter a l’intranet 
                    veuiller saisir votre identifiant et mot de passe</p>
                <section class="form">
                    <form action="{{ url('/login') }}" method="POST" >
                        @csrf
                        <input type="text" name="email" placeholder="Votre email">
                        <input type="password" name="password" placeholder="Votre mot de passe">
                        <input type="submit" value="Connexion">
                    </form>
                </section>
            </section>
        </main>
        <footer class="footer">
            <p>© - khadidiatou - 2025</p>
        </footer>
</body>
</html>
