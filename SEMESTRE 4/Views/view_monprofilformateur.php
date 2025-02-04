<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/profiles.css"> 

<form action="?controller=profile&action=modifier" method="POST"> <!-- Formulaire pour modifier le profil avec une action de contrôleur spécifique -->
    <div class="card2 shadow"> <!-- Carte de profil avec ombre -->
        <div class="texte">
            <div class="titre">
                <div class="text-container h1"><h1>Mon profil</h1></div> <!-- Titre du profil -->
            </div>
        </div>
        <div class="texte">
            <div class="cercle">
                <img class="cercle" src="Content/img/<?= $data['photo_de_profil'] ?>" alt="Photo de profil"> <!-- Affichage de la photo de profil -->
            </div>
            <div class="information">
                <div class="sous-titre">
                    <div class="text-container h2">Nom Prénom</div>
                    <div class="text-container p">
                        <p><?php echo $nom . ' ' . $prenom ?></p> <!-- Affichage du nom et prénom -->
                    </div> 
                </div>
                <div class="sous-titre">Adresse mail</div>
                <div class="encadrermonprofil">
                    <div class="txt-encadrer"><?php echo $mail ?></div> <!-- Affichage de l'adresse mail -->
                </div>
                <div class="sous-titre">Mot de passe</div>
                <div class="encadrermonprofil">
                    <div class="txt-encadrer">***********</div> <!-- Affichage du mot de passe (masqué) -->
                </div>
                <div class="sous-titre">LinkedIn</div>
                <div class="encadrermonprofil">
                    <div class="txt-encadrer"><?php echo $formateur['linkedin']; ?></div> <!-- Affichage du lien LinkedIn -->
                </div>
                <div class="sous-titre">CV</div>
                <div class="encadrermonprofil">
                    <div class="txt-encadrer"><?php echo $formateur['cv']; ?></div> <!-- Affichage du lien vers le CV -->
                </div>
                <div class="sous-titre">Mes compétences </div>

                <?php foreach ($competences as $categorie => $themes) : ?> <!-- Boucle sur les compétences par catégorie et thèmes -->
                    <div class="encadrermonprofil">
                        <div class="txt-encadrer">
                            <?= htmlspecialchars($categorie) ?> <!-- Affichage de la catégorie -->
                            <?php foreach ($themes as $theme) : ?> <!-- Boucle sur les thèmes de la catégorie -->
                                (<?= htmlspecialchars($theme['theme']) ?>:<?= htmlspecialchars($theme['niveau']) ?>) <!-- Affichage du thème et de son niveau -->
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" id="btnmodifier"> Modifier</button> <!-- Bouton de soumission pour modifier le profil -->
            </div>
        </div>
    </div>
</form>

<?php require "view_end.php"; ?>
