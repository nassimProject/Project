<?php require "view_begin.php"; ?> <!-- Inclut le fichier de début de vue -->
<?php //require "view_menu.php"; ?> 

<!-- IMPORT DE RESSOURCES EXTERNES -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,600,0,0" />

<!-- STYLESHEET -->
<link rel="stylesheet" href="Content/css/accueil.css"> 

<nav>
    <div class="container nav__container"> <!-- Conteneur principal de la barre de navigation -->
        <ul class="nav__items">
            <li><a href="index.html" id="home">Home</a></li> <!-- Lien vers la page d'accueil -->
        </ul>
        <a href="index.html" class="nav__logo"><h3>Perform Vision</h3></a> <!-- Logo et titre de l'entreprise -->
        <div class="nav__signin-signup"> <!-- Section pour se connecter ou s'inscrire -->
            <a href="?controller=auth">Se Connecter</a> <!-- Lien pour se connecter -->
            <a href="?controller=auth" class="btn">S'inscrire</a> <!-- Lien pour s'inscrire -->
        </div>
    </div>
</nav>

<header>
    <div class="container header__container "> <!-- Conteneur principal du header -->
        <h1 class="header__title">Perform Vision<br/>Formation</h1> <!-- Titre principal -->
        <p class="lead">Chez Perform Vision, nous croyons au pouvoir de la croissance continue et du développement professionnel. Notre plateforme a été conçue pour connecter ceux qui aspirent à enrichir leurs connaissances informatiques et des formateurs dévoués, prêts à guider votre parcours vers l'excellence.</p> <!-- Description -->
        <div class="header__image"> <!-- Image associée au header -->
            <img src="Content/img/sansFond.png">
        </div>
        <div class="cta"> <!-- un CTA (call to action, appel a l'action) est un élément généralement utilisé pour inciter les visiteurs à effectuer une action -->
            <a href="?controller=auth" class="btn btn-primary" target="_blank">
                <div class="logo">
                    <span class="material-symbols-outlined">
                        passkey
                    </span>
                </div>
                <span>
                    <h4>Se Connecter</h4>
                </span>
            </a>
            <a href="?controller=auth" class="btn btn-primary" target="_blank">
                <div class="logo">
                    <span class="material-symbols-outlined">
                        login
                    </span>
                </div>
                <span>
                    <h4>S'inscrire</h4>
                </span>
            </a>
        </div>
    </div>
    <div class="header__decorator-1"> <!-- Décoration du header -->
        <img src="Content/img/header-decorator1.png">
    </div>
</header>

<section id="about">
    <h1 class="about__title">À propos</h1> <!-- Titre de la section à propos -->
    <div class="container"> 
        <!-- Article 1 -->
        <article class="about__article">
            <div class="about__image">
                <img src="Content/img/2.png"> <!-- Image de l'article -->
            </div>
            <div class="about__content">
                <h2 class="about__article-title">Recherche de Formateurs</h2> 
                <p>Utilisez notre fonction de recherche avancée pour trouver le formateur idéal correspondant à vos besoins spécifiques. Que vous soyez un professionnel cherchant à acquérir de nouvelles compétences ou une entreprise en quête d'une expertise spécifique, Perform Vision est votre source incontournable.</p> <!-- Contenu de l'article -->
                <a href="#" class="btn btn-primary">S'inscrire</a> <!-- Bouton pour s'inscrire -->
            </div>
        </article>
        <!-- Article 2 -->
        <article class="about__article">
            <div class="about__content">
                <h2 class="about__article-title">Suivi en Temps Réel</h2>
                <p>Explorez une approche innovante de la formation avec notre suivi en temps réel. Chaque étape de votre parcours est transparente, offrant une visibilité instantanée sur votre progression. Bénéficiez d'une expérience éducative connectée, où votre réussite est au cœur de notre engagement.</p>
                <a href="#" class="btn btn-primary">S'inscrire</a> <!-- Bouton pour s'inscrire -->
            </div>
            <div class="about__image">
                <img src="Content/img/1.png">
            </div>
        </article>
        <!-- Article 3 -->
        <article class="about__article">
            <div class="about__image">
                <img src="Content/img/3.png">
            </div>
            <div class="about__content">
                <h2 class="about__article-title">Un Lieu de Partage</h2>
                <p>Questions? Besoin de Conseils? Nous sommes là pour vous. Échangez directement avec votre formateur, échangez des idées et obtenez des conseils d'experts. Que vous soyez un formateur prêt à partager votre savoir ou un professionnel assoiffé de connaissances, Perform Vision est la passerelle vers un monde de possibilités d'apprentissage. Inscrivez-vous dès maintenant et faites partie de notre communauté dynamique axée sur la croissance et l'excellence.</p>
                <a href="#" class="btn btn-primary">S'inscrire</a> <!-- Bouton pour s'inscrire -->
            </div>
        </article>
    </div>
</section>

<section id="clients">
    <h1>Nos Autres Activités</h1> 
   
