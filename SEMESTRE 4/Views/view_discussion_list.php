<?php require "view_begin.php"; ?> 
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/competence.css">

<br><br> 

<!-- section discussions -->
<div id="post"> 
    <div>
        <span><h1> MES DISCUSSIONS</h1></span> 
    </div>
</div>

<br> 

<?php foreach ($discussions as $discussionItem): ?> <!-- Boucle à travers chaque élément de discussion -->
    <div class="formateurs-container"> <!-- Conteneur pour chaque discussion -->
        <a href="?controller=discussion&action=discussion&id=<?= $discussionItem['discussion_id']; ?>" class="card-link"> <!-- Lien vers la discussion spécifique -->
            <article class="card"> <!-- Début de l'article de la discussion -->
                <div class='background'> 
                    <img src="Content/img/<?= $discussionItem['photo_interlocuteur']; ?>" alt="Profil de l'interlocuteur" class="profile-image"> <!-- Image de profil de l'interlocuteur -->
                </div>
                <div class='content'> <!-- Section du contenu de la carte -->
                    <div class="card-header"> <!-- En-tête de la carte -->
                        <div class="latest-article"> <!-- Indicateur de la dernière discussion -->
                            Vos discussions
                        </div>
                    </div>
                    <div class="card-content"> <!-- Contenu principal de la carte -->
                        <h2><?= $discussionItem['prenom_interlocuteur'] . ' ' . $discussionItem['nom_interlocuteur']; ?></h2> <!-- Nom et prénom de l'interlocuteur -->
                        <?php if ($discussionItem['unread_messages']): ?> <!-- Vérifie s'il y a des messages non lus -->
                            <p>
                                Vous avez des messages non lus.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        </a>
    </div>
<?php endforeach; ?>

<?php require "view_end.php"; ?>
