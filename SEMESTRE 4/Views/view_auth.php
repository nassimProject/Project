<?php require "view_begin.php"; ?>

<link rel="stylesheet" href="Content/css/auth.css" />

<nav>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="?controller=auth&action=register" method="post">
                <nobr>
                    <h1>Créer un compte</h1>
                </nobr><br> <!-- Titre du formulaire d'inscription -->
                <div class="container2">
                    <div class="tabs"> <!-- Section pour sélectionner le type de compte (Formateur ou Client) -->
                        <input type="radio" id="radio-1" name="tabs" value="formateur" checked="">
                        <label class="tab" for="radio-1">Formateur</label>
                        <input type="radio" id="radio-2" name="tabs" value="client">
                        <label class="tab" for="radio-2">Client</label>
                        <span class="glider"></span>
                    </div>
                    <br>
                </div>
                <span></span>
                <input type="text" name="nom" placeholder="Nom" required /> <!-- Champ pour le nom -->
                <input type="text" name="prenom" placeholder="Prénom" required /> <!-- Champ pour le prénom -->
                <input type="email" name="email" placeholder="Email" required /> <!-- Champ pour l'email -->
                <input type="password" name="password" placeholder="Mot de passe" required /><br> <!-- Champ pour le mot de passe -->
                <input type="submit" value="S'enregistrer" class="blanc button" /> <!-- Bouton de soumission -->
            </form>
        </div>
        <div class="form-container sign-in-container"> <!-- le formulaire de connexion -->
            <form action="?controller=auth&action=login" method="post">
                <h1>Se connecter</h1>
                <input type="email" name="email" placeholder="Email" required /> <!-- Champ pour l'email -->
                <input type="password" name="password" placeholder="Mot de passe" required /> <!-- Champ pour le mot de passe -->
                <a href="#">Mot de passe oublié?</a> <!-- récupérer le mot de passe oublié -->
                <input type="submit" value="Se connecter" class="blanc button" /> <!-- Bouton de soumission pour la connexion -->
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left"> <!-- Panel de gauche de l'overlay -->
                    <h1>Vous avez déjà un compte?</h1>
                    <p>Pour rester connecté, mettez vos informations personnelles</p>
                    <button class="ghost button" id="signIn">Se connecter</button> <!-- Bouton pour basculer vers le formulaire de connexion -->
                </div>
                <div class="overlay-panel overlay-right"> <!-- Panel de droite de l'overlay -->
                    <h1>Vous êtes nouveaux?</h1>
                    <p>Inscrivez-vous pour publier ou consulter des formations</p>
                    <button class="ghost button" id="signUp">S'enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</nav>

<script src="Content/script/auth.js"></script> <!-- Inclusion du script JavaScript pour gérer l'authentification -->

<?php require "view_end.php"; ?>