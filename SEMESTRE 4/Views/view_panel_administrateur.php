<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="preconnect" href="https://fonts.googleapis.com"> <!-- le domaine des polices Google -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- le domaine de chargement des polices Google -->
<link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display&display=swap" rel="stylesheet" type='text/css'> <!-- Lien vers la police Red Hat Display -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"> <!-- Lien vers une autre police Google -->

<link rel="stylesheet" type="text/css" href="Content/css/admin.css"> <!-- Lien vers la feuille de style CSS pour l'administration -->

<div class="container"> <!-- Conteneur principal -->
    <div class="container-trending"> <!-- Conteneur pour les éléments tendance -->
        <div class="container-headline"> <!-- En-tête du conteneur tendance -->
            <span class="material-symbols-outlined">add_moderator</span> <!-- Icône d'ajout de modérateur -->
            Administrateur
        </div>
        <div class="container-description"> <!-- Description du conteneur tendance -->
            À modérer avec modération
        </div>
    </div>

    <header>
        <div class="tabs"> <!-- Onglets de navigation -->
            <a id="tab1" name="all" href="#tab1">
                <button class="tablinks" onclick="openCity(event, 'Formateurs')">Formateurs</button> <!-- Bouton pour les formateurs -->
            </a>
            <a id="tab2" name="developer" href="#tab2">
                <button class="tablinks" onclick="openCity(event, 'Activités')">Activités</button> <!-- Bouton pour les activités -->
            </a>
        </div>
    </header>

    <div class="tab-content-wrapper"> <!-- Conteneur pour le contenu des onglets -->

        <div id="Formateurs" class="tabcontent"> <!-- Contenu de l'onglet "Formateurs" -->
            <div class="recent-orders"> <!-- Conteneur des dernières commandes -->
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Formations</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($formateurs as $formateur) { ?> <!-- Boucle sur les formateurs -->
                            <tr>
                                <td><?php echo $formateur['nom']; ?></td>
                                <td><?php echo $formateur['prenom']; ?></td>
                                <td>
                                    <?php if ($formateur['est_moderateur']) { ?> <!-- Vérifie si le formateur est modérateur -->
                                        <a href="?controller=panel&action=manage_moderator&id=<?php echo $formateur['id_utilisateur']; ?>&manage=demote">
                                            <button class="butto">
                                                <span>Rétrograder</span>
                                            </button>
                                        </a>
                                    <?php } else { ?>
                                        <a href="?controller=panel&action=manage_moderator&id=<?php echo $formateur['id_utilisateur']; ?>&manage=promote">
                                            <button class="butto">
                                                <span>Promouvoir</span>
                                            </button>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="#">Show All</a> <!-- Lien pour afficher tout -->
            </div>
        </div>

        <div id="Activités" class="tabcontent no"> <!-- Contenu de l'onglet "Activités" -->
            <div class="recent-orders"> <!-- Conteneur des dernières commandes -->
                <center>
                    <form action="?controller=panel&action=add_activity" method="post" enctype="multipart/form-data"> <!-- Formulaire pour ajouter une activité -->
                        <label for="name">Nom:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>

                        <label for="photo">Photo:</label>
                        <input type="file" id="photo" name="photo" accept="image/*" required>

                        <button class="button1" type="submit">Soumettre</button>
                    </form>
                </center>
            </div>
        </div>

    </div>
</div>
<script src="Content/script/admin.js"></script> 

<?php require "view_end.php"; ?> 
