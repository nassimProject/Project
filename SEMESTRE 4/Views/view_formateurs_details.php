<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/profildes.css" /> 

<div class="formateurs-container"> 
    <article class="card"> 
        <div class='content'> <!-- Contenu de la carte -->

            <!-- En-tête de la carte avec le nom complet du formateur -->
            <div class="card-header">
                <div class="latest-article">
                    <?php echo $formateur['prenom'] . ' ' . $formateur['nom']; ?>
                </div>
            </div>

            <!-- Section des compétences du formateur -->
            <div class="competences title">
                Compétences :
            </div>
            <div class="competences values">
                <?php foreach ($categories as $categorie) : ?>
                    <?php echo $categorie['nom_categorie']; ?>, <!-- Affiche chaque catégorie de compétence -->
                <?php endforeach; ?>
            </div>

            <!-- Section des sous-catégories du formateur -->
            <div class="sous-categories title">
                Sous catégories :
            </div>
            <div class="sous-categories values">
                <?php foreach ($themes as $theme) : ?>
                    <?php echo $theme['nom_theme']; ?>, <!-- Affiche chaque sous-catégorie -->
                <?php endforeach; ?>
            </div>

            <!-- Section de l'expertise professionnelle du formateur -->
            <div class="expertise title">
                Expertise professionnelle :
            </div>
            <div class="expertise values">
                <ul>
                    <?php foreach ($expertises as $expertise) : ?>
                        <li>
                            <p>Thème: <?php echo $expertise['nom_theme']; ?></p>
                            <p>Durée de l'Expérience: <?php echo $expertise['duree_experience']; ?> heures</p>
                            <?php foreach ($niveaux as $niveau) : ?>
                                <?php if ($niveau['id_niveau'] === $expertise['id_niveau']) : ?>
                                    <p>Niveau: <?php echo $niveau['libelle_niveau']; ?></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <p>Commentaire: <?php echo $expertise['commentaire']; ?></p>
                        </li>
                        <br>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Section des expériences pédagogiques du formateur -->
            <div class="experiences title">
                Expériences pédagogiques :
            </div>
            <div class="experiences values">
                <ul>
                    <?php foreach ($pedagogicalExperience as $experience) : ?>
                        <li>
                            <p>Thème: <?php echo $experience['nom_theme']; ?></p>
                            <p>Public: <?php echo $experience['libelle_public']; ?></p>
                            <p>Volume Horaire Moyen par Session: <?php echo $experience['volume_h_moyen_session']; ?> heures</p>
                            <p>Nombre de Sessions Effectuées: <?php echo $experience['nb_session_effectuee']; ?></p>
                            <p>Commentaire: <?php echo $experience['commentaire']; ?></p>
                        </li>
                        <br>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Formulaire pour démarrer une discussion avec le formateur -->
            <form action="?controller=discussion&action=start_discussion" method="post">
                <input type="hidden" name="id_formateur" value="<?php echo $formateur['id_utilisateur']; ?>">

                <button id="search-button" type="submit">Discuter</button> <!-- Bouton pour démarrer la discussion -->
            </form>
        </div>
    </article>
</div>

<?php require "view_end.php"; ?>