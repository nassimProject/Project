<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/profiles.css">

<form action="?controller=profile&action=modifier" method="POST"> 
    <div class="card2 shadow"> 
        <div class="texte">
            <div class="titre">
                <div class="text-container h1"><h1>Mon profil</h1></div> 
            </div>
        </div>
        <div class="texte">
            <div class="cercle">
                <img class="cercle" src="Content/img/<?= $data['photo_de_profil'] ?>" alt="Photo de profil"> <!--  la photo de profil -->
            </div>
            <div class="information">
                <div class="sous-titre">
                    <div class="text-container h2">Nom Prénom</div>
                    <div class="text-container p"><p><?= $nom ?> <?= $prenom ?></p></div> <!-- nom et prénom -->
                </div>
                <div class="sous-titre">Adresse mail</div>
                <div class="encadrermonprofil"><div class="txt-encadrer"><?= $mail ?></div></div> <!--  l'adresse mail -->
                <div class="sous-titre">Mot de passe</div>
                <div class="encadrermonprofil"><div class="txt-encadrer">***********</div></div> <!-- mot de passe (masqué) -->
                <div class="sous-titre">Société principale</div>
                <div class="encadrermonprofil">
                    <div class="txt-encadrer">
                        <?php if (isset($societe) && $societe !== false) { // Vérifie si une société est définie
                            echo $societe['societe']; // Affiche le nom de la société
                        } else {
                            echo "Aucune société"; // Affiche un message si aucune société n'est définie
                        } ?>
                    </div>
                </div>
            </div>
            <button type="submit" id="btnmodifier"> Modifier</button> <!-- Bouton de soumission pour modifier le profil -->
        </div>
    </div>
</form>

<?php require "view_end.php"; ?> 