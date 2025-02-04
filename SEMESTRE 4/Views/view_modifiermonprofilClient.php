<?php require "view_begin.php"; ?>
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/profiles.css"> 

<script>
    function annulerModification() { // Fonction JavaScript pour annuler la modification et rediriger vers le contrôleur de profil
        window.location.href = '?controller=profile';
    }
</script>

<form action="?controller=profile&action=modifier_info" method="POST"> <!-- Formulaire pour modifier les informations du profil -->
    <div class="card2 shadow"> <!-- Carte pour le contenu du formulaire -->
        <div class="texte">
            <div class="titre">
                <div class="text-container h1"><h1>Modifier votre profil</h1></div> <!-- Titre de la section pour modifier le profil -->
            </div>
        </div>
        <div class="texte">
            <div class="cercle">
                <img class="cercle" src="Content/img/<?= $data['photo_de_profil'] ?>" alt="Photo de profil"> <!-- photo de profil -->
            </div>
            <div class="information">
                <div class="sous-titre">
                    <div class="text-container h2">Nom Prénom</div> <!--  le nom et prénom -->
                    <div class="text-container p"><p> Akkou Layn</p></div> <!-- Affichage du nom et prénom -->
                </div>
                <div class="sous-titre">Adresse e-mail</div> <!--  l'adresse e-mail -->
                <input class="encadrer" type="email" name="nouvelle_email" value="<?= $mail ?>" required> <!-- Champ pour entrer la nouvelle adresse e-mail -->
                <div class="sous-titre">Nouveau mot de passe</div> <!--  le nouveau mot de passe -->
                <input class="encadrer" type="password" name="nouveau_mot_de_passe"> <!-- Champ pour entrer le nouveau mot de passe -->
                <div class="sous-titre">Société principale</div> <!--  la société principale -->
                <input class="encadrer" type="text" name="nouvelle_societe" value="<?= (isset($societe) && $societe !== false) ? $societe['societe'] : ""; ?>" required> <!-- Champ pour entrer le nom de la société principale -->
            </div>
            <br>
            <button type="button" id="btnannuler" onclick="annulerModification()"> Annuler</button> <!-- Bouton pour annuler la modification -->
            <button type="submit" id="btnenregistrer"> Enregistrer</button> <!-- Bouton pour enregistrer les modifications -->
        </div>
    </div>
</form>

<?php require "view_end.php"; ?> 
