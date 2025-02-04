<?php require "view_begin.php"; ?>
<?php require "view_menu.php"; ?> 

<link rel="stylesheet" href="Content/css/messages.css"> 

<div class="chat-global">

    <div class="nav-top">
        <div class="location">
            <a href="?controller=discussion">
                <img src="Content/img/left-chevron.svg"> <!-- Icône de retour -->
            </a>
        </div>

        <div class="utilisateur">
            <p><?= $nom_receiver ?></p> <!-- Affiche le nom du destinataire -->
            <p><?= $prenom_receiver ?></p> <!-- Affiche le prénom du destinataire -->
        </div>

        <div class="logos-call">
           <!-- Icônes d'appel, potentiellement à ajouter -->
        </div>
    </div>
    
    <div class="conversation">
		<!-- Boucle à travers chaque message -->
        <?php foreach ($messages as $message): ?> 
            <?php
                $isSender = ($message['id_utilisateur'] == $user_id); // Vérifie si l'utilisateur actuel est l'expéditeur
                $talkClass = $isSender ? 'right' : 'left'; // Définit la classe CSS en fonction de l'expéditeur
                $avatar = $isSender ? $photo_de_profil : $photo_receiver; // Sélectionne l'avatar approprié

                // Vérifie si le message nécessite une validation et si l'utilisateur est l'expéditeur
                $requiresValidation = (!$message['validation_moderation'] && $isSender);

                // Détermine la couleur du texte en fonction de la validation et de l'expéditeur
                $textColor = ($requiresValidation) ? 'yellow' : ($isSender ? 'white' : 'black');

                // Si l'utilisateur est modérateur, ignore la vérification
                if ($isModo) {
                    $requiresValidation = false;
                }

                // Si le message n'est pas validé et l'utilisateur n'est ni expéditeur ni modérateur, saute le message
                if (!$isModo && (!$message['validation_moderation'] && !$isSender)) {
                    continue;
                }
            ?>
            <div class="talk <?= $talkClass ?>"> <!-- Conteneur de message, positionné à gauche ou à droite -->
                <?php if ($talkClass === 'left'): ?> <!-- Avatar affiché à gauche pour les messages reçus -->
                    <img src="Content/img/<?= $avatar ?>" alt="User Photo">
                <?php endif; ?>
                <p style="color: <?= $textColor; ?>;"><?= $message['texte'] ?></p> <!-- Texte du message avec couleur dynamique -->
                <?php if ($isModo && !$message['validation_moderation']): ?> <!-- Lien de validation pour les modérateurs -->
                    <a href="?controller=discussion&action=validate_message&id_message=<?= $message['id_message'] ?>">Valider</a>
                <?php endif; ?>
                <?php if ($talkClass === 'right'): ?> <!-- Avatar affiché à droite pour les messages envoyés -->
                    <img src="Content/img/<?= $avatar ?>" alt="User Photo">
                <?php endif; ?>
            </div>
        <?php endforeach; ?> <!-- Fin de la boucle des messages -->
    </div>

    <form class="chat-form" method="post" action="?controller=discussion&action=envoi_message"> <!-- Formulaire pour envoyer un message -->

        <div class="container-inputs-stuffs">
           <input type="hidden" name="discussionId" value="<?= $_GET['id'] ?>"> <!-- Champ caché pour l'ID de la discussion -->

            <div class="files-logo-cont">
            </div>

            <div class="group-inp">
                <textarea name="texte_message" placeholder="Enter your message here" minlength="1" maxlength="1500"></textarea> <!-- Champ de texte pour le message -->
            </div>
            <button class="submit-msg-btn">
                <img src="Content/img/send.svg"> <!-- Bouton d'envoi avec icône -->
            </button>
        </div>

    </form>
</div>

<?php require "view_end.php"; ?> 
