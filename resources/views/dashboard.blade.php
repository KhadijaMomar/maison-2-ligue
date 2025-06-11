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
        <div class="logo2" id="logout-trigger" style="cursor: pointer; display: flex; align-items: center; gap: 5px;">
            
            <i class='bx bx-menu'></i>
            <a href="listCollab.html">
                <span>Liste</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div><img src="{{ asset('storage/img/personne6.avif') }}" alt="photo representant une personnalité" ></div>
            <i class='bx bx-power-off'></i>
            <span>Deconnexion</span>
        </div>
    </header>
    <main>
        <section class="title">
            <h1>Bienvenue sur l'intranet 🚀</h1>
            <p>La plate-forme de l’entreprise qui vous permet de retouver tous vos collaborateurs</p>
        </section>
        <section class="bars">
        </section>
        
        <p>Avez vous dit bonjour à vos collègues:</p>
        <section class="sec-accueil">
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="photo representant une personnalité" class="img-pers">
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
            <section class="carte-accueil">
                <div class="img">
                  <img src="{{ asset('storage/img/personne1.jpg') }}" alt="" class="img-pers">
                </div>
                <div class="fonction">
                    <span>Marketing</span>
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
        </section>
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
</body>
</html>