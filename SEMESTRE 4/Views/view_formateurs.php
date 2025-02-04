<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/ravi_index.css" /> 
<link rel="stylesheet" href="Content/css/ravi_style.css"> 

<form method="post" action="?controller=formateurs"> <!-- Formulaire pour filtrer les formateurs -->

    <div id="search-container">
        <select id="search-input" name="select-options"> <!-- Sélecteur pour choisir une compétence -->
            <option value="0">Choisissez la compétence</option>
            <?php
            foreach ($categories as $category) { <!-- Parcours des catégories pour les options du sélecteur -->
                $selected = ($category['id_categorie'] == $selectedCategoryId) ? "selected" : ""; <!-- Vérifie si la catégorie est sélectionnée -->
                echo "<option value='" . $category['id_categorie'] . "' $selected>" . $category['nom_categorie'] . "</option>"; <!-- Affiche loption avec le nom de la catégorie -->
            }
            ?>
        </select>

        <button id="search-button" type="submit">Rechercher</button> <!-- Bouton de recherche -->
    </div>
    
    </br> <!-- Saut de ligne -->

    <div id="checkbox-container"> <!-- Conteneur pour les cases à cocher -->
        <?php
        // En supposant que $themes est un tableau de thèmes, et $selectedThemes est un tableau d'IDs de thèmes sélectionnés ou null
        if ($themes !== null) { <!-- Vérifie si des thèmes existent -->
            foreach ($themes as $theme) { <!-- Parcours des thèmes -->
                $isChecked = ($selectedThemes !== null && in_array($theme['id_theme'], $selectedThemes)) ? 'checked' : ''; <!-- Vérifie si le thème est sélectionné -->

                echo '<div class="checkbox-item">'; <!-- Affiche une case à cocher -->
                echo '<label for="theme-checkbox-' . $theme['id_theme'] . '">' . $theme['nom_theme'] . '</label>'; <!-- Affiche le nom du thème -->
                echo '<input type="checkbox" id="theme-checkbox-' . $theme['id_theme'] . '" name="selected-themes[]" value="' . $theme['id_theme'] . '" ' . $isChecked . '>'; <!-- Affiche la case à cocher -->
                echo '</div>'; <!-- Fin de la case à cocher -->
            }
        }
        ?>
    </div>

</form>

</br></br>

<div id="post"> <!-- Div pour le post -->
    <div>
        <span>Perform Vision : </span> 
        <span>Illuminer le chemin de tes objectifs, notre expertise est là pour t'aider à voir plus loin</span>
    </div>
</div>

<hr /> <!-- Ligne horizontale -->

<div id="centerCont">
    <div>
        <div id="feed">Formateurs</div> 
        <div>Nouveau</div> 
    </div>
</div>

<?php if ($formateurs !== null) : ?> <!-- Vérifie s'il y a des formateurs à afficher -->
    <?php foreach ($formateurs as $formateur) : ?> <!-- Parcours des formateurs -->
        <div class="formateurs-container"> <!-- Conteneur pour chaque formateur -->
            <article class="card"> <!-- Article représentant le formateur -->
                <div class='background'>
                    <img src="Content/img/<?= $formateur['photo_de_profil'] ?>" alt="Formateur Preview Image"> <!-- Image du formateur -->
                </div>
                <div class='content'>
                    <div class="card-header">
                        <div class="card-type">
                            <?= $formateur['category_name'] ?> <!-- Catégorie du formateur -->
                        </div>
                        <div class="latest-article">
                            <?= $formateur['theme_names'] ?> <!-- Thèmes du formateur -->
                        </div>
                    </div>

                    <div class="card-content">
                        <h2><?= $formateur['prenom'] . ' ' . $formateur['nom'] ?></h2> <!-- Nom complet du formateur -->
                        <p><?= $formateur['expertise_comment'] ?></p> <!-- Commentaire  -->
                    </div>
                    <br>
                    <a class="go-to-article-button" href="?controller=formateurs&action=details&id=<?= $formateur['id_utilisateur'] ?>" title="Details"> <!-- Lien pour voir les détails du formateur -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right"
                             width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                             fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l14 0" />
                            <path d="M15 16l4 -4" />
                            <path d="M15 8l4 4" />
                        </svg>
                    </a>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="listePages"> <!-- Div pour la pagination -->
    <p> Pages: </p> <!-- Indication de la pagination -->
    <?php if ($active > 1) : ?> <!-- Vérifie s'il y a une page précédente -->
        <a class="lienStart prev" href="?controller=formateurs&page=<?= e($active) - 1 ?>"> <img class="icone" src="Content/img/previous-icon.png" alt="Previous" /> </a> <!-- Lien vers la page précédente -->
    <?php endif ?>

    <?php for($p = $debut; $p <= $fin; $p++): ?> <!-- Boucle pour afficher les numéros de page -->
        <a class="<?= $p == $active ? "lienStart active" : "lienStart" ?>" href="?controller=formateurs&page=<?= $p ?>"> <?= $p ?> </a> <!-- Lien pour chaque page -->
    <?php endfor ?> 

    <?php if ($active < $nb_total_pages) : ?> <!-- Vérifie s'il y a une page suivante -->
        <a class="lienStart next" href="?controller=formateurs&page=<?= e($active) + 1 ?>"> <img class="icone" src="Content/img/next-icon.png" alt="Next" /> </a> <!-- Lien vers la page suivante -->
    <?php
